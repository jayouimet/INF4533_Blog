<?php
    require_once dirname(__FILE__) . '/../src/database/MigrationManager.php';
    $ini = parse_ini_file(dirname(__FILE__) . '/../config.ini');

    $dbConfig = [
        'servername' => $ini['db_servername'],
        'username' => $ini['db_username'],
        'password' => $ini['db_password'],
        'databasename' => $ini['db_databasename']
    ];

    $db = new MigrationManager($dbConfig);
    $db->applyMigrations('up');
?>