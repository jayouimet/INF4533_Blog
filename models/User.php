<?php
    require_once dirname(__FILE__) . "/../src/database/DatabaseModel.php";

    class User extends DatabaseModel {
        public string $email = '';
        public string $username = '';
        public string $firstname = '';
        public string $lastname = '';
        public string $password = '';
        public string $passwordConfirm = '';
        public $date_of_birth = '';
        public bool $is_active;
        public string $confirmation_code;
        public $created_at;
        public $updated_at;


        public function rules(): array {
            return [
                'email' => [Rules::REQUIRED],
                'username' => [Rules::REQUIRED],
                'firstname' => [Rules::REQUIRED],
                'lastname' => [Rules::REQUIRED],
                'date_of_birth' => [Rules::REQUIRED],
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
                'username' => DatabaseTypes::DB_TEXT,
                'email' => DatabaseTypes::DB_TEXT,
                'firstname' => DatabaseTypes::DB_TEXT, 
                'lastname' => DatabaseTypes::DB_TEXT, 
                'password' => DatabaseTypes::DB_TEXT, 
                'date_of_birth' => DatabaseTypes::DB_TEXT,
                'is_active' => DatabaseTypes::DB_INT,
                'confirmation_code' => DatabaseTypes::DB_TEXT
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