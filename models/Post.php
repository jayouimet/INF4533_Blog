<?php
    require_once dirname(__FILE__) . "/../src/database/DatabaseModel.php";
    require_once dirname(__FILE__) . '/User.php';

    class Post extends DatabaseModel {
        /* Database attributes for the table posts */
        public string $title = '';
        public string $body = '';
        public int $likes = 0;
        public ?int $user_id = null;

        /**
         * Get the author of the post
         *
         * @return User The author
         */
        public function user() : User {
            return User::getOne(['id' => $this->user_id]);
        }

        protected static function relations(): array {
            return [
                'users' => DatabaseRelationship::MANY_TO_ONE
            ];
        }


        public function rules(): array {
            return [
                'title' => [Rules::REQUIRED],
                'body' => [],
            ];
        }

        protected static function table(): string
        {
            return 'posts';
        }

        protected static function attributes(): array
        {
            return [
                'title' => DatabaseTypes::DB_TEXT,
                'body' => DatabaseTypes::DB_TEXT,
                'likes' => DatabaseTypes::DB_INT,
                'user_id' => DatabaseTypes::DB_INT
            ];
        }
    }
?>