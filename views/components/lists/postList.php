<?php require_once dirname(__FILE__) . '/../../../src/Application.php'; ?>
<div id="posts">
    <?php
    foreach ($posts as $post) {
        $post->fetch();

        echo "<a class='row card' href=" . Application::$baseUrl . "/posts/" . $post->getId() . ">";
    ?>
        <div class="col-1 text-center" style="background-color:lightgray">
            <p><?php echo count($post->likes) ?></p>
        </div>
        <div class="col-12" style="margin:0.4vmax;">
            <!-- Posted by date -->
            <div class="row">
                <div class="author">Posted by <b><?php echo $post->user->username . "</b> at " . $post->created_at ?></div>
            </div>
            <!-- Title -->
            <div class="row">
                <b class="title"><?php echo $post->title ?></b>
            </div>
            <div class="body" hidden><?php echo $post->body ?></div>
        </div>
        </a>
    <?php } ?>
</div>