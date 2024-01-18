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
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/footer.css">
        <link rel="stylesheet" href="css/home.css">
    </head>
    <body>
        <?php include 'header.php'; ?>
        <main>
            <div class="main-container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div id="posts-container">
                            <!-- Posts will be loaded here -->
                        </div>                        
                    </div>
                </div>
            </div>
        </main>
        <?php include 'footer.php'; ?>
    </body>
    <script>
        $(document).ready(function() {
            var page = 0;

            loadPosts(page++);

            function loadPosts(page) {
                $.ajax({
                    url: '../db/get_posts.php',
                    type: 'GET',
                    data: { page: page },
                    dataType: 'json',
                    success: function(data) {
                        if (data.length > 0) {
                            console.log("Nice");
                            // Append new posts to the container
                            var postsContainer = $('#posts-container');
                            data.forEach(function(post) {
                                // Create HTML for the new post and append it;
                                var newPostHtml = createPostHtml(post);
                                postsContainer.append(newPostHtml);
                            });
                        } else {
                            // No more posts to load
                            console.log('No more posts');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error loading posts:', textStatus, errorThrown);
                        console.log(jqXHR.responseText); // Log the full responseText
                    }
                });
            }

            function createPostHtml(post) {
                return `
                    <div class="post" onclick="window.location.href='postPage.php';">
                        <div class="container-fluid">
                            <div class="row user-info">
                                <div class="col-10">
                                    <img src="${post.user_icon}" alt="User Icon" width="30" height="30">
                                    <span>${post.username}</span>
                                </div>
                                <div class="col-2">
                                    <span>${getTimeAgo(post.time)}</span>
                                </div>
                            </div>

                            <div class="row post-title">
                                <div class="col-10">
                                    ${post.post_title}
                                </div>        
                                <div class="col-2 post-details">
                                    <span><i class="bi bi-chat-dots"></i>${post.num_likes}</span>
                                    <span><i class="bi bi-fire"></i>${post.num_comments}</span>
                                </div>
                            </div>
                            <div class="row post-content">
                                ${limitString(post.post_content, 200)}
                            </div>
                        </div>
                    </div>`;
            }

            function getTimeAgo(mysqlDatetime) {
                var mysqlDate = new Date(mysqlDatetime);
                var currentDate = new Date();

                // Calculate the time difference in milliseconds
                var timeDifference = currentDate.getTime() - mysqlDate.getTime();

                // Convert t-he time difference to seconds, minutes, hours, and days
                var seconds = Math.floor(timeDifference / 1000);
                var minutes = Math.floor(seconds / 60);
                var hours = Math.floor(minutes / 60);
                var days = Math.floor(hours / 24);

                // Determine the appropriate unit and value
                if (days > 0) {
                    return days + ' days ago';
                } else if (hours > 0) {
                    return hours + ' hours ago';
                } else if (minutes > 0) {
                    return minutes + ' minutes ago';
                } else {
                    return seconds + ' seconds ago';
                }
            }

            function limitString(inputString, maxLength) {
                if (inputString.length > maxLength) {
                    return inputString.substring(0, maxLength) + '...';
                }
                return inputString;
            }
        });
    </script>
</html>
