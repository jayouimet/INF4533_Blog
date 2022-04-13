<div id="users">
  <?php
  foreach ($users as $user) { 
    $user->fetch();
    ?>
    <a class="row card-user" href="#">
      <div class="col-3 border-right" style="background-color:lightgray;"><b><?php echo $user->username; ?></b></div>
      <div class="col-1 border-right"><?php echo count($user->posts) ?> posts</div>
      <div class="col-1"><?php echo count($user->likes) ?> likes</div>
    </a>
  <?php } ?>
</div>