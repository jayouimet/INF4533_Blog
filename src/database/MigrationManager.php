<?php
    require_once dirname(__FILE__) . "/../Application.php";

    class MigrationManager {
        public function applyUpMigrations() {
            $this->createMigrationsTable();
            $this->migrate('up');
        }

        public function applyDownMigrations() {
            $this->createMigrationsTable();
            $this->migrate('down');
        }

        private function migrate($direction) {
            $allMig = iterator_to_array($this->getMigrations());
            $appliedMig = iterator_to_array($this->getAppliedMigrations());

            $toApplyMig = array_diff($allMig, $appliedMig);

            $this->executeMigrations($toApplyMig, $direction);
        }

        private function getMigrations() {
            foreach (scandir(Application::$ROOT_DIR . "/src/database/migrations", SCANDIR_SORT_ASCENDING) as $dir) {
                if ($dir !== '.' && $dir !== '..') {
                    yield strtok($dir, '_');
                }
            }
        }

        private function createMigrationsTable() {
            $conn = Application::$db->getConnection();

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
            $conn = Application::$db->getConnection();

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
            $conn = Application::$db->getConnection();
            
            foreach ($toApplyMig as $mig) {
                $migFolders = glob($path . $mig . "*");
                foreach ($migFolders as $folder) {
                    $query = file_get_contents($folder . "/$direction.sql");
                    if ($result = $conn->query($query)) {
                        $query = "INSERT INTO migrations (migration) VALUES ('" . $conn->real_escape_string($mig) . "');"; 

                        if ($result = $conn->query($query)) {
                            echo "Database migration status updated to : " . $mig . PHP_EOL;
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
        }
    }
?>