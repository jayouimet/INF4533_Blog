<?php
    require_once '../src/Controller.php';

    class HomeController extends Controller {
        public function getHome(Request $request) {
            $params = [
                'name' => "TestName"
            ];

            // $_SESSION["test"] = "testSession";
            /*if (isset($_SESSION['test'])) {
                unset($_SESSION['test']);
            }*/

            return $this->render('home', $params);
        }
    }
?>