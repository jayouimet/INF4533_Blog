<?php
    if(isset($_SESSION["test"])) {
        var_dump($_SESSION["test"]);
    }
?>

<h1>Home</h1>
<h3>
    <?php echo $name?>
</h3>