<?php 
    require_once dirname(__FILE__) . '/../../src/Application.php';

    require dirname(__FILE__) . '/../components/common/navbar.php';
    
    echo "<h4>List of users : </h4>";
    require dirname(__FILE__) . '/../components/lists/userList.php';
    echo "<h4>List of posts : </h4>";
    require dirname(__FILE__) . '/../components/lists/postList.php';
?>