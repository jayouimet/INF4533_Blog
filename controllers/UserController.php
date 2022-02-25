<?php
    require_once dirname(__FILE__) . '/../src/Controller.php';
    require_once dirname(__FILE__) . '/../src/Request.php';
    require_once dirname(__FILE__) . '/../src/Response.php';

    require_once dirname(__FILE__) . '/../src/providers/AuthProvider.php';

    require_once dirname(__FILE__) . '/../models/UserModel.php';
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
            return $this->render('users/adduser', []);
        }

        /**
         * Function called when trying to use the method POST on the user page
         *
         * @param Request $request The request
         * @param Response $response The response
         * @return void
         */
        public function postRegister(Request $request, Response $response) {
            /* We try to save the user sent from the request.body */
            $user = new User();

            $user->loadData($request->getBody());
            
            if($user->validate() && $user->register()){
                $response->redirect('/');
            }
            $params = [
                'user' => $user
            ];
            return $this->render('users/adduser', $params);
        }

        public function login(Request $request, Response $response) {
            /* We try to save the user sent from the request.body */
            $body = $request->getBody();
            if (!isset($body['username']) && !isset($body['password'])) {
                return $this->render('users/loginForm', []);
            }

            try {
                $user = User::login($body['username'], $body['password']);

                if ($user) {
                    $response->redirect('/');
                }

                throw new Exception("Username/password did not match.");
            }
            catch (Exception $e) {
                $params = [
                    'errorMessageId' => "invalidCredentials"
                ];
                return $this->render('users/loginForm', $params);
            }           
        }

        public function postLogout(Request $request, Response $response) {
            AuthProvider::logout();
            return $response->redirect('/');
        }

        public function test(Request $request, Response $response) {
            /*$user = new User();
            $user->username = 'jayouimet';
            $user->email = 'jayouimet@hotmail.com';
            $user->firstname = 'Jeremie';
            $user->lastname = 'Ouimet';
            $user->password = "some''\M'Pwd";
            $user->date_of_birth = date("Y-m-d");
            $user->confirmation_code = 'TEST';

            $post1 = new Post();
            $post1->title = 'Some nice title';
            $post1->body = 'Some nice body';

            $post2 = new Post();
            $post2->title = 'Some nice title 2';

            $user->posts[] = $post1;
            $user->posts[] = $post2;

            $user->insert();

            $user->fetch();
            var_dump($user);
            foreach($user->posts as $p) {
                $p->fetch();
                var_dump($p);
            }
            var_dump($user);*/

            $user = User::getOne(['id' => 6]);
            $user->confirmation_code = 'TEST123';
            $user->update();
            var_dump($user);

            return $this->render('test', []);
        }
    }
?>