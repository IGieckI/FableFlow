<!DOCTYPE HTML>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <title>Home</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
        <!-- CSS files -->
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/styles.css">
        <link rel="stylesheet" href="css/home.css">
    </head>
    <body>
        <?php include 'header.php'; ?>
        <main>
            <div class="main-container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <!-- Sample Post 1 -->
                        <div class="post-container">
                            <div class="container">
                                <div class="row user-info">
                                    <div class="col-10">
                                        <img src="user-icon.png" alt="User Icon" width="30" height="30"> <!-- Replace with actual user icon -->
                                        <span>Username</span>
                                    </div>
                                    <div class="col-2">
                                        <span>1 hour ago</span>
                                    </div>
                                </div>

                                <div class="row post-title">
                                    <div class="col-10">
                                        Post Title 1
                                    </div>        
                                    <div class="col-2 post-details">
                                        <span><i class="bi bi-chat-dots"></i> 10</span>
                                        <span><i class="bi bi-fire"></i> 20</span>
                                    </div>
                                </div>                

                                <div class="row post-content">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis commodo odio aenean sed adipiscing diam donec. Egestas congue quisque egestas diam in arcu cursus euismod. Duis ut diam quam nulla porttitor massa. Maecenas pharetra convallis posuere morbi leo. Morbi tincidunt ornare massa eget egestas purus viverra accumsan. 
                                </div>
                            </div>                
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include 'footer.php'; ?>
    </body>    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</html>