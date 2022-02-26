<table>
    <tr>
        <th>Author</th>
        <th>Title</th>
        <th>Posted Image</th>
        <th>Created at</th>
        <th>Body</th>
    </tr>

    <?php
        require_once dirname(__FILE__) . '/../../../src/Application.php';

        foreach($posts as $post){
            echo "<tr>";

            $post->fetch();

            echo sprintf("
                <td><a href=" . Application::$baseUrl . "/posts/" . $post->getId() . ">%s</a></td>
                <td><a href=" . Application::$baseUrl . "/posts/" . $post->getId() . ">%s</a></td>
                <td><a href=" . Application::$baseUrl . "/posts/" . $post->getId() . ">%s</a></td>
                <td><a href=" . Application::$baseUrl . "/posts/" . $post->getId() . ">%s</a></td>
                <td><a href=" . Application::$baseUrl . "/posts/" . $post->getId() . ">%s</a></td>
            ",
            $post->user->username,
            $post->title,
            $post->post_image ?? null,
            $post->created_at,
            $post->body);

            echo "</tr>";
        }
    ?>
</table>