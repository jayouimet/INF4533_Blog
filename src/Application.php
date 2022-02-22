<?php
    require_once dirname(__FILE__) . '/Router.php';
    require_once dirname(__FILE__) . '/Request.php';
    require_once dirname(__FILE__) . '/Response.php';
    require_once dirname(__FILE__) . '/database/Database.php';

    class Application {
        /* Variables needed to run the APP */
        public static string $ROOT_DIR;
        public Router $router;
        public Request $request;
        public Response $response;

        /* The database connection */
        public static Database $db;

        /* The app itself */
        public static Application $app;

        /**
         * The constructor of the APP.
         *
         * @param mixed $rootPath   The root path for the app.
         * @param array $config     The config map.
         */
        public function __construct($rootPath, $config = []) {
            self::$ROOT_DIR = $rootPath;
            self::$app = $this;
            $this->request = new Request();
            $this->response = new Response();

            /* Creating the router based on if there's a baseUrl in the config map. */
            if (isset($config['baseUrl']))
                $this->router = new Router($this->request, $this->response, $config['baseUrl']);
            else
                $this->router = new Router($this->request, $this->response);

            /* To set the database config */
            if (isset($config['dbConfig'])) {
                self::$db = new Database($config['dbConfig']);
                self::$db->connect();
            }
        }

        /**
         * To run the app.
         *
         * @return void
         */
        public function run() {
            echo $this->router->resolve();
        }
    }
?>