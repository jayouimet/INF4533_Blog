<?php 
    require_once dirname(__FILE__) . '/../../../src/Application.php';

    require dirname(__FILE__) . '/../../components/common/navbar.php';
    
    if (isset($currentUser)) {
        echo "<a href='". Application::$baseUrl ."/addpost'>Add a post.</a>";
    }
    
    echo "<h4>List of users : </h4>";
    require dirname(__FILE__) . '/../../components/lists/userList.php';
    echo "<h4>List of posts : </h4>";
    echo "Search bar : <input id='search_bar' value='' /><br>";
    echo "<table>";
    echo "<tr><td>Search by User  ?</td><td><input id='searchUser' type='checkbox' checked='checked' /></td></tr>";
    echo "<tr><td>Search by Title ?</td><td><input id='searchTitle' type='checkbox' checked='checked' /></td></tr>";
    echo "<tr><td>Search by Body Content ?</td><td><input id='searchBody' type='checkbox' checked='checked' /></td></tr>";
    require dirname(__FILE__) . '/../../components/lists/postList.php';
?>