<div id="users">
  <?php
  foreach ($users as $user) { ?>
    <div class="card"><b><?php echo $user->username; ?></b></div>
  <?php } ?>
</div>