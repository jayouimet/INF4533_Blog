<form action="" method="POST">
    <label for="user_id">Author ID</label>      <input name="user_id" type="text"/>
    <label for="title">Title</label>            <input placeholder="title" name="title" type="text" required minlength='1'/>
    <label for="post_image">Image</label>       <input placeholder="image" name="post_image" type="file" required minlength='1'/>
    <label for="body">Body</label>              <textarea name="body" placeholder="Body of the post" required minlength='1'></textarea>
    <input type="submit" value="Submit">
</form>