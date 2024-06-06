<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }    

    if (isset($_GET['subpage'])) {
        $subpage = $_GET['subpage'];

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
                break;
            case 'create-proposal':
                $filePath = 'content/proposal/CreateProposal.html';
                break;
            case 'read-proposal':
                $filePath = 'content/proposal/Proposal.php';
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
