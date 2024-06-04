<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    array_push($_SESSION['cssFiles'], '/FableFlow/src/client/css/Comments.css', '/FableFlow/src/client/css/Proposals.css', '/FableFlow/src/client/css/Proposal.css');
    array_push($_SESSION['jsFiles'], '/FableFlow/src/client/js/PostPage.js', '/FableFlow/src/client/js/Comments.js', '/FableFlow/src/client/js/Proposal.js');

    require $_SERVER['DOCUMENT_ROOT'] . '/FableFlow/src/client/Header.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/FableFlow/src/server/utilities/DbHelper.php';

    $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

    $chapter = $db->getChapter($_GET['id']);
    $story = $db->getStory($chapter[0]['story_id']);
    $author = $db->getUser($story[0]['username']);
    $likes = $db->count(['chapter_id' => $chapter[0]['chapter_id']], Tables::Likes);
?>

<div class="container">
    <div class="row">
        <div class="col-1">
            <i class="bi bi-chevron-left align-middle" onclick="history.back()"></i>
        </div>
        <div class="col">
            <h5 class="font-weight-bold"><?php echo $chapter[0]['chapter_title']; ?></h5>
        </div>
        <div class="col-2">
            <span><i class="bi bi-fire"></i><?php echo $likes[0]['COUNT(*)']; ?></span>
        </div>
        <div id="user_icon" username=<?php echo $author[0]['username']?> class="col-2">
            <img src="<?php echo $author[0]['icon']; ?>" alt="User Icon" width="30" height="30">
        </div>
    </div>
    <div class="row">
        <div class="col">
            <button id="load_story_button" class="btn btn-block" data-story-id="<?php echo $_GET['id']; ?>">Story</button>
        </div>
        <div class="col">
            <button id="load_pools_button" class="btn btn-block" data-story-id="<?php echo $_GET['id']; ?>">Pools</button>
        </div>
        <div class="col">
            <button id="load_proposals_button" class="btn btn-block" data-story-id="<?php echo $_GET['id']; ?>">Proposals</button>
        </div>
        <div class="col">
            <button id="load_comments_button" class="btn btn-block" data-story-id="<?php echo $_GET['id']; ?>">Comments</button>
        </div>
    </div>
    <div id="subpageContent" class="row" style="margin: 5%;">
        
    </div>
</div>

<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/FableFlow/src/client/Footer.php';
?>