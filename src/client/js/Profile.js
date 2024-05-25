/* Owner only function, for guests a new image upload will display at reload of page. */
function updateUserProfilePicture(imageId) {
    $.ajax({
        url: '/FableFlow/src/server/api/UpdateUserImage.php',
        type: 'POST',
        data: {'imageId': imageId}, 
        success: function(data) {
            $('#profile-pic').attr("src", "/FableFlow/resources/icons/"+imageId);
            $('#upload').dialog('close');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Profile image update failed:', textStatus, errorThrown);
            console.log(jqXHR.responseText);
        }
    });
}


function uploadImage() {
    $.ajax({
        url: '/FableFlow/src/server/api/UploadImage.php',
        type: 'POST',
        data: new FormData($('#upload_form')[0]), 
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(data) {
            if (data['result']=='notok') {
                alert("Upload failed");
            } else {
                updateUserProfilePicture(data['id']);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Profile image upload failed:', textStatus, errorThrown);
            console.log(jqXHR.responseText);
        }
    });
}


function loadFollowings(username) {
    $.ajax({
        url: '/FableFlow/src/server/api/GetNumberOfFollowed.php',
        type: 'GET',
        dataType: 'json',
        data: {username: username},
        success: function(data) {
            document.querySelector('#followed-display').innerHTML="Following: "+data['nfollowed'];
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Couldnt find followings:', textStatus, errorThrown);
            console.log(jqXHR.responseText);
        }
    });
}

function loadFollowers(username) {
    $.ajax({
        url: '/FableFlow/src/server/api/GetNumberOfFollowers.php',
        type: 'GET',
        dataType: 'json',
        data: {username: username},
        success: function(data) {
            document.querySelector('#followers-display').innerHTML="Followers: "+data['nfollowers'];
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Couldnt find followers:', textStatus, errorThrown);
            console.log(jqXHR.responseText);
        }
    });
}


function isAlreadyFollowing(followed, follower) {
    let result;
    $.ajax({
        url: '/FableFlow/src/server/api/IsItAlreadyAFollower.php',
        type: 'GET',
        dataType: 'json',
        async: false,
        data: {followed: followed, follower: follower},
        success: function(data) {
            result = data['result'];
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Failed AJAX call in follow checking: ', textStatus, errorThrown);
            console.log(jqXHR.responseText);
        }
    });
    return result;
}

function getLoggedUsername() {
    let d;
    $.ajax({
        url: '/FableFlow/src/server/api/GetLoggedUsername.php',
        type: 'GET',
        dataType: 'json',
        async: false,
        success: function(data) {
            d =  data['result'];
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Failed AJAX call in logging checking: ', textStatus, errorThrown);
            console.log(jqXHR.responseText);
        }
    });
    return d;
}

function followOrUnfollow(followed, follower) {
    let isAlreadyFollowing_result = isAlreadyFollowing(followed, follower);
    $.ajax({
        url: '/FableFlow/src/server/api/UpdateFollowship.php',
        type: 'POST',
        data: {followed:followed, follower:follower, isAlreadyFollowing: isAlreadyFollowing_result }, 
        success: function() {
            if (isAlreadyFollowing_result) {
                $('#follow').text("UNFOLLOW");
            } else {
                $('#follow').text("FOLLOW");
            }
            loadFollowers(followed);            
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Failed AJAX call in logging checking: ', textStatus, errorThrown);
            console.log(jqXHR.responseText);
        }
    });
}

function redirectToLogin() {
    window.location.assign = "/FableFlow/src/Access.php";
}

$(document).ready(function() {
    $.ajax({
        url: '/FableFlow/src/server/api/GetViewedUser.php',
        type: 'GET',
        dataType: 'json',
        data: {user_viewing: window.location.search.substring(1).split('&')[0].split('=')[1]},
        success: function(GetViewedUserOutput) {
            let viewer = getLoggedUsername();
            $('#profile-pic').attr("src", "/FableFlow/resources/icons/"+GetViewedUserOutput['user'].pic_uri);
            $('.username').html(GetViewedUserOutput['user'].username);
            $('#bio').html(GetViewedUserOutput['user'].description);
            loadFollowings(GetViewedUserOutput['user'].username);
            loadFollowers(GetViewedUserOutput['user'].username);

            /* Owner code */
            if (GetViewedUserOutput['myprofile']) {
                $( '#upload' ).dialog({
                    modal: true,
                    autoOpen: false,
                    show: {
                      effect: 'drop',
                      duration: 1000
                    },
                    hide: {
                      effect: 'drop',
                      duration: 1000
                    },
                    buttons: {
                        "Confirm upload" : uploadImage
                    }
                }); 
                document.querySelector('#edit').addEventListener('click', function() {
                    $('#upload').dialog('open');
                });
            } else {
                /* Guest code */
                $('#follow').text("FOLLOW");
                if (viewer!='') {
                    if (isAlreadyFollowing(GetViewedUserOutput['user'].username, viewer)) {
                        $('#follow').text("UNFOLLOW");
                    }
                    document.querySelector('#follow').addEventListener('click', function() {
                        followOrUnfollow(GetViewedUserOutput['user'].username, viewer);
                    });
                } else {
                    document.querySelector('#follow').onclick = redirectToLogin;
                }
            }

            $.ajax({
                url: '/FableFlow/src/server/api/GetUserTags.php',
                type: 'GET',
                dataType: 'json',
                data: {username: GetViewedUserOutput['user'].username},
                success: function(data) {
                    
                    let tags_container = document.querySelector('#tags');
                    data['tags'].forEach(element => {
                        let tag = document.createElement('span');
                        tag.innerHTML=""+element['tag'];
                        tags_container.appendChild(tag);
                        
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('User not logged:', textStatus, errorThrown);
                    console.log(jqXHR.responseText);
                }
            });

            loadPosts(0, GetViewedUserOutput['user'].username);

        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('User not logged:', textStatus, errorThrown);
            console.log(jqXHR.responseText);
        }
    });

});

/**
 * Makes an ajax request to get the posts to be displayed.
 * @param  {[number]} page page number to be retrieved.
 * @param {[username]} username of the user for whom the posts are retrieved.
 */
function loadPosts(page, username) {
    $.ajax({
        url: '/FableFlow/src/server/api/GetPosts.php',
        type: 'GET',
        data: { page: page, user: username},
        dataType: 'json',
        success: function(data) {
            console.log(data);
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

/**
 * Returns the html code corrisponding to a specific post. 
 * 
 * @param post An object which is compatible with the object in {@link /FableFlow/src/server/models/Post.php}
 */
function createPostHtml(post) {
    return `
        <div class="post" onclick="redirectToPostPage(${post.chapter_id});">
                <span class="post-publication-time">${getTimeAgo(post.time)}</span>
                <h2 class="post-title">${post.post_title}</h2>
                <div class="post-likes-comments">
                    <span><i class="bi bi-chat-dots"></i>${post.num_comments}</span>
                    <span><i class="bi bi-fire"></i>${post.num_likes}</span>
                </div>
                <p class="post-content">
                    ${post.post_content}
                </p>
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
    window.location.href = `../post/PostPage.php?id=${chapterId}`;
}