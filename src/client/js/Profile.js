function updateBio() {
    let newbio = $('#new_bio').val();
    $.ajax({
        url: '/FableFlow/src/server/api/UpdateBio.php',
        type: 'POST',
        data: {'newbio': newbio},
        success: function() {
            $('#bio').text(newbio);
            $('#changeBio').dialog('close');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Bio update failed:', textStatus, errorThrown);
            console.log(jqXHR.responseText);
        }
    }); 
}



/* Owner only function, for guests a new image upload will display at reload of page. */
function updateUserProfilePicture(imageId) {
    $.ajax({
        url: '/FableFlow/src/server/api/UpdateUserImage.php',
        type: 'POST',
        data: {'imageId': imageId}, 
        success: function() {
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
                console.log("Upload failed");
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
                $('#follow').text("FOLLOW");
            } else {
                $('#follow').text("UNFOLLOW");
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
                
                /* Create the Upload image dialog window */
                $( '#upload' ).dialog({
                    modal: true,
                    autoOpen: false,
                    resizable: false,
                    draggable: false,
                    show: {
                      effect: 'drop',
                      duration: 100
                    },
                    hide: {
                      effect: 'drop',
                      duration: 50
                    },
                    buttons: {
                        "Confirm upload" : uploadImage
                    }
                }); 
                /* Add open dialog window on button click event */
                document.querySelector('#edit').addEventListener('click', function() {
                    $('#upload').dialog('open');
                });
                /* Create the Update bio dialog window */
                $( '#changeBio' ).dialog({
                    modal: true,
                    draggable: false,
                    autoOpen: false,
                    resizable: false,
                    show: {
                      effect: 'drop',
                      duration: 100
                    },
                    hide: {
                      effect: 'drop',
                      duration: 50
                    },
                    buttons: {
                        "Confirm update" : updateBio
                    },
                    beforeClose: function() {
                        $('#new_bio').val($('#bio').text());
                    }
                }); 
                /* Open bio update dialog window on button click event */
                document.querySelector('#edit_bio').addEventListener('click', function() {
                    $('#changeBio').dialog('open');
                    /* Hide marker */
                    $('.limit').attr("style", "display: none;");
                });
                /* Add user's bio to update */
                $('#new_bio').text(GetViewedUserOutput['user'].description);
                /* Handling character count limit */
                document.querySelector('#new_bio').addEventListener('input', () => {
                    /* Should be fetched from DB */
                    let character_limit = 50; 
                    if ($('#new_bio').val().length >= character_limit) {
                        $('.limit').attr("style", "display: block;");
                    } else {
                        $('.limit').attr("style", "display: none;");
                    }
                });
                /* Adding to all dialog elements the same graphical element for closing */
                $('button.ui-dialog-titlebar-close').each(function() {
                    $(this).html('<i class="bi bi-x"></i>');
                });
               
            } else {
                /* Guest code */
                $('#follow').text("FOLLOW");
                if (viewer!='') {
                    if (isAlreadyFollowing(GetViewedUserOutput['user'].username, viewer)) {
                        $('#follow').text("UNFOLLOW");
                    }
                    document.querySelector('#follow').addEventListener('click', function() {
                        console.log(GetViewedUserOutput['user']);
                        followOrUnfollow(GetViewedUserOutput['user'].username, viewer);
                    });
                } else {
                    document.querySelector('#follow').onclick = redirectToLogin;
                }
            }

            /*
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
            */

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
        url: '/FableFlow/src/server/api/GetChapters.php',
        type: 'GET',
        data: { page: page, user: username},
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

function redirectToPostPage(chapterId) {
    window.location.href = `../post/ChapterPage.php?id=${chapterId}`;
}

$(window).resize(function() {
    $("#upload").dialog("option", "position", {my: "center", at: "center", of: window});
    $("#changeBio").dialog("option", "position", {my: "center", at: "center", of: window});
    
});