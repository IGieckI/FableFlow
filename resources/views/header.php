<header>
    <div class="container">
        <div class="row">
            <div class="col-1">
                <i id="notification_icon" class="bi bi-bell icons"></i>
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
