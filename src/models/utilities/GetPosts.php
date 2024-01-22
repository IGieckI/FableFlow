<?php
    require './DbHelper.php';
    require '../Post.php';


    $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

    // Define the number of posts to load at a time
    $postsPerPage = 5;

    // Number of page to retrieve
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $page = max(1, $page); // Ensure page is not less than 1

    // Calculate the starting point for retrieving posts
    $start = ($page - 1) * $postsPerPage;

    try {
        // Fetch posts from the database (replace with your actual database query)
        $chapters = $db->findBy([], $postsPerPage, $start, Tables::Chapters);
        //print_r($chapters);
        foreach ($chapters as $chapter) {
            $story = $db->findBy(['story_id' => $chapter['story_id']], null, null, Tables::Stories);
            $story = $story[0];
            $user = $db->findBy(['username' => $story['username']], null, null, Tables::Users);
            $user = $user[0];
            $likes = $db->count(['chapter_id' => $chapter['chapter_id']], Tables::Likes);
            $likes = $likes[0]['COUNT(*)'];
            $comments = $db->count(['comment_id' => $chapter['chapter_id']], Tables::Comments);
            $comments = $comments[0]['COUNT(*)'];

            $result[] = new Post($chapter['chapter_id'],$user['icon'], $user['username'], $chapter['publication_datetime'], $story['title'], $comments, $likes, $chapter['content']);
        }
        header('Content-Type: application/json');

        echo json_encode($result);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
?>