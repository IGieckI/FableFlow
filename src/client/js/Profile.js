$(document).ready(function() {
    let pp = document.getElementById("profile-pic");
    let username = document.getElementsByClassName("username");
    let followers_display = document.getElementsByClassName("followers-display");
    let following_display = document.getElementsByClassName("following-display");
    $.ajax({
        url: './server/api/GetLoggedUser.php',
        type: 'GET',
        dataType: 'json',
        success: function(user) {
            pp.setAttribute("src", "/FableFlow/resources/icons/"+user[0].pic_uri+".png");
            username[0].innerHTML =  ""+user[0].username;
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('User not logged:', textStatus, errorThrown);
            console.log(jqXHR.responseText);
        }
    });
})
