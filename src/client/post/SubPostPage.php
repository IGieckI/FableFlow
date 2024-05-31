<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
        $_SESSION['username1'] = 'john_doe';
    }    

    if (isset($_GET['subpage']) and isset($_GET['chapter_id'])) {
        $subpage = $_GET['subpage'];
        $chapter_id = $_GET['chapter_id'];

        $comments_count = 0;

        // Define file paths based on the selected subpage
        $filePath = '';

        switch ($subpage) {
            case 'story':
                $filePath = 'content/Story.php';
                break;
            case 'pools':
                $filePath = 'content/Pools.php';
                break;
            case 'proposals':
                $filePath = 'content/Proposals.php';
                break;
            case 'comments':
                $filePath = 'content/Comments.php';
                echo '<script type="text/JavaScript">  
                        loadComments();

                        $("#send-button").click(function () {
                            var message = $("#message-input").val();

                            if (message.trim() !== "") {
                                $.ajax({
                                    url: "/FableFlow/src/server/api/PostComment.php",
                                    type: "POST",
                                    data: { username: "' . $_SESSION["username1"] . '", chapter_id: getPostId(window.location.href), content: message},
                                    dataType: "json",
                                    success: function(response) {
                                        $("#message-input").val("");
                                        
                                        // Clear the comments container
                                        var commentsContainer = $("#comments-container");
                                        commentsContainer.empty();

                                        // Reload the comments or posts (replace this with the appropriate function)
                                        loadComments();
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        console.error("Error loading comments:", textStatus, errorThrown);
                                        console.log(jqXHR.responseText);
                                    }
                                });
                            }
                        });
                    </script>';
                break;
            default:
                echo "Invalid subpage";
                exit;
        }

        if (file_exists($filePath)) {
            include $filePath;
        } else {
            echo "Content file not found";
        }
    }
?>
