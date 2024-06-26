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
            console.log('Posts loaded:', data);
            if (data.length > 0) {
                // Append new posts to the container
                let postsContainer = $('#posts-container');
                data.forEach(function(post) {
                    let newPostHtml = createPostHtml(post);
                    postsContainer.append(newPostHtml);
                    document.getElementById(post.chapter_id).addEventListener('click', function() {
                        redirectToPostPage(post.chapter_id);
                    });

                    // Add click event listener for the username span
                    let usernameSpan = document.getElementById("username-span-" + post.chapter_id);
                    if (usernameSpan) {
                        usernameSpan.addEventListener('click', function() {
                            goToProfile(post.username);
                            console.log('Clicked on username:', post.username);
                        });
                    }
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
                        <img id="user-image" src="/FableFlow/resources/icons/${post.user_icon}" alt="User Icon" width="30" height="30">
                        <span id="username-span-${post.chapter_id}">${post.username}</span>
                    </div>
                    <div class="col-4 time-text">
                        <span>${getTimeAgo(post.time)}</span>
                    </div>
                </div>

                <div class="row post-title">
                    <div class="col-10">
                        ${post.story_title}
                    </div>        
                    <div class="col-2 post-details">
                        <span><i class="bi bi-chat-dots"></i>${post.num_comments}</span>
                        <span><i class="${post.liked == 0 ? "bi bi-fire" : "bi bi-fire liked"}"></i>${post.num_likes}</span>
                    </div>
                </div>

                <div class="row post-content">
                    ${post.post_content}
                </div>
            </div>
        </div>`;
}

function redirectToPostPage(chapterId) {
    window.location.href = `/FableFlow/src/client/post/ChapterPage.php?id=${chapterId}`;
}
