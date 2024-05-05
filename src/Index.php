<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION['cssFiles'] = ['client/css/Main.css'];

    include 'client/Header.php';
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
    include 'client/Footer.php';
?>