/* PAGE NEEDS TO BE DECLARED OUTSIDE, SCOPING RULES??? */
$(document).ready(function() {
    let page = 0;
    loadPosts(page++);
});


/**
 * Makes an ajax request to get the posts to be displayed.
 * @param  {[number]} page page number to be retrieved.
 */
function loadPosts(page) {
    $.ajax({
        url: '/FableFlow/src/server/api/GetChapters.php',
        type: 'GET',
        data: { page: page },
        dataType: 'json',
        success: function(data) {
            if (data.length > 0) {
                // Append new posts to the container
                var postsContainer = $('#posts-container');
                data.forEach(function(post) {
                    var newPostHtml = createPostHtml(post);
                    postsContainer.append(newPostHtml);
                    document.getElementById(post.chapter_id).addEventListener('click', function() {
                        redirectToPostPage(post.chapter_id);
                    });
                });
            } else {
                console.log('No more posts');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error loading posts:', textStatus, errorThrown);
            console.log(jqXHR.responseText);
        }
    });
}

/**
 * Returns the html code corrisponding to a specific post. 
 * 
 * @param post An object which is compatible with the object in {@link /FableFlow/src/server/models/Post.php}
 */
function createPostHtml(post) {
    return `
        <div class="post" id="${post.chapter_id}">
            <div class="container-fluid">
                <div class="row user-info">
                    <div class="col-8">
                        <img src="${post.user_icon}" alt="User Icon" width="30" height="30">
                        <span>${post.username}</span>
                    </div>
                    <div class="col-4 time-text">
                        <span>${getTimeAgo(post.time)}</span>
                    </div>
                </div>

                <div class="row post-title">
                    <div class="col-10">
                        ${post.post_title}
                    </div>        
                    <div class="col-2 post-details">
                        <span><i class="bi bi-chat-dots"></i>${post.num_comments}</span>
                        <span><i class="bi bi-fire"></i>${post.num_likes}</span>
                    </div>
                </div>
                
                ${post.picture ? `<div class="row post-picture"><img src="${post.picture}" alt="Post Image" class="img-fluid"></div>` : ''}

                <div class="row post-content">
                    ${post.post_content}
                </div>
            </div>
        </div>`;
}


function getTimeAgo(mysqlDatetime) {
    let mysqlDate = new Date(mysqlDatetime);
    let currentDate = new Date();

    let timeDifference = currentDate.getTime() - mysqlDate.getTime();

    let seconds = Math.floor(timeDifference / 1000);
    let minutes = Math.floor(seconds / 60);
    let hours = Math.floor(minutes / 60);
    let days = Math.floor(hours / 24);

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

function redirectToPostPage(chapterId) {
    window.location.href = `/FableFlow/src/client/post/PostPage.php?id=${chapterId}`;
}
