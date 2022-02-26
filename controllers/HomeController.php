<?php
    require_once dirname(__FILE__) . '/../src/Controller.php';
    require_once dirname(__FILE__) . '/../src/Request.php';
    require_once dirname(__FILE__) . '/../src/Response.php';
    require_once dirname(__FILE__) . '/../src/providers/AuthProvider.php';

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
            // We get the current authentified user
            $user = AuthProvider::getSessionObject();
            // Params represent the variables accessible through the file we render
            $params = [
                'currentUser' => $user,
                'users' => User::get(),
                'posts' => Post::get()
            ];

            return $this->render('pages/home', $params);
        }
    }
?>