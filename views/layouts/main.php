<?php
    require_once dirname(__FILE__) . '/../../src/Application.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        echo "<link rel='stylesheet' href='" .Application::$baseUrl  . "/public/style/style.css' crossorigin='anonymous'>";
    ?>
    <title>Document</title>
</head>
<body>
    <div class="container">
        {{content}}
    </div>
</body>
</html>