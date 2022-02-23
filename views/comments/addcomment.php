<?php
echo "<form action='/INF4533_Blog/addcomment' method='post'>";
echo "Comment : <input type='text' name='comment'><br>" ;
echo "<input type='submit'>";
echo "</form>";

/*if ( isset($_POST['body']))

$sql = "INSERT INTO comments (body)
VALUES (' " . mysqli_real_escape_string($conn, $_POST['body'] . " ') ;
echo $sql ;
if (mysqli_query($conn, $sql)) {
    echo "Comment posted";
} else {
    echo "Comment could not be posted, try again later.";
}*/

?>
