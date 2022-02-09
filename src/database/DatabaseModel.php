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

    abstract class DatabaseModel extends Model {
        protected int $id;

        abstract public static function table(): string;
        abstract public function attributes(): array;

        public function getId() {
            return $this->id;
        }

        public function insert() {
            $table = $this->table();
            $attributes = $this->attributes();

            $columns = [];
            $values = [];
            $types = [];

            foreach ($attributes as $key => $value) {
                $columns[] = $key;
                $types[] = $value;
            }

            $placeholders = array_fill(0, sizeof($columns), '?');

            $conn = Application::$db->getConnection();

            $query = "INSERT INTO $table (" . implode(',', $columns) . ") VALUES (" . implode(',', $placeholders) . ");";
            $statement = $conn->prepare($query);
            $typeString = implode('', $types);

            foreach ($columns as  $col) {
                $values[] = $this->{$col};
            }

            var_dump($statement, $query);

            $statement->bind_param($typeString, ...$values);
            $statement->execute();

            return true;
        }
    }
?>