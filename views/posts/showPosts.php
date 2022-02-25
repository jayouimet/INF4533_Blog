<table>
    <tr>
        <th>Author ID</th>
        <th>Title</th>
        <th>Posted Image</th>
        <th>Created at</th>
        <th>Body</th>
    </tr>

    <?php
        foreach($posts as $post){
            echo "<tr>";

            echo sprintf("
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
                <td>%s</td>
            ",
            $post->user_id,
            $post->title,
            $post->post_image ?? null,
            $post->created_at,
            $post->body);

            echo "</tr>";
        }
    ?>
</table>