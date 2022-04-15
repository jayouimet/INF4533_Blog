<?php
    require_once dirname(__FILE__) . '/../../../../src/Application.php';
    echo "<script src='" . Application::$baseUrl . "/public/scripts/like-scripts.js' defer></script>";
    echo "<link rel='stylesheet' href='" . Application::$baseUrl . "/public/style/home-style.css' crossorigin='anonymous'></link>";
    echo "<link rel='stylesheet' href='" . Application::$baseUrl . "/public/style/post-style.css' crossorigin='anonymous'></link>";
?>