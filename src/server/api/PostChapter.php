<?php
    require __DIR__ . '/../utilities/DbHelper.php';
    require __DIR__. '/UploadChapterImage.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    try {
        $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

        header('Content-Type: application/json');

        $username = $_SESSION['username'];
        $storyTitle = $_POST['story-title'];
        $chapterTitle = $_POST['chapter-title'];
        $content = $_POST['content'];
        if (isset($_FILES['chapter-image'])){
            $image = $_FILES['chapter-image'];
            $i[] = uploadChapterImage($image);
        }
        $story_id = $db->getStoryID($username, $storyTitle);
        if(isset($i)){
            $picture = $i[0]['id'];
        }
        else{
            $picture= NULL;
        }

        $response = $db->postChapter($story_id, $chapterTitle, $content, $picture);

        echo json_encode($response);
        
        $db->disconnect();
        $db = null;

        header("Location: /FableFlow/src/client/creation/CreateChapter.php");
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode(['error' => $e->getMessage()]);
    }
?>
