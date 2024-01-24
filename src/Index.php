<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION['cssFiles'] = ['views/css/Main.css'];
    $_SESSION['jsFiles'] = ['views/js/Main.js'];

    include 'views/Header.php';
?>

<div class="main-container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div id="posts-container">
                <!-- Posts will be loaded here -->
            </div>                        
        </div>
    </div>
</div>

<?php
    include 'views/Footer.php';
?>