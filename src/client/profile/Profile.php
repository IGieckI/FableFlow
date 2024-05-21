<?php 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

array_push($_SESSION['cssFiles'],  './../css/Profile.css');
array_push($_SESSION['jsFiles'], './../js/Profile.js');
array_push($_SESSION['jsFiles'], 'https://cdnjs.cloudflare.com/ajax/libs/uuid/8.3.2/uuid.min.js"');
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
    <?php if (isset($_GET['user_viewing'])) {
        echo 
            '<section id="guest-view">
                <button id="follow"></button>
            </section>';
    } else {
        echo 
            '<section id="owner-view"> 
                <div id="upload" title="Upload Image">
                    <form id="upload_form"> 
                        <label for="filename">Image File</label>
                        <input id="filename" name="filename" type="file"></input>
                        <input type="submit" tabindex="-1" style="position:absolute; top:-1000px"/>
                    </form>
                </div>
                <button id="edit">Upload Image</button>
            </section>';
    } ?>
    <section id="tags" class="tags"></section>
    <p id="bio" class="bio"></p>
    <div id="stories"></div>
    </div> 
<?php
    require __DIR__. '/../Footer.php';;
?>
