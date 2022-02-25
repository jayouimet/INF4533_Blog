<?php
require_once dirname(__FILE__) . '/../../src/Application.php';

echo "<form action='". Application::$baseUrl ."/addcomment' method='post'>";
echo "Comment : <input type='text' name='comment' required minlength='1'><br>" ;
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
