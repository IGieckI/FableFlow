<?php
    require 'DbHelper.php';
    require 'Config.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    header('Content-Type: application/json');

    $response = array();

    try {
        // Instantiate DbHelper with your database configuration
        $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = isset($_POST['title']) ? $_POST['title'] : '';
            $username = isset($_POST['username']) ? $_POST['username'] : '';

            if (!empty($title) && !empty($username)) {
                // Insert into the stories table
                $db->insertInto(["NULL", "'$title'", "'$username'"], Tables::Stories);

                $response['status'] = 'success';
                $response['message'] = 'Post created successfully.';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Title and Username are required.';
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
