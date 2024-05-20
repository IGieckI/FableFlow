<?php 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

array_push($_SESSION['cssFiles'],  './css/Profile.css');
array_push($_SESSION['jsFiles'], './js/Profile.js');

require __DIR__. '/../Header.php';

?>

<div style="display: grid; justify-content:center;">
    <section class="resume">
        <figure class="profile-pic">
            <img id="profile-pic" alt="profile picture">
        </figure> 
        <p class="username" id="username"></h2>    
        <p class="followers-display" id="followers-display" ></p>
        <p class="followed-display" id="followed-display"></p>
        <p class="bio"></p>
    </section>
    <section id="tags" class="tags"></section>
    <p id="bio" class="bio"></p>
    <div id="stories"></div>
    </div> 
<?php
    require __DIR__. '/../Footer.php';;
?>