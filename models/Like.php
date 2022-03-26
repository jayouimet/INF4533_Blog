<?php
    require_once dirname(__FILE__) . "/../src/database/DatabaseModel.php";
    require_once dirname(__FILE__) . "/../src/database/DatabaseEnums.php";
    require_once dirname(__FILE__) . "/../src/database/DatabaseRelation.php";
    require_once dirname(__FILE__) . '/Post.php';
    require_once dirname(__FILE__) . '/User.php';
    require_once dirname(__FILE__) . '/Comment.php';

    class Like extends DatabaseModel {
        /* Database attributes for User */
        public ?int $comment_id = null;
        public ?int $post_id = null;
        public ?int $user_id = null;

        public string $updated_at = "";
        public string $created_at = "";

        // Object relationship with post and user
        public Comment $comment;
        public Post $post;
        public User $user;

        // See User.php for comments
        protected static function relations(): array {
            return [
                new DatabaseRelation("comment", Comment::class, "comment_id", DatabaseRelationship::MANY_TO_ONE),
                new DatabaseRelation("post", Post::class, "post_id", DatabaseRelationship::MANY_TO_ONE),
                new DatabaseRelation("user", User::class, "user_id", DatabaseRelationship::MANY_TO_ONE),
            ];
        }


        public function rules(): array {
            return [];
        }

        protected static function table(): string
        {
            return 'likes';
        }

        protected static function attributes(): array
        {
            return [
                'comment_id' => DatabaseTypes::DB_INT,
                'post_id' => DatabaseTypes::DB_INT,
                'user_id' => DatabaseTypes::DB_INT,
            ];
        }
    }
?>