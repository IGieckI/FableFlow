function loadComments() {
    $.ajax({
        url: '/FableFlow/src/models/utilities/GetComments.php',
        type: 'GET',
        data: { chapter_id: getPostId(window.location.href) },
        dataType: 'json',
        success: function(data) {
            if (data.length > 0) {
                var commentsContainer = $('#comments-container');
                data.forEach(function(comment) {
                    var newCommentHtml = createCommentHtml(comment);
                    commentsContainer.append(newCommentHtml);
                });
            } else {
                console.log('No more comments');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error loading comments:', textStatus, errorThrown);
            console.log(jqXHR.responseText);
        }
    });
}

function createCommentHtml(comment) {
    const likeButtonId = `thumb-up-${comment.comment_id}`;
    const dislikeButtonId = `thumb-down-${comment.comment_id}`;

    return `
        <div class="container">
            <div class="container-fluid comment-box">
                <div class="row user-info justify-content-between">
                    <div class="col-8">
                        <img src="${comment.user_icon}" alt="User Pic" class="user-pic">
                        <strong>${comment.username}</strong><br>
                    </div>
                    <div class="col-4 text-end">
                        <small>${getTimeAgo(comment.datetime)}</small>
                    </div>
                </div>
        
                <div class="row comment-content">
                    <p>${comment.content}</p>
                </div>
                
                <div class="row action-buttons">
                    <div class="col-6"></div>
                    <div class="col-3">
                        <span class="like-dislike-btn" onclick="toggleLike('${comment.comment_id}')">
                            <span>${comment.nlikes}</span>
                            <i id="${likeButtonId}" class="bi bi-hand-thumbs-up"></i> Like
                        </span>
                    </div>
                    <div class="col-3">
                        <span class="like-dislike-btn" onclick="toggleDislike('${comment.comment_id}')">
                            <span>${comment.ndislikes}</span>
                            <i id="${dislikeButtonId}" class="bi bi-hand-thumbs-down"></i> Dislike
                        </span>
                    </div>
                </div>
            </div>
        </div>`;
}

function getTimeAgo(mysqlDatetime) {
    var mysqlDate = new Date(mysqlDatetime);
    var currentDate = new Date();

    var timeDifference = currentDate.getTime() - mysqlDate.getTime();

    var seconds = Math.floor(timeDifference / 1000);
    var minutes = Math.floor(seconds / 60);
    var hours = Math.floor(minutes / 60);
    var days = Math.floor(hours / 24);

    if (days > 0) {
        return days + ' days ago';
    } else if (hours > 0) {
        return hours + ' hours ago';
    } else if (minutes > 0) {
        return minutes + ' minutes ago';
    } else {
        return seconds + ' seconds ago';
    }
}

// !!! CHANGE NAME TO TOGGLE LIKE/DISLIKE, MUST BE LINKED TO ACCOUNT, ALSO WHEN LOGIN AND PAGE RELOAD SHOULD STILL SEE THE LIKED BUTTON !!!

function toggleLike(comment_id) {
    const likeIcon = document.getElementById("thumb-up-" + comment_id);
    const dislikeIcon = document.getElementById("thumb-down-" + comment_id);

    const likeCounter = likeIcon.parentElement.querySelector('span');
    const dislikeCounter = dislikeIcon.parentElement.querySelector('span');

    if (likeIcon.classList.contains('bi-hand-thumbs-up-fill')) {
        likeIcon.classList.remove('bi-hand-thumbs-up-fill');
        likeIcon.classList.add('bi-hand-thumbs-up');

        likeCounter.textContent = parseInt(likeCounter.textContent) - 1;
        updateLikeDislike('john_doe', comment_id, 'remove');
    } else {
        likeIcon.classList.add('bi-hand-thumbs-up-fill');
        likeIcon.classList.remove('bi-hand-thumbs-up');

        if (dislikeIcon.classList.contains('bi-hand-thumbs-down-fill')) {
            dislikeIcon.classList.remove('bi-hand-thumbs-down-fill');
            dislikeIcon.classList.add('bi-hand-thumbs-down');
            dislikeCounter.textContent = parseInt(dislikeCounter.textContent) - 1;
            updateLikeDislike('john_doe', comment_id, 'remove');
        }

        likeCounter.textContent = parseInt(likeCounter.textContent) + 1;
        updateLikeDislike('john_doe', comment_id, 'like');
    }
}

function toggleDislike(comment_id) {
    const likeIcon = document.getElementById("thumb-up-" + comment_id);
    const dislikeIcon = document.getElementById("thumb-down-" + comment_id);

    const likeCounter = likeIcon.parentElement.querySelector('span');
    const dislikeCounter = dislikeIcon.parentElement.querySelector('span');

    if (dislikeIcon.classList.contains('bi-hand-thumbs-down-fill')) {
        dislikeIcon.classList.remove('bi-hand-thumbs-down-fill');
        dislikeIcon.classList.add('bi-hand-thumbs-down');

        dislikeCounter.textContent = parseInt(dislikeCounter.textContent) - 1;
        updateLikeDislike('john_doe', comment_id, 'remove');
    } else {
        dislikeIcon.classList.add('bi-hand-thumbs-down-fill');
        dislikeIcon.classList.remove('bi-hand-thumbs-down');

        if (likeIcon.classList.contains('bi-hand-thumbs-up-fill')) {
            likeIcon.classList.remove('bi-hand-thumbs-up-fill');
            likeIcon.classList.add('bi-hand-thumbs-up');
            likeCounter.textContent = parseInt(likeCounter.textContent) - 1;
            updateLikeDislike('john_doe', comment_id, 'remove');
        }

        dislikeCounter.textContent = parseInt(dislikeCounter.textContent) + 1;
        updateLikeDislike('john_doe', comment_id, 'dislike');
    }
}

function updateLikeDislike(username, comment_id, action) {
    $.ajax({
        url: '/FableFlow/src/models/utilities/UpdateCommentsLikesDislikes.php',
        type: 'POST',
        data: { username: username, comment_id: comment_id, action: action },
        success: function(response) {
            console.log('Database updated successfully:', response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error updating database:', textStatus, errorThrown);
            console.log(jqXHR.responseText);
        }
    });
}

// Get the id of the post from the URL
function getPostId(currentURL) {
    param = currentURL.split("?");
    param = param[param.length - 1].split("=");
    return param[param.length - 1];
}