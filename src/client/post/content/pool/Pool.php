<?php
require $_SERVER['DOCUMENT_ROOT'] . '/FableFlow/src/server/utilities/DbHelper.php';

function hasExpired($date_r) {
    $date = date_create_from_format('Y-m-d H:i:s',$date_r);
    $difference = date_diff(date_create(date("Y-m-d H:i:s")), $date, FALSE);
    if ($difference->invert==1) {
        return true;
    } else {
        return false;
    }
}

$db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

$result = $db->findBy(['pool_id'=>$_GET['pool_id'], 'chapter_id'=>$_GET['chapter_id']], null, null, Tables::Pools);

$db->disconnect();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Page</title>
</head>
<body>
    <!-- Button to go back -->
    <button onclick="window.history.back();">Go Back</button>
    <!-- Title -->
    <h1><?php echo $result[0]['title']?></h1>
    <!-- Textarea -->
    <textarea rows="10" cols="50"><?php echo $result[0]['content']?></textarea>
    <!-- Unordered list of checkboxes -->
    <ul>

    </ul>
</body>
</html>