function initializeComments() {
    loadComments();    
}

function loadComments() {
    $.ajax({
        url: '/FableFlow/src/server/api/GetChapterComments.php',
        type: 'GET',
        data: { chapter_id: getChapterId(window.location.href) },
        dataType: 'json',
        success: function(data) {
            if (data.length > 0) {
                let commentsContainer = $('#comments-container');
                data.forEach(function(comment) {
                    let newCommentHtml = createCommentHtml(comment);
                    commentsContainer.append(newCommentHtml);
                    
                    addClickListener(`thumb-up-${comment.comment_id}`, function() {
                        toggleLike(comment.comment_id);
                    });
                    addClickListener(`thumb-down-${comment.comment_id}`, function() {
                        toggleDislike(comment.comment_id);
                    });
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
                        <span class="like-dislike-btn">
                            <span>${comment.nlikes}</span>
                            <i id="${likeButtonId}" class="${comment.commentStatus == 1 ? "bi bi-hand-thumbs-up-fill" : "bi bi-hand-thumbs-up"}"></i> Like
                        </span>
                    </div>
                    <div class="col-3">
                        <span class="like-dislike-btn">
                            <span>${comment.ndislikes}</span>
                            <i id="${dislikeButtonId}" class="${comment.commentStatus == -1 ? "bi bi-hand-thumbs-down-fill" : "bi bi-hand-thumbs-down"}"></i> Dislike
                        </span>
                    </div>
                </div>
            </div>
        </div>`;
}

function toggleLike(comment_id) {
    const likeIcon = document.getElementById("thumb-up-" + comment_id);
    const dislikeIcon = document.getElementById("thumb-down-" + comment_id);

    const likeCounter = likeIcon.parentElement.querySelector('span');
    const dislikeCounter = dislikeIcon.parentElement.querySelector('span');

    if (likeIcon.classList.contains('bi-hand-thumbs-up-fill')) {
        likeIcon.classList.remove('bi-hand-thumbs-up-fill');
        likeIcon.classList.add('bi-hand-thumbs-up');

        likeCounter.textContent = parseInt(likeCounter.textContent) - 1;
        updateLikeDislike(comment_id, 'remove');
    } else {
        likeIcon.classList.add('bi-hand-thumbs-up-fill');
        likeIcon.classList.remove('bi-hand-thumbs-up');

        if (dislikeIcon.classList.contains('bi-hand-thumbs-down-fill')) {
            dislikeIcon.classList.remove('bi-hand-thumbs-down-fill');
            dislikeIcon.classList.add('bi-hand-thumbs-down');
            dislikeCounter.textContent = parseInt(dislikeCounter.textContent) - 1;
            updateLikeDislike(comment_id, 'remove');
        }

        likeCounter.textContent = parseInt(likeCounter.textContent) + 1;
        updateLikeDislike(comment_id, 'like');
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
        updateLikeDislike(comment_id, 'remove');
    } else {
        dislikeIcon.classList.add('bi-hand-thumbs-down-fill');
        dislikeIcon.classList.remove('bi-hand-thumbs-down');

        if (likeIcon.classList.contains('bi-hand-thumbs-up-fill')) {
            likeIcon.classList.remove('bi-hand-thumbs-up-fill');
            likeIcon.classList.add('bi-hand-thumbs-up');
            likeCounter.textContent = parseInt(likeCounter.textContent) - 1;
            updateLikeDislike(comment_id, 'remove');
        }

        dislikeCounter.textContent = parseInt(dislikeCounter.textContent) + 1;
        updateLikeDislike(comment_id, 'dislike');
    }
}

function updateLikeDislike(comment_id, action) {
    $.ajax({
        url: '/FableFlow/src/server/api/UpdateCommentsLikesDislikes.php',
        type: 'POST',
        data: { comment_id: comment_id, action: action },
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
function getChapterId(currentURL) {
    let match = currentURL.match(/id=([^&]*)/);
    return match ? match[1] : null;
}