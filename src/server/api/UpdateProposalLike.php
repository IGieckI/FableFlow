<?php
    require __DIR__ . '/../utilities/DbHelper.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    try{
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
            $likes = $db->count(['proposal_id' => $proposalId], ['proposal_id' => 'i'], Tables::Likes);
    
            $db->disconnect();
            $db = null;
    
            echo json_encode(['likes' => $likes, 'status' => $proposalStatus]);
        } else {
            echo 'Invalid request method';
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
?>
