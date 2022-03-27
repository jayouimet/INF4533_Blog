<?php
    require_once dirname(__FILE__) . '/../../../src/Application.php';
    require_once dirname(__FILE__) . '/../../../src/providers/AuthProvider.php';
?>

<div class='navbar-flex-container'>
    <div class='navbar-left'>
        <?php
            echo "<h1><a href='". Application::$baseUrl ."/'>Home</a></h1>"
        ?>
    </div>
    <div class='navbar-right'>
        <div class='navbar-right-container'>
            <?php
                $navBarUserSession = AuthProvider::getSessionObject();
                if (!isset($navBarUserSession)) {
                    echo "<div class='login-div'>";
                    echo "<form action='". Application::$baseUrl ."/login' method='post'>";
                    echo "<input value='Login' type='submit'>";
                    echo "</form>";
                    echo "</div>";
                } else {
                    echo "<div class='navbar-username'><a href='" . Application::$baseUrl . "/profile'>" . $navBarUserSession->username . "</a></div>";
                    echo "<div class='login-div'>";
                    echo "<form action='". Application::$baseUrl ."/logout' method='post'>";
                    echo "<input value='Logout' type='submit'>";
                    echo "</form>";
                    echo "</div>";
                }
            ?>
        </div>
    </div>
</div>