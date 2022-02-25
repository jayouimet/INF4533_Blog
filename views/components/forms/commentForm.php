<?php
require_once dirname(__FILE__) . '/../../../src/Application.php';
require_once dirname(__FILE__) . '/../../../src/providers/AuthProvider.php';

echo "<form action='". Application::$baseUrl . "/addcomment/" . $post_id . "' method='post'>";
echo "Comment : <input type='text' name='comment' required minlength='1' " . (AuthProvider::isAuthed() ? null : "disabled") . " ><br>" ;
echo "<input " . (AuthProvider::isAuthed() ? null : "disabled") . " type='submit'>";
echo "</form>";

if (isset($errorMessageId)) {
    switch ($errorMessageId) {
        case "unexpectedErrorAddComment":
            echo "<p>An unexpected error has occured, try again later.</p>";
            break;
        default:
        echo "<p>An unexpected error has occured, try again later.</p>";
            break;
    }
}

?>
