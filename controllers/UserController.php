<?php
    require_once dirname(__FILE__) . '/../src/Controller.php';
    require_once dirname(__FILE__) . '/../src/Request.php';
    require_once dirname(__FILE__) . '/../src/Response.php';

    require_once dirname(__FILE__) . '/../src/providers/AuthProvider.php';

    require_once dirname(__FILE__) . '/../models/User.php';
    require_once dirname(__FILE__) . '/../models/Post.php';
    require_once dirname(__FILE__) . '/../models/Comment.php';

    class UserController extends Controller {
        /**
         * Function called when trying to use the method GET on the user page
         *
         * @param Request $request The request
         * @param Response $response The response
         * @return void
         */
        public function getRegister(Request $request, Response $response) {
            // Is the user is authentified (connected) we redirect him to the home page           
            if (AuthProvider::isAuthed()) {
                return $response->redirect('/');
            }
            // Otherwise we render the registration page
            return $this->render('pages/users/register', ["user" => new User()]);
        }

        /**
         * Function called when trying to use the method POST on the user page
         *
         * @param Request $request The request
         * @param Response $response The response
         * @return void
         */
        public function postRegister(Request $request, Response $response) { //permet d'entrer ses infos pour se crée un compte
            if (AuthProvider::isAuthed()) { 
                return $response->redirect('/'); //redirige à la page d'accueil
            }
            
            /* We try to save the user sent from the request.body */
            $user = new User();

            $user->loadData($request->getBody());
            
            if($user->validate() && $user->register()){
                $response->redirect('/');
            }
            $params = [
                'user' => $user
            ];
            return $this->render('pages/users/register', $params);
        }

        public function login(Request $request, Response $response) { //permet d'entrer ses infos 
            // Correction: Si déjà connecté
            if (AuthProvider::isAuthed()) { //si le user s'était déjà connecté auparavant, il peut pas se connecter de nouveau
                return $response->redirect('/'); //redirige à la page d'accueil
            }
            
            /* We try to save the user sent from the request.body */
            $body = $request->getBody();
            if (!isset($body['username']) && !isset($body['password'])) {
                return $this->render('pages/users/login', []);
            }

            try {
                $user = User::login($body['username'], $body['password']); //connect l'utilisateur à l'aide de ses infos 

                if ($user) {
                    return $response->redirect('/');
                }

                throw new Exception("Username/password did not match."); //crée un exception que les infos rentrées ne sont pas les bonnes
            }
            catch (Exception $e) { //si l'exception est rencontré, ça affiche un message d'erreur
                $params = [
                    'errorMessageId' => "invalidCredentials" 
                ];
                return $this->render('pages/users/login', $params); //redirige à la page de connection
            }           
        }

        public function postLogout(Request $request, Response $response) { //déconnecte le user de son compte
            AuthProvider::logout();
            return $response->redirect('/'); //redirige à la page d'accueil
        }
    }
?>