<?php
    /**
     * The Response class is used to manage the response given by the server when a client request something from it.
     */
    class Response {
        /**
         * Function to set the status code (example : 404, 300).
         *
         * @param integer $code
         * @return void
         */
        public function setStatusCode(int $code) {
            http_response_code($code);
        }

        /**
         * Function to redirect to another page (path).
         *
         * @param string $route
         * @return void
         */
        public function redirect($route) {
            header("Location: " . Application::$app->router->baseUrl . $route);
            die;
        }
    }
?>