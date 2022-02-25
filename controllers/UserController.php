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
            if (AuthProvider::isAuthed()) {
                return $response->redirect('/');
            }
            
            return $this->render('pages/users/register', []);
        }

        /**
         * Function called when trying to use the method POST on the user page
         *
         * @param Request $request The request
         * @param Response $response The response
         * @return void
         */
        public function postRegister(Request $request, Response $response) {
            if (AuthProvider::isAuthed()) {
                return $response->redirect('/');
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

        public function login(Request $request, Response $response) {
            if (AuthProvider::isAuthed()) {
                return $response->redirect('/');
            }
            
            /* We try to save the user sent from the request.body */
            $body = $request->getBody();
            if (!isset($body['username']) && !isset($body['password'])) {
                return $this->render('pages/users/login', []);
            }

            try {
                $user = User::login($body['username'], $body['password']);

                if ($user) {
                    return $response->redirect('/');
                }

                throw new Exception("Username/password did not match.");
            }
            catch (Exception $e) {
                $params = [
                    'errorMessageId' => "invalidCredentials"
                ];
                return $this->render('pages/users/login', $params);
            }           
        }

        public function postLogout(Request $request, Response $response) {
            AuthProvider::logout();
            return $response->redirect('/');
        }
    }
?>