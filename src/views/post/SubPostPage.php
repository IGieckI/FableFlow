<?php
    if (isset($_GET['subpage']) and isset($_GET['chapter_id'])) {
        $subpage = $_GET['subpage'];
        $chapter_id = $_GET['chapter_id'];

        // Define file paths based on the selected subpage
        $filePath = '';

        switch ($subpage) {
            case 'story':
                $filePath = 'content/Story.php';
                break;
            case 'pools':
                $filePath = 'content/pools.php';
                break;
            case 'proposals':
                $filePath = 'content/proposals.php';
                break;
            case 'comments':
                $filePath = 'content/comments.php';
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
