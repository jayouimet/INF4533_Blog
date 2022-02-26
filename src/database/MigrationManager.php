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
            // We store the migrations array from the folder into $mig
            $mig = iterator_to_array($this->getMigrations($direction));
            // Filter by executed migrations depending on the direction
            if ($direction === 'up') {
                $appliedMig = iterator_to_array($this->getAppliedMigrations());
                $mig = array_diff($mig, $appliedMig);
            }
            if ($direction === 'down') {
                $appliedMig = iterator_to_array($this->getAppliedMigrations());
                $mig = array_intersect($mig, $appliedMig);
            }
            // Execute the migrations
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

        // We create the migration table if it doesn't exist, 
        // this is where we keep the migration history
        // so we do not execute the same migration twice
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

        // Get all migrations that have already been applied from the migration table
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

        // We execute the migrations from the array of migrations, in the direction 
        private function executeMigrations($toApplyMig, $direction) {
            // Get the path to the migrations
            $path = dirname(__FILE__) . "/migrations/";
            $conn = $this->db->getConnection();
            
            // For all migrations to apply
            foreach ($toApplyMig as $mig) {
                // We create a search string array for all folders
                $migFolders = glob($path . $mig . "*");
                // For each folder name
                foreach ($migFolders as $folder) {
                    // We get the content of the file in the correct direction
                    $query = file_get_contents($folder . "/$direction.sql");
                    // If we are migrating up, we execute the query, then we insert the migration status to the database
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
                    // If we are migrating down, we execute the query, then we delete the related migration status to the database
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
                    // In case of an error we stop the execution (we do not apply future migrations)
                    if ($conn->error) {
                        echo "An error occured trying to apply $direction migration : " . $mig . PHP_EOL;
                        die;
                    }
                }
            }
            // If everything executed we tell the user we are up to date
            echo "Migrations up to date.";
        }
    }
?>