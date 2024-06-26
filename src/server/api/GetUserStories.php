<?php
    require '../utilities/DbHelper.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    try{
        $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

    /* For each story we need 1) The title 2) The id(for link) 3) Num of Likes*/
    $output = [];

    $stories = $db->findBy(['username'=>$_GET['username']], ['username' => 's'], null, null, Tables::Stories);

    foreach ($stories as $story) {

        $likes = $db->complexQuery("SELECT count(*) as likes FROM likes as l JOIN chapters as c ON
                                    l.chapter_id=c.chapter_id WHERE c.story_id = ?", [$_GET['story_id']], ['i'])[0]['likes'];

        $output[] = array("id"=>$story['story_id'], "title"=>$story['title'], "likes"=>$likes);
    }

        $db->disconnect();
        $db = null;

        echo json_encode(["output"=>$output]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
?>