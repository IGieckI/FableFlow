<?php
    require __DIR__ . '/../utilities/DbHelper.php';
    require __DIR__ . '/../models/Proposal.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

    $chapter_id = $_GET['chapter_id'];

    try {
        $proposals = $db->getProposals($chapter_id);

        foreach ($proposals as $proposal) {
            $proposalId = $proposal['proposal_id'];
            $chapterId = $proposal['chapter_id'];
            $user = $db->findBy(['username' => $proposal['username_proposing']], null, null, Tables::Users);
            $user = $user[0];
            $title = $proposal['title'];
            $publicationDatetime = $proposal['publication_datetime'];
            $content = $proposal['content'];
            $num_likes = $db->count(['proposal_id' => $proposalId, 'is_dislike' => 0], Tables::Likes);
            $num_likes = $num_likes[0]['COUNT(*)'];
            $num_comments = $db->count(['proposal_id' => $proposalId], Tables::Comments);
            $num_comments = $num_comments[0]['COUNT(*)'];
            $result[] = new Proposal($proposalId, $chapterId, $user, $title, $publicationDatetime, $content, $num_likes, $num_comments);
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