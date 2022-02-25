<?php
    require_once dirname(__FILE__) . '/../../src/Application.php';
    echo "<a href='". Application::$baseUrl ."/'>Home page</a>";
?>

<form action="<?php
    echo Application::$baseUrl;
?>
/postAddPost" method="POST">
    <label for="user_id">Author ID</label>      
    <input name="user_id" type="text"/><br>
    <label for="title">Title</label>            
    <input placeholder="title" name="title" type="text" required minlength='1'/><br>
    <label for="post_image">Image</label>       
    <input placeholder="image" name="post_image" type="file" required minlength='1'/><br>
    <label for="body">Body</label>              
    <textarea name="body" placeholder="Body of the post" required minlength='1'></textarea><br>
    <input type="submit" value="Submit">
</form>