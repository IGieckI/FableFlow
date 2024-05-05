<!DOCTYPE HTML>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>Home</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- JQuery -->
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    
        <!-- CSS files -->
        <link rel="stylesheet" href="/FableFlow/src/client/css/Footer.css">
        <link rel="stylesheet" href="/FableFlow/src/client/css/Header.css">
        <?php
            if (isset($_SESSION['cssFiles'])) {
                foreach ($_SESSION['cssFiles'] as $cssFile) {
                    echo "<link rel='stylesheet' href='$cssFile'>";
                }
            }            
        ?>

        <!-- JS files -->
        <script src="/FableFlow/src/client/js/Main.js"></script>
        <?php
            if (isset($_SESSION['jsFiles'])) {
                foreach ($_SESSION['jsFiles'] as $jsFile) {
                    echo "<script src='$jsFile'></script>";
                }
            }            
        ?>
    </head>


    <body>
        <header>
            <div class="container">
                <div class="row">
                    <div class="col-1">
                        <i id="notification_icon" class="bi bi-bell icons"></i>
                        <div id="notification_menu" class="notification-menu">
                            <ul id="notification_list"></ul>
                        </div>
                    </div>
                    <div class="col-1">
                        <i id="chat_icon" class="bi bi-chat-dots icons"></i>
                    </div>
                    <div class="col d-flex justify-content-center maintext">
                        Fableflow
                    </div>
                    <div class="col-2">
                        <button class="btn btn-side-hamburgher icons" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                            <i class="bi bi-list"></i>
                        </button>
                    </div>

                </div>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                    <div class="offcanvas-header">
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>          
                    </div>
                    <div class="offcanvas-body">
                        <div class="input-group">
                            <input type="text" class="form-control border-secondary" placeholder="Search..." aria-label="Search" aria-describedby="searchIcon">
                            <button class="btn btn-outline-secondary" type="button" id="searchIcon">
                            <i id="search_icon" class="bi bi-search"></i>
                            </button>
                        </div>
                        <ul class="nav navbar-nav">
                            <div class="row">
                                <i class="bi bi-fire"></i>
                                <p> Trending </p>
                                <?php
                                    $_COOKIE["Trending"] = [];
                                    foreach ($_COOKIE["Trending"] as $value) {
                                        echo '<div class="row"><a href="' . $value . '">' . $value . '</a></div>';
                                }
                                ?>
                            </div>
                            <div class="row">
                                <hr>
                            </div>
                            <div class="row">
                                <?php
                                $_COOKIE["latest_research"] = [];
                                    foreach ($_COOKIE["latest_research"] as $value) {
                                        echo '<div class="row"><a href="' . $value . '">' . $value . '</a><button type="button">X</button></div>';
                                }
                                ?>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
    </body>
</html>