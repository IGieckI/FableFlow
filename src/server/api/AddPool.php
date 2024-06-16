<?php

require_once __DIR__ . '/../utilities/DbHelper.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

$title = $_POST['title'];
$content = $_POST['content'];
$choices = $_POST['choices'];

$chapterId = $_POST['chapterId'];
$exp_date = $_POST['expire_datetime'];

$db->insertInto([$chapterId, "'$title'","'$content'", "'$exp_date'"], Tables::Pools, [  'chapter_id',
                                                                                    'title',
                                                                                    'content',
                                                                                    'expire_datetime']);
$pool_id = $db->complexQuery('SELECT MAX(pool_id) as pool_id FROM pools', array(), array())[0]['pool_id'];


foreach($choices as $choice) {
    $db->insertInto([$pool_id, "'$choice'"], Tables::Options, ['pool_id', 'content']);
}


?>