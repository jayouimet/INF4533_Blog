<?php
    require_once dirname(__FILE__) . "/../src/database/DatabaseModel.php";
    require_once dirname(__FILE__) . "/../src/database/DatabaseEnums.php";
    require_once dirname(__FILE__) . "/../src/database/DatabaseRelation.php";
    require_once dirname(__FILE__) . '/Post.php';
    require_once dirname(__FILE__) . '/User.php';

    class Comment extends DatabaseModel {
        /* Database attributes for User */
        public ?int $post_id = null;
        public ?int $user_id = null;
        public string $body = "";

        public string $updated_at = "";
        public string $created_at = "";

        // Object relationship with post and user
        public Post $post;
        public User $user;

        // See User.php for comments
        protected static function relations(): array {
            return [
                new DatabaseRelation("post", Post::class, "post_id", DatabaseRelationship::MANY_TO_ONE),
                new DatabaseRelation("user", User::class, "user_id", DatabaseRelationship::MANY_TO_ONE),
            ];
        }


        public function rules(): array {
            return [
                'body' => [Rules::REQUIRED],
            ];
        }

        protected static function table(): string
        {
            return 'comments';
        }

        protected static function attributes(): array
        {
            return [
                'post_id' => DatabaseTypes::DB_INT,
                'user_id' => DatabaseTypes::DB_INT,
                'body' => DatabaseTypes::DB_TEXT
            ];
        }
    }
?>