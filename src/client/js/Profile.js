function isAlreadyFollowing(followed, follower) {
    $.ajax({
        url: '/FableFlow/src/server/api/IsItAlreadyAFollower.php',
        type: 'GET',
        dataType: 'json',
        data: {followed: followed, follower: follower},
        success: function(data) {
            if(data['result']) {
                return true;
            } else {
                return false;
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Failed AJAX call in follow checking: ', textStatus, errorThrown);
            console.log(jqXHR.responseText);
        }
    });
}

function getLoggedUsername() {
    $.ajax({
        url: '/FableFlow/src/server/api/GetLoggedUsername.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            return data['result'];
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Failed AJAX call in logging checking: ', textStatus, errorThrown);
            console.log(jqXHR.responseText);
        }
    });
}

function followOrUnfollow() {
    
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
            $('#profile-pic').attr("src", "/FableFlow/resources/icons/"+GetViewedUserOutput['user'].pic_uri+".png");
            $('.username').html(GetViewedUserOutput['user'].username);
            $('#bio').html(GetViewedUserOutput['user'].description);


            if (GetViewedUserOutput['myprofile']==true) {
                
            } else {
                console.log($('#follow'));
                $('#follow').text("FOLLOW");
                if (getLoggedUsername()!='') {
                    if (isAlreadyFollowing(GetViewedUserOutput['user'].username, getLoggedUsername())) {
                        $('#follow').text("UNFOLLOW");
                    }
                    document.querySelector('#follow').onclick = followOrUnfollow;
                } else {
                    document.querySelector('#follow').onclick = redirectToLogin;
                }
                
                
            }


            $.ajax({
                url: '/FableFlow/src/server/api/GetNumberOfFollowers.php',
                type: 'GET',
                dataType: 'json',
                data: {username:GetViewedUserOutput['user'].username},
                success: function(data) {
                    document.querySelector('#followers-display').innerHTML="Followers: "+data['nfollowers'];
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Couldnt find followers:', textStatus, errorThrown);
                    console.log(jqXHR.responseText);
                }
            });
        
            $.ajax({
                url: '/FableFlow/src/server/api/GetNumberOfFollowed.php',
                type: 'GET',
                dataType: 'json',
                data: {username: GetViewedUserOutput['user'].username},
                success: function(data) {
                    document.querySelector('#followed-display').innerHTML="Following: "+data['nfollowed'];
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Couldnt find followings:', textStatus, errorThrown);
                    console.log(jqXHR.responseText);
                }
            });

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
