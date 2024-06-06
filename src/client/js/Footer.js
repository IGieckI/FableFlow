
function redirectToProfile() {
    window.location.assign('/FableFlow/src/client/profile/Profile.php');
}

function redirectToHome() {
    window.location.assign('/FableFlow/src/Index.php');
}

function redirectToCreation() {
    window.location.assign('/FableFlow/src/client/creation/CreateStory.php');
}

$(document).ready(function() {
    document.querySelector("#home").onclick = redirectToHome;
    document.querySelector('#profile').onclick = redirectToProfile;
    document.querySelector('#creation').onclick = redirectToCreation;
});

