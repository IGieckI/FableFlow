$(document).ready(function() {
    $('#notification_icon').click(function() {
        $('#notification_menu').toggle();
    });

    var page = 0;

    loadPosts(page++);    

    function loadPosts(page) {
        $.ajax({
            url: './server/api/GetPosts.php',
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

    function createPostHtml(post) {
        return `
            <div class="post" onclick="redirectToPostPage(${post.chapter_id});">
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

    // Check for new notifications every 3 seconds
    setInterval(function() {
        $.ajax({
            url: './server/api/GetNotifications.php',
            type: 'GET',
            dataType: 'json',
            success: function(notifications) {
                $('#notification_list').empty();

                //var notifications = JSON.parse(data);
                notifications.forEach(function(notification) {
                    $('#notification_list').append('<li>' + notification.content + ' (' + getTimeAgo(notification.datetime) + ')' + '</li>');
                });

                // Update the notification icon
                if (notifications.length > 0) {
                    $('#notification_icon').removeClass('bi-bell-fill');
                    $('#notification_icon').addClass('bi-bell');
                } else {
                    $('#notification_icon').removeClass('bi-bell-fill');
                    $('#notification_icon').addClass('bi-bell');
                }
            }
        });
    }, 3000);
});

function redirectToPostPage(chapterId) {
    window.location.href = `client/post/PostPage.php?id=${chapterId}`;
}
