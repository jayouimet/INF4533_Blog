<?php
    require_once dirname(__FILE__) . '/../src/Controller.php';
    require_once dirname(__FILE__) . '/../src/Request.php';
    require_once dirname(__FILE__) . '/../src/Response.php';
    require_once dirname(__FILE__) . '/../models/Comment.php';

    class CommentController extends Controller {
        /**
         * Function called when trying to use the method Get on the home page
         *
         * @param Request $request
         * @param Response $response
         * @return void
         */
        public function getAddComment(Request $request, Response $response) {
            return $this->render('comments/addcomment', []);
        }

        public function postAddComment(Request $request, Response $response) {
            $body = $request->getBody();

            $user_id = 6;
            $post_id = 30;

            $comment = new Comment();
            $comment->user_id = $user_id;
            $comment->post_id = $post_id;
            $comment->body = $body["comment"];

            $comment->upsert();

            var_dump($comment);

            return $this->render('comments/addcomment', []);
        }
    }
?>