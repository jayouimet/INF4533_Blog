<?php
require_once dirname(__FILE__) . '/../../../src/Application.php';
?>
<div class="login-form-container">
    <?php
    echo "<form class='login-form' action='". Application::$baseUrl ."/login' method='post'>";
    ?>
        <div class="login-form-row">
            <?php
            if (isset($errorMessageId)) {
                echo "<div class='error'>";
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
            ?>
        </div>
        <div class="login-form-row">
            <label for='username'>Username : </label><input type='text' name='username' required><br>
        </div>
        <div class="login-form-row">
            <label for='password'>Password : </label><input type='password' name='password' minlength='8' required><br>
        </div>
        <div class="login-form-row">
            <input label='login' type='submit'>
        </div>
        <div class="login-form-row">
            <?php
            echo "<a href='". Application::$baseUrl ."/register'>Click here to create an account.</a>";
            ?>
        </div>
    </form>
</div>