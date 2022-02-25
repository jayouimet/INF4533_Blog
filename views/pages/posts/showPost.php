<?php
    require_once dirname(__FILE__) . '/../../../src/Application.php';
    echo "<a href='". Application::$baseUrl ."/'>Home page</a>";
    echo "<div>Author : " . $post->user->username . "</div>";
    echo "<div>Title : " . $post->title . "</div>";
    echo "<div>Image Src : " . ($post->post_image ?? null) . "</div>";
    echo "<div>Created at : " . $post->created_at . "</div>";
    echo "<div>Body : " . $post->body . "</div>";
?>