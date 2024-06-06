<?php 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

array_push($_SESSION['cssFiles'],  './../css/Profile.css');
array_push($_SESSION['jsFiles'], './../js/Profile.js', '/FableFlow/src/client/js/Utilities.js');
array_push($_SESSION['jsFiles'], 'https://cdnjs.cloudflare.com/ajax/libs/uuid/8.3.2/uuid.min.js"');
require __DIR__. '/../Header.php';

?>

<div style="display: grid; justify-content:center;">
    <section class="resume">
        <figure class="profile-pic">
            <img id="profile-pic" alt="profile picture">
        </figure> 
        <span class="username" id="username"></span>    
        <span class="followers-display" id="followers-display" ></span>
        <span class="followed-display" id="followed-display"></span>
        <p class="bio"></p>
    </section>
    <?php if (isset($_GET['user_viewing']) && strcmp($_GET['user_viewing'], $_SESSION['username'])!=0) {
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
                <div id="changeBio" title="Change bio">
                    <form id="bio_upload_form">
                        <label for="new_bio">Add here your new bio:</label>
                        <i class="bi bi-exclamation-circle limit">The bio character limit is 50!</i>
                        <textarea id="new_bio" name="new_bio" maxlength="50"></textarea>
                        <input type="submit" tabindex="-1" style="position:absolute; top: -1000px"/> 
                    </form>
                </div>
                <button id="edit_bio">Edit Bio</button>
            </section>';
    } ?>
    <section id="tags" class="tags"></section>
    <p id="bio" class="bio"></p>
    <div id="posts-container">
                    <!-- Posts will be loaded here -->
    </div> 

</div>
<?php
    require __DIR__. '/../Footer.php';;
?>
