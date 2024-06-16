<?php
    require __DIR__ . '/../utilities/DbHelper.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_SESSION['username'];
        $proposalId = $_POST['proposalId'];
        $content = $_POST['content'];
        
        try {
            $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);
            $db->postProposalComment($username, $proposalId, $content);
            
            // Notify the author of the chapter
            $proposal = $db->findBy(['proposal_id' => $proposalId], ['proposal_id' => 'i'], null, null, Tables::Proposals)[0];
            $chapter = $db->findBy(['chapter_id' => $proposal['chapter_id']], ['chapter_id' => 'i'], null, null, Tables::Chapters)[0];
            $story = $db->findBy(['story_id' => $chapter['story_id']], ['story_id' => 'i'], null, null, Tables::Stories)[0];
            $author = $db->findBy(['username' => $story['username']], ['username' => 's'], null, null, Tables::Users)[0];
            $db->generateNotification($author['username'], $username . ' commented on your proposal: ' . $proposal['title']);
            echo json_encode(['success' => true]);
            $db->disconnect();
            $db = null;
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
?>
