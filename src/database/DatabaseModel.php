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

        public function fetch() {
            $relations = static::relations();
            foreach ($relations as $relation) {
                if ($relation->relationship === DatabaseRelationship::ONE_TO_MANY) {
                    if (isset($this->{$relation->attrName})) {
                        $newElems = [];
                        foreach($this->{$relation->attrName} as $e) {
                            if ($e->getId() === 0) {
                                $newElems[] = $e;
                            }
                        }
                        $this->{$relation->attrName} = array_merge($newElems, $relation->class::get([$relation->fkAttr => $this->getId()]));
                    }
                    else 
                        $this->{$relation->attrName} = $relation->class::get([$relation->fkAttr => $this->getId()]);
                }
                if ($relation->relationship === DatabaseRelationship::MANY_TO_ONE) {
                    if (!isset($this->{$relation->attrName}) || $this->{$relation->attrName}->getId() !== 0) {
                        $this->{$relation->attrName} = $relation->class::getOne(['id' => $this->{$relation->fkAttr}]);
                    }
                }
            }
        }

        public function insert() {
            if ($this->id !== null)
                return false;

            $table = $this->table();
            $attributes = $this->attributes();

            $columns = [];
            $values = [];
            $types = [];

            $insertedIds = $this->upsertObjectChilds();

            foreach ($insertedIds as $key => $value) {
                $this->{$key} = $value;
            }

            foreach ($attributes as $key => $value) {
                if (isset($this->{$key})) {
                    $columns[] = $key;
                    $types[] = $value;
                }
            }

            $placeholders = array_fill(0, sizeof($columns), '?');

            $conn = Application::$db->getConnection();
            
            $query = "INSERT INTO $table (" . implode(',', $columns) . ") VALUES (" . implode(',', $placeholders) . ");";
            $statement = $conn->prepare($query);
            $typeString = implode('', $types);

            foreach ($columns as  $col) {
                if (isset($this->{$col}))
                    $values[] = $this->{$col};
            }

            $statement->bind_param($typeString, ...$values);
            $statement->execute();

            $this->id = $statement->insert_id;

            $this->upsertArrayChilds();

            return true;
        }

        private function upsertArrayChilds() {
            $relations = static::relations();
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

        public function upsert() {
            if ($this->id === null || !static::getOne(['id' => $this->id]))
                return $this->insert();
            return $this->update();
        }

        public function delete() {
            if ($this->id === null || !static::getOne(['id' => $this->id]))
                return false;
            
            $conn = Application::$db->getConnection();
            $table = static::table();
            $query = "DELETE FROM $table WHERE id = ?;";
            $statement = $conn->prepare($query);
            $statement->bind_param('i', $this->id);
            $statement->execute();
            $this->id = null;
        }

        public function update() {
            if ($this->id === null)
                return false;

            $table = $this->table();
            $attributes = $this->attributes();

            $columns = [];
            $values = [];
            $types = [];

            $insertedIds = $this->upsertObjectChilds();

            foreach ($insertedIds as $key => $value) {
                $this->{$key} = $value;
            }

            foreach ($attributes as $key => $value) {
                if (isset($this->{$key})) {
                    $columns[] = $key;
                    $types[] = $value;
                }
            }

            $conn = Application::$db->getConnection();
            
            $query = "UPDATE $table SET " . implode(' = ?,', $columns) . " = ? WHERE id = " . $this->id . ";";
            $statement = $conn->prepare($query);
            $typeString = implode('', $types);

            foreach ($columns as  $col) {
                if (isset($this->{$col}))
                    $values[] = $this->{$col};
            }

            $statement->bind_param($typeString, ...$values);
            $statement->execute();

            $this->upsertArrayChilds();

            return true;
        }

        public static function get($conditions = null, ?int $limit = null) {
            $table = static::table();
            $attributes = static::attributes();
            $conn = Application::$db->getConnection();
            $query = "SELECT * FROM $table";
            $statement = null;
            if (isset($conditions) && $conditions && sizeof($conditions) > 0) {
                foreach ($conditions as $key => $value) {
                    $columns[] = $key;
                    $values[] = $value;
                    if ($key !== 'id')
                        $types[] = $attributes[$key];
                    else 
                        $types[] = 'i';
                }

                $typeString = implode('', $types);
                
                $query .= " WHERE " . implode(' = ?,', $columns) . " = ?";
                if ($limit)
                    $query .= " LIMIT $limit";
                $query .= ';';
                $statement = $conn->prepare($query);

                $statement->bind_param($typeString, ...$values);
            } else {
                if ($limit)
                    $query .= " LIMIT $limit";
                $query .= ';';
                $statement = $conn->prepare($query);
            }

            $statement->execute();
            $result = $statement->get_result();
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            
            $results = array();

            foreach ($rows as $row) {
                $obj = new static();
                foreach ($row as $key => $col) {
                    if (property_exists($obj, $key)) {
                        $obj->$key = $col;
                    }
                }
                $results[] = $obj;
            }

            return $results;
        }

        public static function getOne($conditions = null) {
            $results = static::get($conditions, 1);
            if (sizeof($results) > 0) {
                return $results[0];
            }
            return false;
        }
    }
?>