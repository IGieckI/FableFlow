<?php
    require 'DbHelper.php';
    require 'Config.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    header('Content-Type: application/json');

    $username = $_SESSION['username'];
    $storyTitle = $_POST['story_title'];

    try {
        $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

        $story_id = $db->getStoryID($username, $storyTitle);
        $chapter_title = $_POST['chapter_title'];
        $content = $_POST['content'];
        $picture = isset($_POST['picture']) ? $_POST['picture'] : NULL;

        $db->postChapter($story_id, $chapter_title, $content, $picture);

        echo json_encode($response);
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode(['error' => $e->getMessage()]);
    }

    $db->disconnect();
    $db = null;
?>
