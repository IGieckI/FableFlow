<?php
    // Include your database connection file or establish the connection here
    if (isset($_GET['chapter_id'])) {
        require $_SERVER['DOCUMENT_ROOT'] . '/FableFlow/src/models/utilities/DbHelper.php';

        $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

        $chapter = $db->findBy(['chapter_id' => $_GET['chapter_id']], null, null, Tables::Chapters);
        echo $chapter[0]['content'];
    }
?>
