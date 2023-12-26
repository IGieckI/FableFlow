<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <style>
        body {
            font-family: "Lato", sans-serif;
            transition: background-color .5s;
        }

        .sidenav {
          height: 100%;
          width: 0;
          position: fixed;
          z-index: 1;
          top: 0;
          right: 0;
          background-color: white;
          border: 1px solid black; /* Light, solid, black border */
          border-radius: 10px; /* Rounded corners */
          overflow-x: hidden;
          transition: 0.5s;
        }

        .sidenav a:hover {
            color: #f1f1f1;
        }

        .sidenav .closebtn {
            font-size: 36px;
            margin-right: 50px;
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 25px;
            color: #818181;
            display: block;
            transition: 0.3s;
        }

        #main {
            transition: margin-right .5s;
            padding: 16px;
        }
    </style>
</head>
<body>

<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

    <ul class="nav navbar-nav">
        <li>
            <i id="lens_icon" class="bi bi-search"></i>
            <form class="navbar-form navbar-left" onsubmit="return submitForm()">
                <div class="form-group">
                    <input type="text" class="form-control" id="searchInput" placeholder="Search" onkeydown="if(event.keyCode==13) submitForm()">
                </div>
            </form>
            <br>
            <p> Trending </p>
            <i id="fire_icon" class="bi bi-fire"></i>
            <br>
            <?php
            $_COOKIE["Trending"] = [];
            foreach ($_COOKIE["Trending"] as $value) {
                echo '<li><a href="' . $value . '">' . $value . '</a></li>';
            }
            ?>
        </li>
        <li>
            <hr>
        </li>
        <li>
            <?php
            $_COOKIE["latest_research"] = [];
            foreach ($_COOKIE["latest_research"] as $value) {
                echo '<li><a href="' . $value . '">' . $value . '</a><button type="button">X</button></li>';
            }
            ?>
        </li>
    </ul>
</div>

<!-- Top Navigation Menu -->
<div class="container">
    <div class="row">
        <div class="col-1">
            <i id="notification_icon" class="bi bi-bell"></i>
        </div>
        <div class="col-1">
            <i id="chat_icon" class="bi bi-chat-dots"></i>
        </div>
        <div class="col d-flex justify-content-center">
            Fableflow
        </div>
        <div class="col-1">
            <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
        </div>
    </div>
</div>

<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
        document.getElementById("main").style.marginRight = "250px";
        document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
        document.getElementById("main").style.marginRight = "0";
        document.body.style.backgroundColor = "white";
    }
</script>

</body>
</html>
