<?php
    require_once 'Application.php';
    require_once 'Request.php';
    require_once 'Response.php';

    class Router {
        public Request $request;
        public Response $response;
        public string $baseUrl;
        private array $routes = [];
        private string $p404;

        public static Router $router;

        public function __construct($request, $response, $baseUrl = '') {
            $this->request = $request;
            $this->response = $response;
            $this->baseUrl = $baseUrl;
            $this->p404 = "404";
            self::$router = $this;
        }

        public function get($path, $callback) {
            $this->routes['get'][$path] = $callback;
        }

        public function post($path, $callback) {
            $this->routes['post'][$path] = $callback;
        }

        public function resolve() {
            $path = $this->request->getPath();
            $method = $this->request->getMethod();

            if (substr($path, 0, strlen($this->baseUrl)) == $this->baseUrl) {
                $path = substr($path, strlen($this->baseUrl));
            }

            if (!isset($this->routes[$method][$path])) {
                $this->response->setStatusCode(404);
                return $this->renderView($this->p404);
            }

            $callback = $this->routes[$method][$path];

            if (is_string($callback)) {
                return $this->renderView($callback);
            }

            if (is_array($callback)) {
                $callback[0] = new $callback[0]();
            }

            return call_user_func($callback, $this->request);
        }

        public function renderView($view, $params = []) {
            $layoutContent = $this->layoutContent();
            $viewContent = $this->renderOnlyView($view, $params);
            return str_replace('{{content}}', $viewContent, $layoutContent);
        }

        public function renderContent($viewContent) {
            $layoutContent = $this->layoutContent();
            return str_replace('{{content}}', $viewContent, $layoutContent);
        }

        public function set404($p404) {
            $this->p404 = $p404;
        }

        private function layoutContent() {
            ob_start();
            include_once Application::$ROOT_DIR . "/views/layouts/main.php";
            return ob_get_clean();
        }

        private function renderOnlyView($view, $params) {
            extract($params, EXTR_OVERWRITE);
            ob_start();
            include_once Application::$ROOT_DIR . "/views/$view.php";
            return ob_get_clean();
        }
    }
?>