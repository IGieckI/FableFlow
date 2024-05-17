<?php

include '../utilities/DbHelper.php';

$db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

/* For each story we need 1) The title 2) The id(for link) 3) Num of Likes*/
$output = [];

$stories = $db->findBy(['username'=>$_POST['username']], null, null, Tables::Stories);

foreach ($stories as $story) {

    $likes = $db->complexQuery("SELECT count(*) as likes FROM likes as l JOIN chapters as c ON
                                l.chapter_id=c.chapter_id WHERE c.story_id = ".$story['story_id']."")[0]['likes'];


    $output[] = array("id"=>$story['story_id'], "title"=>$story['title'], "likes"=>$likes);
}


$db->disconnect();

echo json_encode(["output"=>$output]);


?>