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
            $user->insert();
            var_dump($user);

            $post1 = new Post();
            $post1->title = 'Some nice title';
            $post1->body = 'Some nice body';
            $post1->user_id = $user->getId();
            $post1->insert();

            $post2 = new Post();
            $post2->title = 'Some nice title 2';
            $post2->user_id = $user->getId();
            $post2->insert();

            $users = User::get([], 5);
            var_dump($users);
            $posts = Post::get(['user_id' => $user->getId()], 5);
            var_dump($posts);

            var_dump($user->posts());
            var_dump($post1->user());
            var_dump($post2->user());
            /*$user->delete();
            var_dump($user);
            $users = User::get([], 5);
            var_dump($users);*/

            return $this->render('test', []);
        }
    }
?>