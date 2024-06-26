<?php
    require __DIR__ . '/../utilities/DbHelper.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    try {
        // Get the form data
        $title = $_POST['title'];
        $content = $_POST['content'];
        $chapter_id = $_POST['hidden-chapter-id'];
        if (!isset($_SESSION['username'])) {
            http_response_code(401);
            echo json_encode(['error' => 'You must be logged in to post a proposal']);
            header('Location: ' . '/FableFlow/src/client/post/ChapterPage.php?id=' . $chapter_id);
            exit();
        }
        $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);
        $db->postProposal($chapter_id, $_SESSION['username'], $title, $content);
        echo json_encode(['success' => true]);

        $db->disconnect();
        $db = null;
    
        header('Location: ' . '/FableFlow/src/client/post/ChapterPage.php?id=' . $chapter_id);
    } catch (Exception $e) {

        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
?>

