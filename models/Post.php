<?php
    require_once dirname(__FILE__) . "/../src/database/DatabaseModel.php";
    require_once dirname(__FILE__) . "/../src/database/DatabaseRelation.php";
    require_once dirname(__FILE__) . "/../src/database/DatabaseEnums.php";
    require_once dirname(__FILE__) . '/User.php';
    require_once dirname(__FILE__) . '/Like.php';

    class Post extends DatabaseModel {
        /* Database attributes for the table posts */
        public string $title = '';
        public string $body = '';
        public ?int $user_id = null;

        public string $created_at;
        public string $updated_at;

        // Object relationship with user
        public User $user;
        // Array relationship with comments
        public array $comments;
        public array $likes;

        // See User.php for comments
        protected static function relations(): array {
            return [
                new DatabaseRelation("user", User::class, "user_id", DatabaseRelationship::MANY_TO_ONE),
                new DatabaseRelation("comments", Comment::class, "post_id", DatabaseRelationship::ONE_TO_MANY), 
                new DatabaseRelation("likes", Like::class, "post_id", DatabaseRelationship::ONE_TO_MANY),            
            ];
        }


        public function rules(): array {
            return [
                'title' => [Rules::REQUIRED],
                'body' => [Rules::REQUIRED],
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