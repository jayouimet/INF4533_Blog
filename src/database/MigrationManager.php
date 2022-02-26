<?php
    require_once dirname(__FILE__) . "/Database.php";

    class MigrationManager {
        /**
         * The connection to the database.
         */
        private $db;

        public function __construct($config = []) {
            $this->db = new Database($config);
            $this->db->connect();
        }

        /**
         * To apply the migrations. $direction determine if the migration is UP or DOWN.
         *
         * @param string $direction The direction of the migration.
         * @return void
         */
        public function applyMigrations($direction) {
            $this->createMigrationsTable();
            $this->migrate($direction);
        }


        private function migrate($direction) {
            $mig = iterator_to_array($this->getMigrations($direction));

            if ($direction === 'up') {
                $appliedMig = iterator_to_array($this->getAppliedMigrations());
                $mig = array_diff($mig, $appliedMig);
            }
            if ($direction === 'down') {
                $appliedMig = iterator_to_array($this->getAppliedMigrations());
                $mig = array_intersect($mig, $appliedMig);
            }

            $this->executeMigrations($mig, $direction);
        }

        // Returns an iterator of all the migrations matching the direction
        // Ordered based on the direction of the migrations
        private function getMigrations($direction) {
            foreach (scandir(dirname(__FILE__) . "/migrations", $direction === 'up' ? SCANDIR_SORT_ASCENDING : SCANDIR_SORT_DESCENDING) as $dir) {
                if ($dir !== '.' && $dir !== '..') {
                    yield strtok($dir, '_');
                }
            }
        }

        private function createMigrationsTable() {
            $conn = $this->db->getConnection();

            $query = "
                CREATE TABLE IF NOT EXISTS migrations (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    migration VARCHAR(255),
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                );
            ";

            $conn->query($query);
            
            if ($conn->error) {
                echo "An internal server error occured";
                die;
            }
        }

        private function getAppliedMigrations() {
            $conn = $this->db->getConnection();

            $query = "
                SELECT migrations.migration FROM migrations;
            ";

            if ($result = $conn->query($query)) {
                while($row = $result->fetch_assoc()) {
                    yield $row['migration'];
                }
            }
            
            if ($conn->error) {
                echo "An internal server error occured";
                die;
            }
        }

        private function executeMigrations($toApplyMig, $direction) {
            $path = dirname(__FILE__) . "/migrations/";
            $conn = $this->db->getConnection();
            
            foreach ($toApplyMig as $mig) {
                $migFolders = glob($path . $mig . "*");
                foreach ($migFolders as $folder) {
                    $query = file_get_contents($folder . "/$direction.sql");
                    if ($direction === 'up' && $result = $conn->query($query)) {
                        $query = "INSERT INTO migrations (migration) VALUES ('" . $conn->real_escape_string($mig) . "');"; 

                        if ($result = $conn->query($query)) {
                            echo "Database migration status updated to $direction : " . $mig . PHP_EOL;
                        }
                        if ($conn->error) {
                            echo "An error occured trying to update $direction migration : " . $mig . PHP_EOL;
                            die;
                        }

                        echo "Migration $direction : " . $mig . " applied." . PHP_EOL;
                    }
                    if ($direction === 'down' && $result = $conn->query($query)) {
                        $query = "DELETE FROM migrations WHERE migration = '" . $conn->real_escape_string($mig) . "';"; 

                        if ($result = $conn->query($query)) {
                            echo "Database migration status updated to $direction : " . $mig . PHP_EOL;
                        }
                        if ($conn->error) {
                            echo "An error occured trying to update $direction migration : " . $mig . PHP_EOL;
                            die;
                        }

                        echo "Migration $direction : " . $mig . " applied." . PHP_EOL;
                    }
                    if ($conn->error) {
                        echo "An error occured trying to apply $direction migration : " . $mig . PHP_EOL;
                        die;
                    }
                }
            }

            echo "Migrations up to date.";
        }
    }
?>