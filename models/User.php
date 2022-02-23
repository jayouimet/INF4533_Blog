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

        public array $posts;
        public array $comments;

        /* Get all the post from this user */
        /*public function fetch() {
            if (isset($posts))
                $this->posts = array_merge(array_filter($this->posts, "newElem"), Post::get(['user_id' => $this->getId()]));
            else 
                $this->posts =  Post::get(['user_id' => $this->getId()]);
        }*/

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
            return 'users';
        }

        protected static function attributes(): array
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
            if ($this->insert()) {
                AuthProvider::login($this);
                return true;
            }
            return false;
        }

        public function login() {
            
        }
    }
?>