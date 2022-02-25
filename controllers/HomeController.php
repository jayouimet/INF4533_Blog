<?php
    require_once dirname(__FILE__) . '/../src/Controller.php';
    require_once dirname(__FILE__) . '/../src/Request.php';
    require_once dirname(__FILE__) . '/../src/Response.php';

    require_once dirname(__FILE__) . '/../models/User.php';

    class HomeController extends Controller {
        /**
         * Function called when trying to use the method Get on the home page
         *
         * @param Request $request
         * @param Response $response
         * @return void
         */
        public function getHome(Request $request, Response $response) {
            $user = AuthProvider::getSessionObject();
            $params = [
                'currentUser' => $user,
                'users' => User::get()
            ];

            // $_SESSION["test"] = "testSession";
            /*if (isset($_SESSION['test'])) {
                unset($_SESSION['test']);
            }*/

            return $this->render('home', $params);
        }
    }
?>