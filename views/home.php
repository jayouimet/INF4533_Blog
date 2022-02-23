<h1>Home</h1>
<h3>
    <?php 
        echo $currentUser->username;
        require dirname(__FILE__) . '/users/showusers.php';
    ?>
</h3>