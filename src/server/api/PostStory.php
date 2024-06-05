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

        $title = isset($_POST['title']);
        $username = isset($_POST['username']);

        // Insert into the stories table
        $reponse = $db->postStory($title, $username);

        // Send a notification to all of the followers
        $followers = $db->findBy(['followed' => $username], null, null, Tables::Followers);
        for ($i = 0; $i < count($followers); $i++) {
            $follower = $followers[$i];
            $db->generateNotification($follower, $username . 'posted a new story: ' . $title);
        }

        echo json_encode($response);
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode(['error' => $e->getMessage()]);
    }    

    $db->disconnect();
    $db = null;
?>
