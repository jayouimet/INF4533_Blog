<?php
    require_once dirname(__FILE__) . '/../src/Controller.php';
    require_once dirname(__FILE__) . '/../src/Request.php';
    require_once dirname(__FILE__) . '/../src/Response.php';
    require_once dirname(__FILE__) . '/../models/Comment.php';
    
    require_once dirname(__FILE__) . '/../src/providers/AuthProvider.php';

    class CommentController extends Controller {
        public function postComment(Request $request, Response $response) { //la ligne permet d'afficher les commentaires
            if (!AuthProvider::isAuthed())
                return $response->redirect('/');

            $body = $request->getBody();
            
            $user = AuthProvider::getSessionObject();
            $post_id = $request->getRouteParam('post_id');
            
            $comment = new Comment();

            $comment->user_id = $user->getId();
            $comment->post_id = $post_id;
            $comment->body = $body["comment"];

            $params = [];
            if (!$comment->upsert()) {
                $params['errorMessageId'] = 'unexpectedErrorAddComment';
            }

            return $response->redirect(('/posts/' . $post_id), $params);
        }
    }
?>