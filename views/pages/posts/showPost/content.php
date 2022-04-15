<?php
require_once dirname(__FILE__) . '/../../../../src/Application.php';
require dirname(__FILE__) . '/../../../components/common/navbar.php';

function convertDate($now, $date)
{
    $diff = $now - strtotime($date);
    $arr = explode(":", date("s:i:H:d:m:Y", $diff));
    $arr[5] -= 1970;
    $placeholders = ["second", "minute", "hour", "day", "month", "year"];
    $rtn = "";

    for ($i = 0; $i < count($arr); $i++) {
        if ($arr[$i] > 0) {
            $rtn = $arr[$i] . " " . $placeholders[$i] . ($arr[$i] > 1 ? "s" : "");
        }
    }

    return ltrim($rtn, "0");
}

$post->fetch();
$now = time();
?>
<div style="margin:3vmax 20vmax;">
    <div class="row">
        <div class="col-1 text-center">
            <p id="like" class="unselectable" onclick='likePost(event, <?php echo $post->getId(); ?>)'><?php echo count($post->likes) ?></p>
            <div class="row">
                <div class="col-1"></div>
            </div>
        </div>
        <div class="col-12 margin-1">
            <!-- Posted by date -->
            <div class="row">
                <div class="author">Posted by <b><?php echo $post->user->username ?></b>
                    <?php echo convertDate($now, $post->created_at); ?> ago</div>
            </div>
            <!-- Title -->
            <div class="row">
                <b class="title"><?php echo $post->title ?></b>
            </div>
            <div class="row">
                <!-- BODY -->
                <p><?php echo $post->body; ?></p>
            </div>
        </div>
    </div>
    <div class="row">
        <?php $post_id = $post->getId(); require dirname(__FILE__) . '/../../../components/forms/commentForm.php'; ?>
    </div>
    <div class="row" style="margin-top:1vmax;">
        <?php $comments = $post->comments; require dirname(__FILE__) . '/../../../components/lists/commentList.php'; ?>
    </div>
</div>
