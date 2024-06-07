<?php

require __DIR__ . '/../utilities/DbHelper.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

if (isset($_GET['pool_id'])) {
    $author = $db->findBy(['c.pool_id'=>$_GET['pool_id']],['c.pool_id' =>'i'], 1, null, null, '(pools as p JOIN chapters as c ON p.chapter_id = c.chapter_id) 
                                                                    JOIN stories as s ON s.story_id = c.story_id', ['s.username as author']);
    echo json_encode(['author'=>$author[0]]);
} elseif (isset($_GET['chapter_id'])){
    $author = $db->findBy(['c.chapter_id'=>$_GET['chapter_id']],['c.chapter_id' => 'i'], 1, null, null, 'chapters as c JOIN stories as s ON
                            s.story_id = c.story_id', ['s.username as author']);
    error_log("chapter id is " . $_GET['chapter_id']);
    echo json_encode(['author'=>$author[0]['author']]);
} elseif  (isset($_GET['story_id'])) {
    // add here
} elseif (isset($_GET['comment_id'])) {
    // add here
} else {
    echo json_encode(['error' => 'Invalid request']);
    $db->disconnect();
    exit;
}

$db->disconnect();

?>