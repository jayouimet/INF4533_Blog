<?php
    require_once dirname(__FILE__) . '/../src/Request.php';
    require_once dirname(__FILE__) . '/../src/Response.php';

    class DatabaseController extends Controller {
        /**
         * Function called when trying to use the method Get on the home page
         *
         * @param Request $request
         * @param Response $response
         * @return void
         */
        public function getUp(Request $request, Response $response) {
            require_once dirname(__FILE__) . '/../scripts/migrate_up.php';

            $params = [
                'name' => "Migrated up"
            ];

            return $this->render('home', $params);
        }

        public function getDown(Request $request, Response $response) {
            require_once dirname(__FILE__) . '/../scripts/migrate_down.php';

            $params = [
                'name' => "Migrated down"
            ];

            return $this->render('home', $params);
        }
    }
?>