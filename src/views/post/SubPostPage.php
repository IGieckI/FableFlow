<?php
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
