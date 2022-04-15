<?php require_once dirname(__FILE__) . '/../../../src/Application.php'; 
// This function format a short-handed way to describe the difference between $now and $date
/* 
Examples : 
1 jan 2021 - 31 dec 2020 = "1 day"
1 jan 2021 - 31 nov 2020 = "1 month"
*/
function convertDate($now, $date){
    $diff = $now - strtotime($date);
    $arr = explode(":", date("s:i:H:d:m:Y", $diff));
    $arr[5] -= 1970;
    $placeholders = ["second", "minute", "hour", "day", "month", "year"];
    $rtn = "";

    for($i = 0; $i < count($arr); $i++){
        if($arr[$i] > 0) {
            $rtn = $arr[$i] . " " . $placeholders[$i] . ($arr[$i] > 1 ? "s" : "");
        }
    }

    return ltrim($rtn,"0");
}
?>
<div id="posts">
    <?php
    $now = time();
    foreach ($posts as $post) {
        $post->fetch();

        echo "<a class='row card white' href=" . Application::$baseUrl . "/posts/" . $post->getId() . ">";
    ?>
        <div class="col-1 text-center" style="background-color:lightgray">
            <p><?php echo count($post->likes) ?></p>
        </div>
        <div class="col-12" style="margin:0.4vmax;">
            <!-- Posted by date -->
            <div class="row">
                <div class="author">Posted by <b><?php echo $post->user->username ?></b>
                <?php echo convertDate($now, $post->created_at); ?> ago</div>
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