<?php
    class Response {
        public function setStatusCode(int $code) {
            http_response_code($code);
        }

        public function redirect($route) {
            header("Location: " . Application::$app->router->baseUrl . $route);
            die;
        }
    }
?>