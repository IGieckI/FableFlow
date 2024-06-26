<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    array_push($_SESSION['cssFiles'],
                                    '/FableFlow/src/client/css/PostPage.css',
                                    '/FableFlow/src/client/css/Comments.css',
                                    '/FableFlow/src/client/css/Proposals.css',
                                    '/FableFlow/src/client/css/Proposal.css',
                                    '/FableFlow/src/client/css/PoolOverview.css',
                                    '/FableFlow/src/client/css/PoolCreation.css',
                                    '/FableFlow/src/client/css/PoolUserView.css');
    array_push($_SESSION['jsFiles'], 
                                    '/FableFlow/src/client/js/Utilities.js',
                                    '/FableFlow/src/client/js/ChapterPage.js',
                                    '/FableFlow/src/client/js/Comments.js',
                                    '/FableFlow/src/client/js/Proposals.js',
                                    '/FableFlow/src/client/js/Proposal.js',
                                    '/FableFlow/src/client/js/Story.js',
                                    '/FableFlow/src/client/js/PoolOverview.js',
                                    '/FableFlow/src/client/js/PoolCreation.js',
                                    '/FableFlow/src/client/js/PoolUserView.js',
                                    'https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js');

    require $_SERVER['DOCUMENT_ROOT'] . '/FableFlow/src/client/Header.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/FableFlow/src/server/utilities/DbHelper.php';
?>

<div class="container">
    <div class="row">
        <div class="col-1">
            <i id="back-history-button" class="bi bi-chevron-left align-middle"></i>
        </div>
        <div class="col">
            <h5 id="chapter-title" class="font-weight-bold"></h5>
        </div>
        <div style="display: flex" class="col-2">
            <span><i id="like-icon" class="bi bi-fire"></i></span>
            <span id="like-span"></span>
        </div>
        <div id="user_icon" username="" class="col-2">
            <span id="username-span"></span>
            <img id="user_icon_img" src="" alt="User Icon" width="30" height="30">
        </div>
    </div>
    <div class="row banner">
        <div class="col category">
            <button id="load-story-button" class="btn btn-block"">Story</button>
        </div>
        <div class="col category">
            <button id="load-pools-button" class="btn btn-block">Pools</button>
        </div>
        <div class="col category">
            <button id="load-proposals-button" class="btn btn-block">Proposals</button>
        </div>
        <div class="col category">
            <button id="load-comments-button" class="btn btn-block">Comments</button>
        </div>
    </div>
    <div id="subpageContent" class="row" style="margin: 5%;">
        
    </div>
</div>

<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/FableFlow/src/client/Footer.php';
?>