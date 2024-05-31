
function redirectToProfile() {
    window.location.assign('/FableFlow/src/client/profile/Profile.php');
}

function redirectToHome() {
    window.location.assign('/FableFlow/src/Index.php');
}

$(document).ready(function() {
    document.querySelector("#home").onclick = redirectToHome;
    document.querySelector('#profile').onclick = redirectToProfile;
});

