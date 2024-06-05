<?php
    require __DIR__ . '/../utilities/DbHelper.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_SESSION['username'];
        $proposalId = $_POST['proposalId'];

        $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);
        
        $proposalStatus = $db->proposalStatus($proposalId, $username);

        if ($proposalStatus == 0) {
            $db->updateProposalLikes($username, $proposalId, "like");
        } else {
            $db->updateProposalLikes($username, $proposalId, "unlike");
        }

        $proposalStatus = $db->proposalStatus($proposalId, $username);

        // Use the count function to get the number of likes of the proposal
        $likes = $db->count(['proposal_id' => $proposalId], Tables::Likes)[0]['COUNT(*)'];

        $db->disconnect();
        $db = null;

        echo json_encode(['likes' => $likes, 'status' => $proposalStatus]);
    } else {
        echo 'Invalid request method';
    }
?>
