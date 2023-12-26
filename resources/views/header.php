<header>
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
</header>
