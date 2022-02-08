<?php
    require_once '../src/Controller.php';
    require_once '../models/UserModel.php';

    class TestController extends Controller {
        public function getTest(Request $request) {
            Application::$app->migrate();
            return $this->render('test');
        }
    }
?>