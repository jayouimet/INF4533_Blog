<?php
    require_once dirname(__FILE__) . '/MigrationManager.php';

    class Database {
        /* Needed variable declarations for the database */
        private $servername;
        private $username;
        private $password;
        private $databasename;

        /* The connection to the database */
        private $conn;

        /**
         * The constructor of Database. 
         *
         * @param array $config     Array of configs to initiate the database
         */
        public function __construct($config = []) {
            if (isset($config['servername']))
                $this->servername = $config['servername'];
            if (isset($config['username']))
                $this->username = $config['username'];
            if (isset($config['password']))
                $this->password = $config['password'];
            if (isset($config['databasename']))
                $this->databasename = $config['databasename'];
        }

        /**
         * Initiate the connection between the MySQL database and this app.
         *
         * @return mixed    Returns the connection variable.
         */
        public function connect() {
            if ($this->databasename !== "")
                $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->databasename);
            else
                $this->conn = new mysqli($this->servername, $this->username, $this->password);

            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }

            return $this->conn;
        }

        /**
         * To get the connection variable.
         *
         * @return mixed    The connection.
         */
        public function getConnection() {
            return $this->conn;
        }
    }
?>