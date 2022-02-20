<?php
    require_once dirname(__FILE__) . '/../src/Controller.php';
    require_once dirname(__FILE__) . '/../src/Request.php';
    require_once dirname(__FILE__) . '/../src/Response.php';

    class HomeController extends Controller {
        /**
         * Function called when trying to use the method Get on the home page
         *
         * @param Request $request
         * @param Response $response
         * @return void
         */
        public function getHome(Request $request, Response $response) {
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