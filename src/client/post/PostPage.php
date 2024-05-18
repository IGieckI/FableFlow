<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION['cssFiles'] = ['../css/Comments.css'];
    $_SESSION['jsFiles'] = ['../js/PostPage.js', '../js/Comments.js'];

    require $_SERVER['DOCUMENT_ROOT'] . '/FableFlow/src/client/Header.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/FableFlow/src/server/utilities/DbHelper.php';

    $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

    //error_log("---POST PAGE---->" . $_GET['id'] . "<-----------");

    $chapter = $db->getChapter($_GET['id']);
    $story = $db->getStory($chapter[0]['story_id']);
    $author = $db->getUser($story[0]['username']);
    $likes = $db->count(['chapter_id' => $chapter[0]['chapter_id']], Tables::Likes);

    /*print_r($chapter);
    print_r($story);
    print_r($author);
    print_r($likes);*/
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
        <div class="col-2">
            <img src="<?php echo $author[0]['icon']; ?>" alt="User Icon" width="30" height="30">
        </div>
    </div>
    <div class="row">
        <div class="col">
            <button class="btn btn-block" onclick="loadContent('story', <?php echo $_GET["id"]; ?>); loadSendButton();">Story</button>
        </div>
        <div class="col">
            <button class="btn btn-block" onclick="loadContent('pools', <?php echo $_GET["id"]; ?>)">Pools</button>
        </div>
        <div class="col">
            <button class="btn btn-block" onclick="loadContent('proposals', <?php echo $_GET["id"]; ?>)">Proposals</button>
        </div>
        <div class="col">
            <button class="btn btn-block" onclick="loadContent('comments', <?php echo $_GET["id"]; ?>)">Comments</button>
        </div>
    </div>
    <div id="subpageContent" class="row" style="margin: 5%;">
        
    </div>
</div>

<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/FableFlow/src/client/Footer.php';
?>