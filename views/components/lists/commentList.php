<table>
  <?php
    foreach($comments as $comment) {
        $comment->fetch();
        echo "<tr><td><b>" . $comment->user->username . "</b></td><td>" . $comment->updated_at . "</td></tr>";
        echo "<tr><td>" . $comment->body . "</td></tr>";
    }
  ?>
</table>
