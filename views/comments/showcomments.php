<ul>
  <?php

    foreach($comments as $comment) {
      echo "<li>" . $comment-> body . "</li>";
    }
  ?>
</ul>
