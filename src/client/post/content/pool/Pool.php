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

if (isset($_GET['pool_id']) && isset($_GET['chapter_id'])) {

$result = $db->findBy(['pool_id'=>$_GET['pool_id'], 'chapter_id'=>$_GET['chapter_id']], ['pool_id' => 'i', 'chapter_id' => 'i'], null, null, Tables::Pools);

$choices = $db->findBy(['p.pool_id'=>$_GET['pool_id']], ['p.pool_id' => 'i'], null, null, null, 'options as o JOIN pools as p ON o.pool_id=p.pool_id', ['o.content as content, o.option_id as option_id']);

    if (isset($_SESSION['LOGGED'])) {
        $choice = $db->findBy(['p.pool_id'=>$_GET['pool_id'], 'oc.username'=>$_SESSION['username']], ['p.pool_id' => 'i', 'oc.username' => 's'], null, null, null,
        '(options_choices as oc JOIN options as o ON oc.option_id=o.option_id) JOIN pools as p ON p.pool_id = o.pool_id',
        ['oc.option_id as option_id']);
    }

} else {
    die('pool not found');
}

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
    <?php
        $list = "<ul>";
        foreach ($choices as $choice) {
            $list.= '<li>
                    <label for="'. $choice['option_id'] .'">'.$choice['content'].'</label>
                    <input type="checkbox" id="'. $choice['option_id']. '"></li>';
        }
        $list .= "</ul>";
        echo $list;
    ?>
</body>
</html>