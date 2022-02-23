<?php
    require_once dirname(__FILE__) . '/../src/Controller.php';
    require_once dirname(__FILE__) . '/../src/Request.php';
    require_once dirname(__FILE__) . '/../src/Response.php';

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
            /* Create a user model to then give it to the registration form */
            $userModel = new UserModel();
            $params = [
                'model' => $userModel
            ];
            return $this->render('user', $params);
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
            $userModel = new UserModel();
            $userModel->loadData($request->getBody());

            if($userModel->validate() && $userModel->register()){
                $response->redirect('/');
            }

            $params = [
                'model' => $userModel
            ];
            return $this->render('user', $params);
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

            $users = User::get();
            var_dump($users);

            return $this->render('test', []);
        }
    }
?>