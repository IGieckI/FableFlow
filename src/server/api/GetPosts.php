<?php
    require __DIR__ . '/../utilities/DbHelper.php';
    require __DIR__ . '/../models/Post.php';

    $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

    // Define the number of posts to load at a time
    define('POSTS_PER_LOAD', 10);

    // Number of page to retrieve
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $page = max(1, $page);

    // Calculate the starting point for retrieving posts
    $start = ($page - 1) * POSTS_PER_LOAD;

    try {
        if (isset($_GET['user'])) {
            $chapters = $db->complexQuery('SELECT' . ' ' .
                                            'c.story_id as story_id,
                                            c.chapter_id as chapter_id,
                                            c.content as content,
                                            c.publication_datetime as publication_datetime' . ' ' . 
                                            'FROM chapters as c JOIN stories as s ON c.story_id = s.story_id' . ' ' .
                                            'JOIN users as u ON s.username = u.username' . ' ' .
                                            "WHERE s.username='". $_GET['user'] . "'");
        } else {
            $chapters = $db->complexQuery("WITH followed_chapters AS (
                SELECT c.chapter_id, c.story_id, c.chapter_title, c.content, c.publication_datetime
                FROM chapters c
                JOIN users u ON c.story_id IN (
                    SELECT s.story_id
                    FROM stories s
                    WHERE s.username IN (
                        SELECT f.followed
                        FROM followers f
                        WHERE f.follower = " . $_SESSION['username'] . "
                    )
                )
            )
            SELECT *
            FROM (
                SELECT * FROM followed_chapters
                UNION
                SELECT c.chapter_id, c.story_id, c.chapter_title, c.content, c.publication_datetime
                FROM chapters c
                ORDER BY RAND()
                LIMIT 10
            ) as final_chapters
            ORDER BY publication_datetime DESC
            LIMIT 10;
            ')");

            error_log("SQL QUERY:" . $chapters);

            error_log("GET POSTS: " . print_r($chapters, true));


            $chapters = $db->findBy([], POSTS_PER_LOAD, $start, Tables::Chapters);
        }

        foreach ($chapters as $chapter) {
            $story = $db->findBy(['story_id' => $chapter['story_id']], null, null, Tables::Stories);
            $story = $story[0];
            $user = $db->findBy(['username' => $story['username']], null, null, Tables::Users);
            $user = $user[0];
            $picture = $chapter['picture'];
            $likes = $db->count(['chapter_id' => $chapter['chapter_id']], Tables::Likes);
            $likes = $likes[0]['COUNT(*)'];
            $comments = $db->count(['comment_id' => $chapter['chapter_id']], Tables::Comments);
            $comments = $comments[0]['COUNT(*)'];

            $result[] = new Post($chapter['chapter_id'],$user['icon'], $user['username'], $chapter['publication_datetime'], $story['title'], $comments, $picture, $likes, $chapter['content']);
        }
        $db->disconnect();
        $db = null;
        header('Content-Type: application/json');

        echo json_encode($result);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
?>