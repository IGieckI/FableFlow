function redirectToProfile(isLogged) {
    if (isLogged=='') {
        window.location.assign("Access.php");
    } else {
        window.location.assign("Profile.php");
    }
}