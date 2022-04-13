<table id="posts">
    <tr>
        <td>Author</td>
        <td>Title</td>
        <td>Created at</td>
        <td>Body</td>
    </tr>

    <?php
    require_once dirname(__FILE__) . '/../../../src/Application.php';

    foreach ($posts as $post) {
        echo "<tr>";

        $post->fetch();

        echo sprintf(
            "
                <td><a href=" . Application::$baseUrl . "/posts/" . $post->getId() . ">%s</a></td>
                <td><a href=" . Application::$baseUrl . "/posts/" . $post->getId() . ">%s</a></td>
                <td><a href=" . Application::$baseUrl . "/posts/" . $post->getId() . ">%s</a></td>
                <td><a href=" . Application::$baseUrl . "/posts/" . $post->getId() . ">%s</a></td>
            ",
            $post->user->username,
            $post->title,
            $post->created_at,
            $post->body
        );

        echo "</tr>";
    }
    ?>
</table>