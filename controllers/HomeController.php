<?php
    require_once '../src/Controller.php';

    class HomeController extends Controller {
        public function getHome(Request $request) {
            $params = [
                'name' => "TestName"
            ];
            return $this->render('home', $params);
        }
    }
?>