<?php
require_once dirname(__FILE__) . '/../../../src/Application.php';
?>
<div class="login-form-container">
    <?php
    echo "<form action='". Application::$baseUrl ."/login' method='post'>";
    if (isset($errorMessageId)) {
        echo "<div>";
        switch ($errorMessageId) {
            case "invalidCredentials":
                echo "Invalid username/password combination.";
                break;
            default:
                echo "An unexpected error has occured, please try again later.";
                break;
        }
        echo "</div>";
    }
    echo "<label for='username'>Username : </label><input type='text' name='username' required><br>" ;
    echo "<label for='password'>Password : </label><input type='password' name='password' minlength='8' required><br>" ;
    echo "<input label='login' type='submit'>";
    echo "</form>";

    echo "<a href='". Application::$baseUrl ."/register'>Click here to create an account.</a>";
    ?>
</div>