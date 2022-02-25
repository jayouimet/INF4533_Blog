<h1>Home</h1>
<h3>
    <?php 
        require_once dirname(__FILE__) . '/../../src/Application.php';

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
        echo "<h4>List of users : </h4>";
        require dirname(__FILE__) . '/../components/lists/userList.php';
        echo "<h4>List of posts : </h4>";
        require dirname(__FILE__) . '/../components/lists/postList.php';
    ?>
</h3>