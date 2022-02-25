<form action="<?php
    require_once dirname(__FILE__) . '/../../../src/Application.php';
    echo Application::$baseUrl;
?>
/addpost" method="POST">
    <label for="title">Title</label>            
    <input placeholder="title" name="title" type="text" required minlength='1'/><br>
    <label for="post_image">Image</label>       
    <input placeholder="image" name="post_image" type="file"/><br>
    <label for="body">Body</label>              
    <textarea name="body" placeholder="Body of the post" required minlength='1'></textarea><br>
    <input type="submit" value="Submit">
</form>