<?php 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

array_push($_SESSION['cssFiles'], 'client/css/Profile.css');
array_push($_SESSION['jsFiles'], 'client/js/Profile.js');

include 'client/Header.php';

?>

<section class="resume">
    <figure class="profile-pic">
        <img id="profile-pic" alt="profile picture">
    </figure> 
    <h2 class="username"></h2>
    <section class="numbers"> 
        <div class="followers-display"></div>
        <div class="followings-display"></div>
    </section>
    <p class="bio"></p>
</section>

<?php
    include 'client/Footer.php';
?>
