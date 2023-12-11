<header>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Brand</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li>
            <img src="$LENS_ICON">
            <form class="navbar-form navbar-left">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search"> /* SOMEHOW THIS HAVE TO SUBMIR WITH "ENTER" OR REAL TIME */
                </div>
            </form>
            <br>
            <p> Trending </p>
            <img src="$FIRE_ICON">
            <br>
            <?php
                foreach ($_COOKIE["Trending"] as $value) {      /*THIS HAVE TO SHOW THE TOP 3 TRENDING PROFILES*/
                    <li>
                        <a href="!!! INSERIRE IL LINK DELLA PAGINA UTENTE !!!">$value</a>
                    </li>
                }
            ?>
        </li>
        <li>            
            <hr>
        </li>
        <li>
            <?php
                foreach ($_COOKIE["latest_research"] as $value) {
                    <li>
                        <a href="!!! INSERIRE IL LINK DELLA PAGINA UTENTE !!!">$value</a>
                        <button type="button">X</button> /*FIX THE ICON OF THE BUTTON*/
                    </li>
                } /* Should be a for loop with the top 3 profile link */
            ?>
        </li>
      </ul>      
    </div>
  </div>
</nav>
    <img id="notification_icon" src="$NOTIFICATION_ICON">
    <img id="chat_icon" src="$CHAT_ICON">
    <h1>FableFlow</h1>
</header>