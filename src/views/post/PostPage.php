<?php
    $_SESSION['cssFiles'] = [];
    $_SESSION['jsFiles'] = [];

    include $_SERVER['DOCUMENT_ROOT'] . '/FableFlow/src/views/Header.php';
?>

<div class="container">
    <div class="row">
        <div class="col-1">
            <i class="bi bi-chevron-left align-middle" onclick="history.back()"></i>
        </div>
        <div class="col">
            <h5 class="font-weight-bold">Chapter 1: The Adventure Begins</h5>
        </div>
        <div class="col-2">
            <span><i class="bi bi-fire"></i>100</span>
        </div>
        <div class="col-2">
            <img src="${post.user_icon}" alt="User Icon" width="30" height="30">
        </div>
    </div>
    <div class="row">
        <div class="col" >
            <button class="btn btn-block">Story</button>
        </div>
        <div class="col" >
            <button class="btn btn-block">Pool</button>
        </div>
        <div class="col" >
            <button class="btn btn-block">Proposals</button>
        </div>
        <div class="col" >
            <button class="btn btn-block">Comments</button>
        </div>
    </div>
    <div class="row" style="margin: 5%;">
        <p class="chapter-text">Once upon a time in a land far, far away...</p>
    </div> 
</div>

<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/FableFlow/src/views/Footer.php';
?>