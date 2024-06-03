<?php
    require 'DbHelper.php';
    require 'Config.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    header('Content-Type: application/json');

    $response = array();

    try {
        $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $story_id = isset($_POST['story_id']) ? intval($_POST['story_id']) : 0;
            $chapter_title = isset($_POST['chapter_title']) ? $_POST['chapter_title'] : '';
            $content = isset($_POST['content']) ? $_POST['content'] : '';
            $publication_datetime = isset($_POST['publication_datetime']) ? $_POST['publication_datetime'] : '';

            if ($story_id > 0 && !empty($chapter_title) && !empty($content) && !empty($publication_datetime)) {
                $db->insertInto(["NULL", $story_id, "'$chapter_title'", "'$content'", "'NULL'", "'$publication_datetime'"], Tables::Chapters);

                $response['status'] = 'success';
                $response['message'] = 'Chapter created successfully.';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Story ID, Chapter Title, Content, and Publication DateTime are required.';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Invalid request method.';
        }

        $db->disconnect();
    } catch (Exception $e) {
        $response['status'] = 'error';
        $response['message'] = 'Exception: ' . $e->getMessage();
    }

    echo json_encode($response);
?>
