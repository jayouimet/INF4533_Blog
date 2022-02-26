<?php
require_once dirname(__FILE__) . '/../../../src/Application.php';
require dirname(__FILE__) . '/../../components/common/navbar.php';

require dirname(__FILE__) . '/../../components/forms/registerForm.php';

echo "<a href='". Application::$baseUrl ."/login'>Already have an account?</a>";
?>