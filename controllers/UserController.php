<?php
    require_once dirname(__FILE__) . '/../src/Controller.php';
    require_once dirname(__FILE__) . '/../src/Request.php';
    require_once dirname(__FILE__) . '/../src/Response.php';

    require_once dirname(__FILE__) . '/../models/UserModel.php';
    require_once dirname(__FILE__) . '/../models/User.php';
    require_once dirname(__FILE__) . '/../models/Post.php';

    class UserController extends Controller {
        public function getRegister(Request $request, Response $response) {
            $userModel = new UserModel();
            $params = [
                'model' => $userModel
            ];
            return $this->render('user', $params);
        }

        public function postRegister(Request $request, Response $response) {
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
            $user = new User();
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

            $dbUser = User::getOne(['id' => 3]);

            var_dump($dbUser);
            var_dump($dbUser->getPosts());

            /*$user->delete();
            var_dump($user);
            $users = User::get([], 5);
            var_dump($users);*/

            return $this->render('test', []);
        }
    }
?>