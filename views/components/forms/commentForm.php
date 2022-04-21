<?php
require_once dirname(__FILE__) . '/../../../src/Application.php';
require_once dirname(__FILE__) . '/../../../src/providers/AuthProvider.php';
?>

<form action="<?php echo Application::$baseUrl . "/addcomment/" . $post_id ?>" method='post'>
    Comment : <input type='text' name='comment' required minlength='1' <?php echo (AuthProvider::isAuthed() ? null : "disabled"); ?>>
    <input <?php echo (AuthProvider::isAuthed() ? null : "disabled"); ?> type='submit'>
</form>

<?php
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