<?php
require_once dirname(__FILE__) . '/../../../src/Application.php';
require dirname(__FILE__) . '/../../components/common/navbar.php';

require dirname(__FILE__) . '/../../components/forms/loginForm.php';

echo "<a href='". Application::$baseUrl ."/register'>Click here to create an account.</a>";
?>