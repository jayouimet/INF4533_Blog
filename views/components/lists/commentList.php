<div id="comments">
  <?php
  foreach ($comments as $comment) {
    $comment->fetch();
  ?>
    <div class="row" style="margin-top:0.5vmax;border-left:1px solid black;">
      <div class="row" style="margin-left:0.3vmax;">
        <div class="author"><b><?php echo $comment->user->username ?></b>
          <?php echo convertDate($now, $comment->created_at); ?> ago</div>
      </div>
      <div class="row" style="margin-left:0.3vmax;">
        <b><?php echo $comment->body; ?></b>
      </div>
    </div>
  <?php
  }
  ?>
</div>