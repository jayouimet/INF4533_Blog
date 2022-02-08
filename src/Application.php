<?php
    require_once 'Router.php';
    require_once 'Request.php';
    require_once 'Response.php';
    require_once 'database/Database.php';

    class Application {
        public static string $ROOT_DIR;
        public Router $router;
        public Request $request;
        public Response $response;

        public static Database $db;

        public static Application $app;

        public function __construct($rootPath, $config = []) {
            self::$ROOT_DIR = $rootPath;
            self::$app = $this;
            $this->request = new Request();
            $this->response = new Response();

            if (isset($config['baseUrl']))
                $this->router = new Router($this->request, $this->response, $config['baseUrl']);
            else
                $this->router = new Router($this->request, $this->response);

            if (isset($config['dbConfig'])) {
                self::$db = new Database($config['dbConfig']);
                self::$db->connect();
            }
        }

        public function run() {
            echo $this->router->resolve();
        }
    }
?>