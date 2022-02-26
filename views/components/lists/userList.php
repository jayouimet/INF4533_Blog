<ol>
  <?php
  foreach ($users as $user) { ?>
  <li>
    <table>
      <tr><td><b>Username</b> </td><td> <?php echo $user->username ?></td></tr>
      <tr><td><b>Firstname</b> </td><td> <?php echo $user->firstname ?></td></tr>
      <tr><td><b>Lastname</b> </td><td> <?php echo $user->lastname ?></td></tr>
      <tr><td><b>Email</b> </td><td> <?php echo $user->email ?></td></tr>
      <tr><td><b>Date of birth</b> </td><td> <?php echo $user->date_of_birth ?></td></tr>
      <tr><td><b>Created at</b> </td><td> <?php echo $user->created_at ?></td></tr>
    </table>
  </li><br>
  <?php } ?>
</ol>