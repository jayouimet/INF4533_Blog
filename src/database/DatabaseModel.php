<?php
    include_once dirname(__FILE__) . "/../Model.php";
    include_once dirname(__FILE__) . "/../Application.php";

    abstract class DatabaseTypes
    {
        const DB_INT = 'i';
        const DB_FLOAT = 'd';
        const DB_TEXT = 's';
        const DB_BLOB = 'b';
    }

    abstract class DatabaseRelationship
    {
        const MANY_TO_ONE = 'MANY_TO_ONE';
        const ONE_TO_MANY = 'ONE_TO_MANY';
        const MANY_TO_MANY = 'MANY_TO_MANY';
    }

    abstract class DatabaseModel extends Model {
        private ?int $id = null;

        abstract protected static function table(): string;
        abstract protected static function attributes(): array;
        abstract protected static function relations(): array;

        public function getId() {
            return $this->id;
        }

        public function insert() {
            if ($this->id !== null)
                return false;

            $table = $this->table();
            $attributes = $this->attributes();

            $columns = [];
            $values = [];
            $types = [];

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

            return true;
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