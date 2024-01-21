$(document).ready(function() {
    var page = 0;

    loadPosts(page++);

    function loadPosts(page) {
        $.ajax({
            url: './models/utilities/GetPosts.php',
            type: 'GET',
            data: { page: page },
            dataType: 'json',
            success: function(data) {
                console.log("Nice");
                if (data.length > 0) {
                    // Append new posts to the container
                    var postsContainer = $('#posts-container');
                    data.forEach(function(post) {
                        // Create HTML for the new post and append it
                        var newPostHtml = createPostHtml(post);
                        postsContainer.append(newPostHtml);

                        // Attach the click event handler to the newly created post
                        $('#posts-container').on('click', '.post', function () {
                            var chapterId = $(this).data('chapter-id');
                            redirectToPostPage(chapterId);
                        });
                    });
                } else {
                    // No more posts to load
                    console.log('No more posts');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error loading posts:', textStatus, errorThrown);
                console.log(jqXHR.responseText); // Log the full responseText
            }
        });
    }

    function createPostHtml(post) {
        return `
            <div class="post" chapter-id="${post.chapter_id}">
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
                    <div class="row post-content">
                        ${post.post_content}
                    </div>
                </div>
            </div>`;
    }

    function getTimeAgo(mysqlDatetime) {
        var mysqlDate = new Date(mysqlDatetime);
        var currentDate = new Date();

        // Calculate the time difference in milliseconds
        var timeDifference = currentDate.getTime() - mysqlDate.getTime();

        // Convert t-he time difference to seconds, minutes, hours, and days
        var seconds = Math.floor(timeDifference / 1000);
        var minutes = Math.floor(seconds / 60);
        var hours = Math.floor(minutes / 60);
        var days = Math.floor(hours / 24);

        // Determine the appropriate unit and value
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

    function redirectToPostPage(postId) {
        window.location.href = `postPage.php?id=${postId}`;
    }
});