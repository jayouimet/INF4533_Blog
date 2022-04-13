// Get inputs from the document
const searchUser = document.querySelector("#searchUser");
const searchTitle = document.querySelector("#searchTitle");
const searchBody = document.querySelector("#searchBody");
const searchBarPosts = document.querySelector("#search_bar_posts");
const searchBarUsers = document.querySelector("#search_bar_users");
const posts = document.querySelectorAll("#posts tr + tr");
const users = document.querySelectorAll("div#users > div");


// Add an event listener when they are checked or for the searchbar, when the input changes
searchUser.addEventListener("change", searchBarInput);
searchTitle.addEventListener("change", searchBarInput);
searchBody.addEventListener("change", searchBarInput);
searchBarPosts.addEventListener("input", searchBarInput);
searchBarUsers.addEventListener("input", searchBarUsersInput);

// Filter the posts depending on the criteria checked with the checkboxes
function searchBarInput() {
    // Get the search parameter in the searchbar
    let param = searchBarPosts.value;
    let isHidden = false;

    posts.forEach(el => {
        // Put all posts not hidden by default
        el.hidden = false;
        isHidden = true;

        // If there's nothing in the search query, just go to the next iteration
        if (param === "") return;

        // If the user checked the User search checkbox, it will hide/un-hide if it contains the search query string in the username
        if (searchUser.checked){
            isHidden = !el.querySelector("td:first-child a").textContent.includes(param);
        }
        // If the user checked the Title search checkbox, it will hide/un-hide if it contains the search query string in the title
        if (searchTitle.checked){
            isHidden = (isHidden ? !el.querySelector("td:nth-child(2) a").textContent.includes(param) : false);
        }
        // If the user checked the Body search checkbox, it will hide/un-hide if it contains the search query string in the body
        if (searchBody.checked){
            isHidden = (isHidden ? !el.querySelector("td:last-child a").textContent.includes(param) : false);
        }

        // Put the post hidden or not if it fits the criteria
        el.hidden = isHidden;
    });
}

function searchBarUsersInput(){
    // Get the search parameter in the searchbar
    let param = searchBarUsers.value;

    users.forEach(el => {
        console.log(el);
        // Put all posts not hidden by default
        el.hidden = false;

        // If there's nothing in the search query, just go to the next iteration
        if (param === "") return;
        
        // Put the user hidden or not if it fits the search query
        el.hidden = !el.querySelector("b").textContent.includes(param);

    });
}