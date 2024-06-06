<?php
    require __DIR__ . '/../utilities/DbHelper.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    header('Content-Type: application/json');

    $username = $_SESSION['username'];
    $storyTitle = $_POST['story-title'];

    try {
        $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);
        
        $story_id = $db->getStoryID($username, $storyTitle);
        $chapterTitle = $_POST['chapter-title'];
        $content = $_POST['content'];
        $picture = isset($_POST['picture']) ? $_POST['picture'] : NULL;

        $response = $db->postChapter($story_id, $chapterTitle, $content, $picture);

        echo json_encode($response);
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode(['error' => $e->getMessage()]);
    }

    $db->disconnect();
    $db = null;

    header("Location: /FableFlow/src/client/creation/CreateChapter.php");
?>