function likePost(event, post_id) {
    let params = `post_id=${post_id}`;
    const xHttpObject = new XMLHttpRequest();
    xHttpObject.onload = function () {
        if (xHttpObject.responseText == "") return;
        
        let obj = JSON.parse(xHttpObject.responseText);
        event.target.textContent = parseInt(event.target.textContent) + (obj.liked ? 1 : -1);
    };
    xHttpObject.open('POST', 'like_post', true);
    xHttpObject.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xHttpObject.send(params);
}