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
            $user->username = 'jayouimet';
            $user->email = 'jayouimet@hotmail.com';
            $user->firstname = 'Jeremie';
            $user->lastname = 'Ouimet';
            $user->password = "some''\M'Pwd";
            $user->date_of_birth = date("Y-m-d");
            $user->confirmation_code = 'TEST';

            $user->insert();
            var_dump($user);
            $users = User::get([], 5);
            var_dump($users);
            /*$user->delete();
            var_dump($user);
            $users = User::get([], 5);
            var_dump($users);*/

            return $this->render('test', []);
        }
    }
?>