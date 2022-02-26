<?php
    require_once dirname(__FILE__) . "/../src/database/DatabaseModel.php";
    require_once dirname(__FILE__) . "/../src/database/DatabaseEnums.php";
    require_once dirname(__FILE__) . "/../src/database/DatabaseRelation.php";
    
    require_once dirname(__FILE__) . '/../src/providers/AuthProvider.php';

    require_once dirname(__FILE__) . '/Post.php';

    class User extends DatabaseModel {
        /* Database attributes for User */
        public string $email = '';
        public string $username = '';
        // We put ? in front of the type to make it nullable
        public ?string $firstname = '';
        public ?string $lastname = '';
        public string $password = '';
        public string $passwordConfirm = '';
        public $date_of_birth = '';
        public bool $is_active;
        public ?string $confirmation_code;
        public $created_at;
        public $updated_at;
        public ?string $profile_picture = '';
        public ?string $status_message = '';

        // array relation with posts and comments
        public array $posts;
        public array $comments;

        protected static function relations(): array {
            // For a relation, we create a DatabaseRelation object and give it values for:
            // The attribute name
            // The table name in the database
            // The foreign key name
            // The type of relationship
            return [
                new DatabaseRelation("posts", Post::class, "user_id", DatabaseRelationship::ONE_TO_MANY),
                new DatabaseRelation("comments", Comment::class, "user_id", DatabaseRelationship::ONE_TO_MANY),
            ];
        }


        public function rules(): array {
            // The model rules, they will be checked using the validate() function
            return [
                'email' => [Rules::REQUIRED],
                'username' => [Rules::REQUIRED],
                'firstname' => [],
                'lastname' => [],
                'date_of_birth' => [Rules::REQUIRED],
                'password' => [Rules::REQUIRED, [Rules::MIN, 'min' => 8]],
                'passwordConfirm' => [Rules::REQUIRED, [Rules::MATCH, 'match' => 'password']],
            ];
        }

        protected static function table(): string
        {
            // The table name in the database
            return 'users';
        }

        protected static function attributes(): array
        {
            // We map the attributes and their type for the database
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

        public function register(){
            // We hash the password and insert the user in the database
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
            if (parent::insert()) {
                AuthProvider::login($this);
                return true;
            }
            return false;
        }

        public static function login($username, $password) {
            // We get a user by username
            $result = User::getOne(['username' => $username]);
            // We compare the password to its hash
            if ($result && password_verify($password, $result->password)) {
                AuthProvider::login($result);
                return $result;
            }
            return false;
        }
    }
?>