<?php
    /**
     * This class is used to handle the request from a client.
     */
    class Request {
        private array $routeParams = [];

        /**
         * Function to get the actual path of the page.
         *
         * @return string|false
         */
        public function getPath() {
            $path = $_SERVER["REQUEST_URI"] ?? '/';
            $pos = strpos($path, '?');
            if ($pos === false) {
                return $path;
            }
            return substr($path, 0, $pos);
        } 

        /**
         * Function to get the method used to access the path.
         *
         * @return string
         */
        public function getMethod() {
            return strtolower($_SERVER["REQUEST_METHOD"]);
        }

        /**
         * Function to get the body of a request. 
         * Generally a map of key-value pairs.
         *
         * @return array
         */
        public function getBody() {
            $body = [];

            if ($this->getMethod() === 'get') {
                foreach ($_GET as $key => $value) {
                    $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }

            if ($this->getMethod() === 'post') {
                foreach ($_POST as $key => $value) {
                    $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }

            return $body;
        }

        /**
         * Function to set parameters to a route.
         *
         * @param mixed $params
         * @return Request
         */
        public function setRouteParams($params) {
            $this->routeParams = $params;
            return $this;
        }

        /**
         * Function to get the parameter(s) of the route.
         *
         * @return array
         */
        public function getRouteParams() {
            return $this->routeParams;
        }

        /**
         * Function to get the value of a specific parameter of the route.
         *
         * @param string|mixed $param
         * @param ?mixed $default
         * @return mixed
         */
        public function getRouteParam($param, $default = null) {
            return $this->routeParams[$param] ?? $default;
        }
    }
?>