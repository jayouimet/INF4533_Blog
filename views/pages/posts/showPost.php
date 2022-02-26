<?php
    require_once dirname(__FILE__) . '/../../../src/Application.php';
    require dirname(__FILE__) . '/../../components/common/navbar.php';
    // echo "<a href='". Application::$baseUrl ."/'>Home page</a>";
    echo "<div>Author : " . $post->user->username . "</div>";
    echo "<div>Title : " . $post->title . "</div>";
    echo "<div>Image Src : " . ($post->post_image ?? null) . "</div>";
    echo "<div>Created at : " . $post->created_at . "</div>";
    echo "<div>Body : " . $post->body . "</div>";

    $post_id = $post->getId();
    $comments = $post->comments;
    echo "<h4>Add a comment</h4>";
    require dirname(__FILE__) . '/../../components/forms/commentForm.php';
    echo "<h4>Comments</h4>";
    require dirname(__FILE__) . '/../../components/lists/commentList.php';
?>