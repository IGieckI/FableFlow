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

            $.ajax({
                url: './server/api/GetNumberOfFollowers.php',
                type: 'POST',
                dataType: 'json',
                data: {username:user[0].username},
                success: function(data) {
                    document.querySelector('#followers-display').innerHTML="Followers: "+data['nfollowers'];
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('User not logged:', textStatus, errorThrown);
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
