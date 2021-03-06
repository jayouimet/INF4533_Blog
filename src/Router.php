<?php
    require_once dirname(__FILE__) . '/Application.php';
    require_once dirname(__FILE__) . '/Request.php';
    require_once dirname(__FILE__) . '/Response.php';

    /**
     * The router class is used to manage routes in the website.
     * For example, we create the route '/' to be the home page when we call the method GET on it.
     */
    class Router {
        /* Necessary variables for the router */
        public Request $request;
        public Response $response;
        public string $baseUrl;
        private array $routes = [];
        private string $p404;

        /* The router to be accessed from anywhere */
        public static Router $router;

        public function __construct($request, $response, $baseUrl = '') {
            $this->request = $request;
            $this->response = $response;
            $this->baseUrl = $baseUrl;
            $this->p404 = "404";
            self::$router = $this;
        }

        /**
         * This method creates a route on a specific $path using the method GET.
         *
         * @param string $path
         * @param array $callback
         * @return void
         */
        public function get($path, $callback) {
            $this->routes['get'][strtolower($path)] = $callback;
        }

        /**
         * This method creates a route on a specific $path using the method POST.
         *
         * @param string $path
         * @param array $callback
         * @return void
         */
        public function post($path, $callback) {
            $this->routes['post'][strtolower($path)] = $callback;
        }

        /**
         * This function is used to be able to use dynamic URL.
         * Example : GET on /posts/{id}. Here, it will create a different response depending on the value id.
         *
         * @return callback|false
         */
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

            // Take the routes of the given method
            $routes = $this->routes[$method] ?? [];

            $routeParams = false;

            // For each route in all routes of the method, we check if it's a dynamic route.
            foreach ($routes as $route => $callback) {
                $routeNames = [];

                // Check if the route contains '/{"SOMETHING HERE"}/' and try to get the property affected by dynamic routing.
                if (preg_match_all('/\{([^}]+)?}/', $route, $matches)) {
                    $routeNames = $matches[1];
                }

                // Create a route that is conform to RegEx by replacing all '/{"SOMETHING HERE"}/' by '(\w+)'.
                $routeRegex = "@^" . preg_replace('/\{\w+(:([^}]+))?}/', '(\w+)', $route) . "$@";

                // Check if the path is really used as a dynamic route.
                if (preg_match_all($routeRegex, $path, $valueMatches)) {
                    $values = [];
                    
                    // Check all dynamic variables and put their values into values array.
                    for ($i = 1; $i < count($valueMatches); $i++) {
                        $values[] = $valueMatches[$i][0];
                    }

                    // Combine the attribute name with their respective values for this call.
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
                // We try to find if the route is dynamic and if it's not, we return a 404
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

        /**
         * This function is used to render a view with parameters.
         *
         * @param mixed $view
         * @param array $params
         * @return array|string
         */
        public function renderView($view, $params = []) {
            // Get the content from the requested view and put it into the accessed page.
            $layoutContent = $this->layoutContent();
            $viewContent = $this->renderOnlyView($view, $params);
            $viewSources = $this->renderOnlySources($view);
            $layoutContent = str_replace('{{sources}}', $viewSources, $layoutContent);
            return str_replace('{{content}}', $viewContent, $layoutContent);
        }

        /**
         * This function is used to render a content (a view without parameters).
         *
         * @param mixed $viewContent
         * @return array|string
         */
        public function renderContent($viewContent) {
            $layoutContent = $this->layoutContent();
            return str_replace('{{content}}', $viewContent, $layoutContent);
        }

        /**
         * Set the default page 404 to $p404.
         *
         * @param mixed $p404
         * @return void
         */
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
            include_once Application::$ROOT_DIR . "/views/$view/content.php";
            return ob_get_clean();
        }

        private function renderOnlySources($view) {
            ob_start();
            include_once Application::$ROOT_DIR . "/views/$view/sources.php";
            return ob_get_clean();
        }
    }
?>