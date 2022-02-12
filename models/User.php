<?php
    require_once dirname(__FILE__) . "/../src/database/DatabaseModel.php";

    class User extends DatabaseModel {
        public string $firstname = '';
        public string $lastname = '';
        public string $password = '';
        public string $passwordConfirm = '';
        public int $age = 0;

        public function rules(): array {
            return [
                'firstname' => [Rules::REQUIRED],
                'lastname' => [Rules::REQUIRED],
                'age' => [Rules::REQUIRED, [Rules::MIN_VAL, 'min' => 0], [Rules::MAX_VAL, 'max' => 200]],
                'password' => [Rules::REQUIRED, [Rules::MIN, 'min' => 8]],
                'passwordConfirm' => [Rules::REQUIRED, [Rules::MATCH, 'match' => 'password']],
            ];
        }

        public static function table(): string
        {
            return 'users';
        }

        public static function attributes(): array
        {
            return [
                'firstname' => DatabaseTypes::DB_TEXT, 
                'lastname' => DatabaseTypes::DB_TEXT, 
                'password' => DatabaseTypes::DB_TEXT, 
                'age' => DatabaseTypes::DB_INT
            ];
        }

        public function insert() {
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
            return parent::insert();
        }

        public function register(){
            // new user created
            return true;
        }

        public function login() {
            
        }
    }
?>