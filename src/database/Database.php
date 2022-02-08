<?php
    require_once 'MigrationManager.php';

    class Database {
        private $servername;
        private $username;
        private $password;
        private $databasename;

        private $conn;

        private MigrationManager $migrationManager;

        public function __construct($config = []) {
            if (isset($config['servername']))
                $this->servername = $config['servername'];
            if (isset($config['username']))
                $this->username = $config['username'];
            if (isset($config['password']))
                $this->password = $config['password'];
            if (isset($config['databasename']))
                $this->databasename = $config['databasename'];

            $this->migrationManager = new MigrationManager();
        }

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

        public function getConnection() {
            return $this->conn;
        }

        public function migrate() {
            $this->migrationManager->applyUpMigrations();
        }
    }
?>