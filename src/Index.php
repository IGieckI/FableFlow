<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    array_push($_SESSION['cssFiles'], 'client/css/Main.css');
    array_push($_SESSION['jsFiles'], 'client/js/Main.js', 'client/js/Utilities.js');
    
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