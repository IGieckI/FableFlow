<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap Offcanvas Example</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-6">
                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">&#9776;</button>
            </div>
        </div>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>          
            </div>
            <div class="offcanvas-body">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search..." aria-label="Search" aria-describedby="searchIcon">
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

</body>

</html>
