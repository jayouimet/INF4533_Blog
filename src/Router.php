<?php
    require_once dirname(__FILE__) . '/Application.php';
    require_once dirname(__FILE__) . '/Request.php';
    require_once dirname(__FILE__) . '/Response.php';

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
            $this->routes['get'][strtolower($path)] = $callback;
        }

        public function post($path, $callback) {
            $this->routes['post'][strtolower($path)] = $callback;
        }

        private function tryGetDynamicCallBack() {
            // Get the path from the request
            $path = $this->request->getPath();
            // Get the method from the request, get or post
            $method = $this->request->getMethod();
            // We trim out the base url if it is setup
            if (substr($path, 0, strlen($this->baseUrl)) == $this->baseUrl) {
                $path = substr($path, strlen($this->baseUrl));
            }
            // Trim out the extra slash if there is one
            if (strlen($path) > 1)
                $path = rtrim($path, '/');
            // We make it case unsensitive
            $path = strtolower($path);

            $routes = $this->routes[$method] ?? [];

            $routeParams = false;

            foreach ($routes as $route => $callback) {
                $routeNames = [];

                if (preg_match_all('/\{([^}]+)?}/', $route, $matches)) {
                    $routeNames = $matches[1];
                }

                $routeRegex = "@^" . preg_replace('/\{\w+(:([^}]+))?}/', '(\w+)', $route) . "$@";

                if (preg_match_all($routeRegex, $path, $valueMatches)) {
                    $values = [];
                    for ($i = 1; $i < count($valueMatches); $i++) {
                        $values[] = $valueMatches[$i][0];
                    }
                    $routeParams = array_combine($routeNames, $values);
    
                    $this->request->setRouteParams($routeParams);
                    return $callback;
                }
            }

            return false;
        }

        public function resolve() {
            // Get the path from the request
            $path = $this->request->getPath();
            // Get the method from the request, get or post
            $method = $this->request->getMethod();
            // We trim out the base url if it is setup
            if (substr($path, 0, strlen($this->baseUrl)) == $this->baseUrl) {
                $path = substr($path, strlen($this->baseUrl));
            }
            // Trim out the extra slash if there is one
            if (strlen($path) > 1)
                $path = rtrim($path, '/');
            // We make it case unsensitive
            $path = strtolower($path);
            // Get the callback expression stored at this place in the array (see method get and post)
            $callback = $this->routes[$method][$path] ?? false;

            // If we can not find the route in our 2D array of routes, we return a 404
            if (!$callback) {
                $callback = $this->tryGetDynamicCallback();

                if (!$callback) {
                    $this->response->setStatusCode(404);
                    return $this->renderView($this->p404);
                }
            }
            
            $callback[0] = new $callback[0]();

            // Call the function and passes the request and response as parameters
            return call_user_func($callback, $this->request, $this->response);
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