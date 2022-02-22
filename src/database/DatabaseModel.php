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

        public function insert() {
            if ($this->id !== null)
                return false;

            $table = $this->table();
            $attributes = $this->attributes();

            $columns = [];
            $values = [];
            $types = [];

            $insertedIds = $this->insertObjectChilds();

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

            $this->insertArrayChilds();

            return true;
        }

        private function insertArrayChilds() {
            $relations = static::relations();
            foreach ($relations as $relation) {
                if ($relation->relationship === DatabaseRelationship::ONE_TO_MANY) {
                    $attrName = $relation->attrName;
                    $childs = $this->$attrName;
                    if (isset($childs) && sizeof($childs) > 0){
                        foreach ($childs as $child) {
                            $fkAttr = $relation->fkAttr;
                            $child->$fkAttr = $this->id;
                            $child->upsert();
                        }
                    }
                }
            }
        }

        private function insertObjectChilds() {
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
            return true;
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

        // TODO: Update

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