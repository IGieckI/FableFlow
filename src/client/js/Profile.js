$(document).ready(function() {
    let pp = document.getElementById("profile-pic");
    let username = document.getElementsByClassName("username");
    $.ajax({
        url: './server/api/GetLoggedUser.php',
        type: 'GET',
        dataType: 'json',
        success: function(user) {
            pp.setAttribute("src", "/FableFlow/resources/icons/"+user[0].pic_uri+".png");
            username[0].innerHTML =  ""+user[0].username;
            document.querySelector("#bio").innerHTML=user[0].description;
            $.ajax({
                url: './server/api/GetNumberOfFollowers.php',
                type: 'POST',
                dataType: 'json',
                data: {username:user[0].username},
                success: function(data) {
                    document.querySelector('#followers-display').innerHTML="Followers: "+data['nfollowers'];
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Couldnt find followers:', textStatus, errorThrown);
                    console.log(jqXHR.responseText);
                }
            });
        
            $.ajax({
                url: './server/api/GetNumberOfFollowed.php',
                type: 'POST',
                dataType: 'json',
                data: {username: user[0].username},
                success: function(data) {
                    document.querySelector('#followed-display').innerHTML="Following: "+data['nfollowed'];
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Couldnt find followings:', textStatus, errorThrown);
                    console.log(jqXHR.responseText);
                }
            });

            $.ajax({
                url: './server/api/GetUserTags.php',
                type: 'POST',
                dataType: 'json',
                data: {username: user[0].username},
                success: function(data) {
                    
                    let tags_container = document.querySelector('#tags');
                    data['tags'].forEach(element => {
                        let tag = document.createElement('span');
                        console.log(element);
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
                url: './server/api/GetUserStories.php',
                type: 'POST',
                dataType: 'json',
                data: {username: user[0].username},
                success: function(data) {
                    let stories_container = document.querySelector('#stories');
                    data['output'].forEach(element => {
                        let container = document.createElement('div');
                        let title = document.createElement('h3');
                        let like_display = document.createElement('span');
                        let like_icon = document.createElement('i');
                        like_icon.className = "bi bi-fire";
                        let link = document.createElement('a');
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
