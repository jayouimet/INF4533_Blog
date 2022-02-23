<?php
echo "<form action='/INF4533_Blog/addcomment' method='post'>";
echo "Comment : <input type='text' name='comment'><br>" ;
echo "<input type='submit'>";
echo "</form>";

if (isset($isInserted)) {
if ($isInserted) {
    echo "Comment posted";
} else {
    echo "Comment could not be posted, try again later.";
}
}

?>
