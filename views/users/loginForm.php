<?php
require_once dirname(__FILE__) . '/../../src/Application.php';

echo "<a href='". Application::$baseUrl ."/'>Home page</a>";
echo "<form action='". Application::$baseUrl ."/login' method='post'>";
echo "<label for='username'>Username : </label><input type='text' name='username' required><br>" ;
echo "<label for='password'>Password : </label><input type='text' name='password' minlength='8' required><br>" ;
echo "<input label='login' type='submit'>";
echo "</form>";

if (isset($errorMessageId)) {
    switch ($errorMessageId) {
        case "invalidCredentials":
            echo "Invalid username/password combination.";
            break;
        default:
            echo "An unexpected error has occured, please try again later.";
            break;
    }
}
echo "<a href='". Application::$baseUrl ."/register'>Click here to create an account.</a>";
?>