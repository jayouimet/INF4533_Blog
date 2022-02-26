<?php
    require_once dirname(__FILE__) . '/../src/Controller.php';
    require_once dirname(__FILE__) . '/../src/Request.php';
    require_once dirname(__FILE__) . '/../src/Response.php';
    require_once dirname(__FILE__) . '/../models/Comment.php';
    
    require_once dirname(__FILE__) . '/../src/providers/AuthProvider.php';

    class CommentController extends Controller {
        // Pour ajouter un comment
        public function postComment(Request $request, Response $response) { //la ligne permet d'ajouter un commentaire à un post 
            // Check if connected
            if (!AuthProvider::isAuthed()) //permet de vérifier si on est bien connecté
                return $response->redirect('/');

            // Prend le corp de la requete
            $body = $request->getBody(); //permet de sélectionner le body de la requête
            // Qui est connecté?
            $user = AuthProvider::getSessionObject(); //vérifie quel user est connecté
            // /posts/{post_id} <--- from there
            $post_id = $request->getRouteParam('post_id'); //sélectionne la route depuis /posts/{post_id} pour afficher la bonne page 
            // Créé un new commentaire
            $comment = new Comment(); //pour créer un nouveau commentaire
            // On assigne les infos
            $comment->user_id = $user->getId(); //pour assigner les infos 
            $comment->post_id = $post_id;
            $comment->body = $body["comment"];

            // variable à envoyer à la page
            $params = []; //$ indique que c'est le nom d'une variable qui doit être envoyée à une page
            if (!$comment->upsert()) {
                $params['errorMessageId'] = 'unexpectedErrorAddComment'; 
            }
            // On redirige vers une route (remarque l'utilisation de $post_id)
            return $response->redirect(('/posts/' . $post_id), $params); //permet de rediriger vers une route qui mène au post où le commentaire a été laissé
        }
    }
?>