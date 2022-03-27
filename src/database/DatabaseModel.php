<?php
    include_once dirname(__FILE__) . "/../Model.php";
    include_once dirname(__FILE__) . "/../Application.php";
    include_once dirname(__FILE__) . "/DatabaseEnums.php";
    require_once dirname(__FILE__) . "/DatabaseRelation.php";

    abstract class DatabaseModel extends Model {
        private ?int $id = null;

        /**
         * Get the table name of the model in the DataBase
         *
         * @return string Table name
         */
        abstract protected static function table(): string;

        /**
         * Get all attributes of this table
         *
         * @return array Array of all the attributes
         */
        abstract protected static function attributes(): array;
        
        /**
         * Get all relations of this table in the database
         *
         * For a relation, we create a DatabaseRelation object and give it values for:
         * 
         * [The attribute name,
         * The table name in the database,
         * The foreign key name,
         * The type of relationship]
         * 
         * @return array Array of table that has relations to this table
         */
        abstract protected static function relations(): array;

        /**
         * Get ID
         *
         * @return int ID
         */
        public function getId() : int {
            return $this->id;
        }

        /**
         *  Set the ID.
         *  Protected function.
         * 
         * @param int $id
         * @return void
         */
        protected function setId(int $id) {
            $this->id = $id;
        }

        /**
         * Function to get the relations attribute of a Model in the database.
         *
         * @return void
         */
        public function fetch() {
            $relations = static::relations();
            // Depending on the relationship of the field, we will process it differently.
            foreach ($relations as $relation) {
                // If the relationship is 1 - *
                if ($relation->relationship === DatabaseRelationship::ONE_TO_MANY) {
                    // If the attribute is already set, get all new elements (not in database) and merge them 
                    // with the relations values from the database.
                    if (isset($this->{$relation->attrName})) {
                        $newElems = [];
                        foreach($this->{$relation->attrName} as $e) {
                            if ($e->getId() === 0) {
                                $newElems[] = $e;
                            }
                        }
                        $this->{$relation->attrName} = array_merge($newElems, $relation->class::get([$relation->fkAttr => $this->getId()]));
                    }
                    // Else, only get the relations values from the database.
                    else 
                        $this->{$relation->attrName} = $relation->class::get([$relation->fkAttr => $this->getId()]);
                }
                // If the relationship is * - 1 and the attribute is not set in the model or the attribute is already in the database
                // get the value of the relation and put it into the model.
                if ($relation->relationship === DatabaseRelationship::MANY_TO_ONE) {
                    if (!isset($this->{$relation->attrName}) || $this->{$relation->attrName}->getId() !== 0) {
                        $this->{$relation->attrName} = $relation->class::getOne(['id' => $this->{$relation->fkAttr}]);
                    }
                }
            }
        }

        /**
         * Function to insert the Model into the database as a row.
         *
         * @return true|false
         */
        public function insert() {
            // If the id isn't null, then it's already in the database. So we quit the function.
            if ($this->id !== null)
                return false;

            $table = $this->table();
            $attributes = $this->attributes();

            $columns = [];
            $values = [];
            $types = [];

            // Get all upserted IDs from all * to 1 relations attribute.
            $insertedIds = $this->upsertObjectChilds();

            // Set the attribute with the upserted id.
            foreach ($insertedIds as $key => $value) {
                $this->{$key} = $value;
            }

            // Check all attributes on if they are set in the Model. If they are, 
            // we add the attribute name into $columns and we add the types of attribute into $types
            foreach ($attributes as $key => $value) {
                if (isset($this->{$key})) {
                    $columns[] = $key;
                    $types[] = $value;
                }
            }

            $placeholders = array_fill(0, sizeof($columns), '?');

            $conn = Application::$db->getConnection();
            
            // Put the placeholders and the columns of the Model into a insert query
            $query = "INSERT INTO $table (" . implode(',', $columns) . ") VALUES (" . implode(',', $placeholders) . ");";

            // Prepare the query
            $statement = $conn->prepare($query);

            // If there's no statement made from the query, throw Exception.
            if (!$statement) {
                throw new Exception("Couldn't create an sql statement with the provided values.");
            }
            // Put all attributes DatabaseTypes into a string.
            $typeString = implode('', $types);

            // Get the values of all set attribute in the Model.
            foreach ($columns as  $col) {
                if (isset($this->{$col}))
                    $values[] = $this->{$col};
            }

            // Bind all the parameters with their values and execute the statement.
            $statement->bind_param($typeString, ...$values);
            $statement->execute();

            $this->id = $statement->insert_id;

            if ($this->id == 0)
                return false;

            $this->upsertArrayChilds();

            return true;
        }

        /**
         * Function to upsert all 1 to * relations childs.
         *
         * @return void
         */
        private function upsertArrayChilds() {
            $relations = static::relations();
            // For each relation, if the relation is 1 - * and the attribute is set and the array is larger than 0,
            // we upsert each child in the attribute.
            foreach ($relations as $relation) {
                if ($relation->relationship === DatabaseRelationship::ONE_TO_MANY) {
                    $attrName = $relation->attrName;
                    if (isset($this->$attrName) && sizeof($this->$attrName) > 0) {
                        foreach ($this->$attrName as $child) {
                            $fkAttr = $relation->fkAttr;
                            $child->$fkAttr = $this->id;
                            $child->upsert();
                        }
                    }
                }
            }
        }

        /**
         * Function to upsert a * to 1 relation attribute.
         *
         * @return array
         */
        private function upsertObjectChilds() {
            $relations = static::relations();
            $ret = [];
            foreach ($relations as $relation) {
                if ($relation->relationship === DatabaseRelationship::MANY_TO_ONE) {
                    $attrName = $relation->attrName;
                    if (isset($this->$attrName)) {
                        $child = $this->$attrName;
                        if (isset($child)) {
                            $child->upsert();
                            $ret[$relation->fkAttr] = $child->getId();
                        }
                    }
                }
            }
            return $ret;
        }

        /**
         * Function to upsert the Model.
         *
         * @return bool
         */
        public function upsert() {
            if ($this->id === null || !static::getOne(['id' => $this->id]))
                return $this->insert();
            return $this->update();
        }

        /**
         * Function to delete the Model from the database.
         *
         * @return void
         */
        public function delete() {
            // If the Model doesnt exist in database, return false.
            if ($this->id === null || !static::getOne(['id' => $this->id]))
                return false;
            
            $conn = Application::$db->getConnection();
            $table = static::table();

            // Create the query to Delete
            $query = "DELETE FROM $table WHERE id = ?;";
            // Prepare the query
            $statement = $conn->prepare($query);
            // If there's no statement made from the query, return exception.
            if (!$statement) {
                throw new Exception("Couldn't create an sql statement with the provided values.");
            }
            // Bind param ID and execute.
            $statement->bind_param('i', $this->id);
            $statement->execute();
            $this->id = null;
        }

        /**
         * Function to update the values in a Model to the database.
         *
         * @return bool
         */
        public function update() {
            // If the model doesn't exist in database, return false
            if ($this->id === null)
                return false;

            $table = $this->table();
            $attributes = $this->attributes();

            $columns = [];
            $values = [];
            $types = [];

            // Get upserted ids from foreign tables.
            $insertedIds = $this->upsertObjectChilds();

            // Update all foreign attributes in the Model 
            foreach ($insertedIds as $key => $value) {
                $this->{$key} = $value;
            }

            // Add attributes types and names into 2 separate array
            foreach ($attributes as $key => $value) {
                if (isset($this->{$key})) {
                    $columns[] = $key;
                    $types[] = $value;
                }
            }

            $conn = Application::$db->getConnection();
            
            // Create the query to Update the model
            $query = "UPDATE $table SET " . implode(' = ?,', $columns) . " = ? WHERE id = " . $this->id . ";";
            // Prepare the query
            $statement = $conn->prepare($query);
            // If no statement can be made of the query, throw exception
            if (!$statement) {
                throw new Exception("Couldn't create an sql statement with the provided values.");
            }
            // Put attributes types into a string
            $typeString = implode('', $types);

            // Put attribute values into an array
            foreach ($columns as  $col) {
                if (isset($this->{$col}))
                    $values[] = $this->{$col};
            }

            // Bind params and execute the statement
            $statement->bind_param($typeString, ...$values);
            $statement->execute();

            if ($conn->errno) {
                return false;
            }

            $this->upsertArrayChilds();

            return true;
        }

        /**
         * Function to get all objects respecting all the conditions.
         *
         * @param mixed $conditions
         * @param integer|null $limit
         * @return array
         */
        public static function get($conditions = null, ?int $limit = null) {
            $table = static::table();
            $attributes = static::attributes();
            $conn = Application::$db->getConnection();

            // Make the query to select all rows from the table
            $query = "SELECT * FROM $table";
            $statement = null;

            if (isset($conditions) && $conditions && sizeof($conditions) > 0) {
                // Add all attributes of the condition into an array
                foreach ($conditions as $key => $value) {
                    $columns[] = $key;
                    $values[] = $value;
                    if ($key !== 'id')
                        $types[] = $attributes[$key];
                    else 
                        $types[] = 'i';
                }

                // Put all the types of the attributes into a string
                $typeString = implode('', $types);
                
                // Add conditions to query
                $query .= " WHERE " . implode(' = ? AND ', $columns) . " = ?";

                // If there's a limit, add that to the query
                if ($limit)
                    $query .= " LIMIT $limit";
                $query .= ';';
                // Prepare the query
                $statement = $conn->prepare($query);
                // If a statement can't be made with the query, throw exception
                if (!$statement) {
                    throw new Exception("Couldn't create an sql statement with the provided values.");
                }
                // Bind params
                $statement->bind_param($typeString, ...$values);
            } else {
                if ($limit)
                    $query .= " LIMIT $limit";
                $query .= ';';
                $statement = $conn->prepare($query);
                if (!$statement) {
                    throw new Exception("Couldn't create an sql statement with the provided values.");
                }
            }
            // Execute the statement
            $statement->execute();
            $result = $statement->get_result();
            // Get all rows
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            
            $results = array();
            
            foreach ($rows as $row) {
                // Create a new instance of the class who called this method (normally a model)
                $obj = new static();
                // Set all attributes to their value from the row
                foreach ($row as $key => $col) {
                    if (property_exists($obj, $key)) {
                        $obj->{$key} = $col;
                    }
                }
                $results[] = $obj;
            }

            return $results;
        }

        /**
         * Function to get the first element from the get() function above.
         *
         * @param mixed $conditions
         * @return DatabaseModel
         */
        public static function getOne($conditions = null) {
            $results = static::get($conditions, 1);
            if (sizeof($results) > 0) {
                return $results[0];
            }
            return false;
        }
    }
?>