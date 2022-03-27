<?php
    require_once dirname(__FILE__) . '/../../../../src/Application.php';
    echo "<script src='" . Application::$baseUrl . "/public/scripts/profile-page-scripts.js' defer></script>";
    echo "<link rel='stylesheet' href='" .Application::$baseUrl  . "/public/style/profile-page-style.css' crossorigin='anonymous'>";
?>