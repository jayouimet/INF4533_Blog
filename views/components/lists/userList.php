<ol>
  <?php
    foreach($users as $user) {
      echo "<li>";
      echo "<ul>";
      echo "<li>" . $user-> username . "</li>";
      echo "<li>" . $user-> firstname . "</li>";
      echo "<li>" . $user-> lastname . "</li>";
      echo "<li>" . $user-> email . "</li>";
      echo "<li>" . $user-> date_of_birth . "</li>";
      echo "</ul>";
      echo "</li>";
    }
  ?>
</ol>
