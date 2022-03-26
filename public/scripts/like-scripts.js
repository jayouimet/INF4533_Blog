function likePost(event, post_id) {
    let params = `post_id=${post_id}`;
    const xHttpObject = new XMLHttpRequest();
    xHttpObject.onload = () => {
        let obj = JSON.parse(xHttpObject.responseText);
        event.target.textContent = obj.liked ? "Liked" : "Not Liked";
    };
    xHttpObject.open('POST', 'like_post', true);
    xHttpObject.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xHttpObject.send(params);
}