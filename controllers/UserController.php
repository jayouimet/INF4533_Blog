<?php
    require_once dirname(__FILE__) . '/../src/Controller.php';
    require_once dirname(__FILE__) . '/../src/Request.php';
    require_once dirname(__FILE__) . '/../src/Response.php';

    require_once dirname(__FILE__) . '/../models/UserModel.php';
    require_once dirname(__FILE__) . '/../models/User.php';

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
            $user->firstname = 'Jeremie';
            $user->lastname = 'Ouimet';
            $user->password = "some''\M'Pwd";
            $user->age = 23;

            $user = User::getOne(['id' => '5']);
            var_dump($user);
            $users = User::get([], 5);
            var_dump($users);

            return $this->render('test', []);
        }
    }
?>