<?php
    require_once dirname(__FILE__) . '/../src/Controller.php';
    require_once dirname(__FILE__) . '/../src/Request.php';
    require_once dirname(__FILE__) . '/../src/Response.php';
    require_once dirname(__FILE__) . '/../models/Comment.php';
    
    require_once dirname(__FILE__) . '/../src/providers/AuthProvider.php';

    class CommentController extends Controller {
        // Pour ajouter un comment
        public function postComment(Request $request, Response $response) { //la ligne permet d'afficher les commentaires
            // Check if connected
            if (!AuthProvider::isAuthed())
                return $response->redirect('/');

            // Prend le corp de la requete
            $body = $request->getBody();
            // Qui est connecté?
            $user = AuthProvider::getSessionObject();
            // /posts/{post_id} <--- from there
            $post_id = $request->getRouteParam('post_id');
            // Créé un new commentaire
            $comment = new Comment();
            // On assigne les infos
            $comment->user_id = $user->getId();
            $comment->post_id = $post_id;
            $comment->body = $body["comment"];

            // variable à envoyer à la page
            $params = [];
            if (!$comment->upsert()) {
                $params['errorMessageId'] = 'unexpectedErrorAddComment';
            }
            // On redirige vers une route (remarque l'utilisation de $post_id)
            return $response->redirect(('/posts/' . $post_id), $params);
        }
    }
?>