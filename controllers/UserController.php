<?php
    require_once '../src/Controller.php';
    require_once '../models/UserModel.php';

    class UserController extends Controller {
        public function getRegister(Request $request) {
            $userModel = new UserModel();
            $params = [
                'model' => $userModel
            ];
            return $this->render('user', $params);
        }

        public function postRegister(Request $request) {
            $userModel = new UserModel();
            $userModel->loadData($request->getBody());

            if($userModel->validate() && $userModel->register()){
                header("Location: /INF4533_Blog/");
                die;
            }

            $params = [
                'model' => $userModel
            ];
            return $this->render('user', $params);
        }
    }
?>