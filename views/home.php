<h1>Home</h1>
<h3>
    <?php 
        require_once dirname(__FILE__) . '/../src/Application.php';

        if (!isset($currentUser)) {
            echo "You are not logged in.";
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
        require dirname(__FILE__) . '/users/showusers.php';
    ?>
</h3>