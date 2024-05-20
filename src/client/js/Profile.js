function uploadImage() {
    console.log($('#upload_form'));
    $.ajax({
        url: '/FableFlow/src/server/api/UploadImage.php',
        type: 'POST',
        data: new FormData($('#upload_form')[0]), 
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(data) {
            alert(data['result']);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Profile image upload failed:', textStatus, errorThrown);
            console.log(jqXHR.responseText);
        }
    });
}


function updateFollowings(username) {
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

function updateFollowers(username) {
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
            updateFollowers(followed);            
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
            $('#profile-pic').attr("src", "/FableFlow/resources/icons/"+GetViewedUserOutput['user'].pic_uri+".png");
            $('.username').html(GetViewedUserOutput['user'].username);
            $('#bio').html(GetViewedUserOutput['user'].description);
            updateFollowings(GetViewedUserOutput['user'].username);
            updateFollowers(GetViewedUserOutput['user'].username);

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

            $.ajax({
                url: '/FableFlow/src/server/api/GetUserStories.php',
                type: 'GET',
                dataType: 'json',
                data: {username: GetViewedUserOutput['user'].username},
                success: function(data) {
                    let stories_container = document.querySelector('#stories');
                    data['output'].forEach(element => {
                        let container = document.createElement('div');
                        let title = document.createElement('h3');
                        let like_display = document.createElement('span');
                        let like_icon = document.createElement('i');
                        let link = document.createElement('a');
                        like_icon.className = "bi bi-fire";
                        title.innerHTML = element['title'];
                        like_display.innerHTML = element['likes'];
                        like_display.appendChild(like_icon);
                        container.appendChild(title);
                        container.appendChild(like_display);
                        stories_container.appendChild(container);
                        
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('User not logged:', textStatus, errorThrown);
                    console.log(jqXHR.responseText);
                }
            });


        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('User not logged:', textStatus, errorThrown);
            console.log(jqXHR.responseText);
        }
    });

});
