// CPIT-405 - Lab 6: JavaScript, DOM events and cookies

// Save a cookie for 7 days.
function setCookie(name, value) {
    document.cookie = name + "=" + encodeURIComponent(value) +
        "; max-age=" + (7 * 24 * 60 * 60) + "; path=/";
}

// Find a cookie by its name.
function getCookie(name) {
    let allCookies = document.cookie.split(";");

    for (let i = 0; i < allCookies.length; i++) {
        let cookie = allCookies[i].trim();

        if (cookie.indexOf(name + "=") === 0) {
            return decodeURIComponent(cookie.substring(name.length + 1));
        }
    }

    return null;
}

// Delete a cookie so the user can vote and comment again.
function deleteCookie(name) {
    document.cookie = name + "=; max-age=0; path=/";
}

// Start with stored values, or zero if this browser has not voted.
let likes = Number(getCookie("lab6_likes")) || 0;
let dislikes = Number(getCookie("lab6_dislikes")) || 0;
let userVote = getCookie("lab6_vote") || "";
let comments = [];

let savedComment = getCookie("lab6_comment");
if (savedComment !== null && savedComment !== "") {
    comments.push(savedComment);
}

const likeButton = document.getElementById("like-button");
const dislikeButton = document.getElementById("dislike-button");
const likeCount = document.getElementById("like-count");
const dislikeCount = document.getElementById("dislike-count");
const voteMessage = document.getElementById("vote-message");

const commentForm = document.getElementById("comment-form");
const commentInput = document.getElementById("comment-input");
const commentButton = document.getElementById("comment-button");
const commentMessage = document.getElementById("comment-message");
const commentList = document.getElementById("comment-list");
const emptyMessage = document.getElementById("empty-message");
const resetMessage = document.getElementById("reset-message");

// Display the counters, choices and saved comments in the HTML page.
function updatePage() {
    likeCount.innerText = likes;
    dislikeCount.innerText = dislikes;

    if (userVote !== "") {
        likeButton.disabled = true;
        dislikeButton.disabled = true;
        voteMessage.innerText = "You already voted: " + userVote + ".";
    } else {
        likeButton.disabled = false;
        dislikeButton.disabled = false;
        voteMessage.innerText = "You can vote once.";
    }

    // Remove old list items before showing the current comments.
    while (commentList.firstChild) {
        commentList.removeChild(commentList.firstChild);
    }

    for (let i = 0; i < comments.length; i++) {
        let item = document.createElement("li");
        item.innerText = comments[i];
        commentList.appendChild(item);
    }

    emptyMessage.hidden = comments.length > 0;

    if (comments.length > 0) {
        commentInput.disabled = true;
        commentButton.disabled = true;
        commentMessage.innerText = "You already submitted a comment.";
    } else {
        commentInput.disabled = false;
        commentButton.disabled = false;
        commentMessage.innerText = "You can submit one comment.";
    }
}

// One vote per browser until reset.
function vote(choice) {
    if (userVote !== "") {
        return;
    }

    if (choice === "Like") {
        likes++;
    } else {
        dislikes++;
    }

    userVote = choice;
    setCookie("lab6_vote", userVote);
    setCookie("lab6_likes", likes);
    setCookie("lab6_dislikes", dislikes);
    resetMessage.innerText = "";
    updatePage();
}

likeButton.addEventListener("click", function () {
    vote("Like");
});

dislikeButton.addEventListener("click", function () {
    vote("Dislike");
});

// Handle comment submission with a JavaScript event.
commentForm.addEventListener("submit", function (event) {
    event.preventDefault();

    if (comments.length > 0) {
        return;
    }

    let comment = commentInput.value.trim();

    if (comment === "") {
        commentMessage.innerText = "Please write a comment first.";
        return;
    }

    comments.push(comment);
    setCookie("lab6_comment", comment);
    commentInput.value = "";
    resetMessage.innerText = "";
    updatePage();
});

// Reset counters, votes and comments, including their cookies.
document.getElementById("reset-button").addEventListener("click", function () {
    deleteCookie("lab6_vote");
    deleteCookie("lab6_likes");
    deleteCookie("lab6_dislikes");
    deleteCookie("lab6_comment");

    likes = 0;
    dislikes = 0;
    userVote = "";
    comments = [];
    commentInput.value = "";

    updatePage();
    resetMessage.innerText = "Your choices and comments have been reset. You can vote again!";
});

// Restore the saved state when the page opens or refreshes.
updatePage();
