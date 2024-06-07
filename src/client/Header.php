<!DOCTYPE HTML>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- JQuery -->
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="/FableFlow/src/client/js/jquery-ui/jquery-ui.js"></script>

        <!-- CSS files -->
        <?php
            if (isset($_SESSION['cssFiles'])) {
                foreach ($_SESSION['cssFiles'] as $cssFile) {
                    echo "<link rel='stylesheet' href='$cssFile'>";
                }
            }            
        ?>

        <!-- JS files -->
        <?php
            if (isset($_SESSION['jsFiles'])) {
                foreach ($_SESSION['jsFiles'] as $key=>$jsFile) {
                    echo "<script src='$jsFile'></script>";
                }
            }            
        ?>
    </head>


    <body>
        <header>
            <div class="container">
                <div class="row">
                    <div class="col-2">
                        <i id="notification-icon" class="bi bi-bell icons"></i>
                        <div id="notification-menu" class="notification-menu">
                            <ul id="notification-list"></ul>
                        </div>
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
                        <h3>Search for users!</h3>
                        <div class="input-group">
                            <input id="search-text" type="text" class="form-control border-secondary" placeholder="Search..." aria-label="Search" aria-describedby="searchIcon">
                            <button class="btn btn-outline-secondary" type="button" id="searchIcon">
                            <i id="search-icon" class="bi bi-search"></i>
                            </button>
                        </div>
                        <ul id="users-found" class="nav navbar-nav">
                            
                        </ul>
                    </div>
                </div>
            </div>
        </header>
