<?php
require_once dirname(__FILE__) . '/../../../src/Application.php';
require dirname(__FILE__) . '/../../components/common/navbar.php';
?>
<div class="row">
    <!-- List of posts -->
    <div class="col-3 border-right">
        <div class="row">
            <h4 class="text-center col-1" style="margin:0.5vmax;">List of posts</h4>
        </div>
        <div class="row">
            <div class="col-3">
                <input id='search_bar_posts' placeholder="Search Posts" value='' />
                <!-- List of posts -->
                <?php require dirname(__FILE__) . '/../../components/lists/postList.php'; ?>
            </div>
            <div class="col-1">
                <!-- Filters -->
                <table class="filters">
                    <thead>
                        <td>
                            <h4>Filter by : </h1>
                        </td>
                    </thead>
                    <tr>
                        <td>User ?</td>
                        <td><input id='searchUser' type='checkbox' checked='checked' /></td>
                    </tr>
                    <tr>
                        <td>Title ?</td>
                        <td><input id='searchTitle' type='checkbox' checked='checked' /></td>
                    </tr>
                    <tr>
                        <td>Body Content ?</td>
                        <td><input id='searchBody' type='checkbox' checked='checked' /></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <!-- List of users -->
    <div class="col-1">
        <h4 class="text-center" style="margin:0.5vmax;">List of users</h4>
        <input id='search_bar_users' placeholder="Search Users" value='' />
        <?php require dirname(__FILE__) . '/../../components/lists/userList.php'; ?>
    </div>
</div>
<?php


if (isset($currentUser)) {
    echo "<a href='" . Application::$baseUrl . "/addpost'>Add a post.</a>";
}

echo "";

echo "";
echo "";
?>