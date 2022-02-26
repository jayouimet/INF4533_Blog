<?php
    require_once dirname(__FILE__) . '/../../../src/Application.php';
?>

<div class='navbar-flex-container'>
    <div class='navbar-left'>
        <?php
            echo "<h1><a href='". Application::$baseUrl ."/'>Home</a></h1>"
        ?>
    </div>
    <div class='navbar-right'>
        <?php
            if (!isset($currentUser)) {
                echo "<form action='". Application::$baseUrl ."/login' method='post'>";
                echo "<input value='Login' type='submit'>";
                echo "</form>";
            }
            else {
                echo $currentUser->username;
                echo "<form action='". Application::$baseUrl ."/logout' method='post'>";
                echo "<input value='Logout' type='submit'>";
                echo "</form>";
                echo "<a href='". Application::$baseUrl ."/addpost'>Add a post.</a>";
            }
        ?>
    </div>
</div>