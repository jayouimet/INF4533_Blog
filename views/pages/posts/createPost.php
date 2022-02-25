<?php
    require_once dirname(__FILE__) . '/../../../src/Application.php';
    echo "<a href='". Application::$baseUrl ."/'>Home page</a>";

    require dirname(__FILE__) . '/../../components/forms/postForm.php';
?>