<?php
    require_once dirname(__FILE__) . '/../src/Controller.php';
    require_once dirname(__FILE__) . '/../src/Request.php';
    require_once dirname(__FILE__) . '/../src/Response.php';
    require_once dirname(__FILE__) . '/../models/Comment.php';
    
    require_once dirname(__FILE__) . '/../src/providers/AuthProvider.php';

    class CommentController extends Controller {
        public function postComment(Request $request, Response $response) { //la ligne permet d'ajouter un commentaire à un post 
            if (!AuthProvider::isAuthed()) //permet de vérifier si on est bien connecté
                return $response->redirect('/');

            $body = $request->getBody(); //permet de sélectionner le body de la requête
            $user = AuthProvider::getSessionObject(); //entrepose temporairement quel user est connecté
            $post_id = $request->getRouteParam('post_id'); //sélectionne le {post_id} depuis la route /posts/{post_id} pour afficher la bonne page 
            $comment = new Comment(); //pour créer un nouveau commentaire
            $comment->user_id = $user->getId(); //pour assigner les infos 
            $comment->post_id = $post_id;
            $comment->body = $body["comment"];

            $params = ["comment" => $comment]; //$ indique le tableau de variable qui doit être envoyée à une page
            if (!$comment->upsert()) { //si rien n'est update ou ajouté un message d'erreur affiche
                $params['errorMessageId'] = 'unexpectedErrorAddComment'; 
            }
            return $response->redirect(('/posts/' . $post_id), $params); //permet de rediriger vers une route qui mène au post où le commentaire a été laissé
        }
    }
?>