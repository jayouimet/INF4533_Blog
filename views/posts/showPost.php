<?php
    echo "<div>Author : " . $post->user->username . "</div>";
    echo "<div>Title : " . $post->title . "</div>";
    echo "<div>Image Src : " . ($post->post_image ?? null) . "</div>";
    echo "<div>Created at : " . $post->created_at . "</div>";
    echo "<div>Body : " . $post->body . "</div>";
?>