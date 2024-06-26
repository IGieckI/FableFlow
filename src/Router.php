<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function redirect($page_requested) {
    if (isset($_COOKIE['request'])) {
        unset($_COOKIE['request']);
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $parameters = array_slice($_GET, 2);
        $page_requested .= '?';
        $paramArray = [];
        foreach ($parameters as $key => $value) {
            $paramArray[] = $key . '=' . $value;
        }
        $page_requested .= implode('&', $paramArray);

        header('Location: ' . $page_requested);
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once($_SERVER['DOCUMENT_ROOT'] . $page_requested);
    }
    setcookie('request', 'ok', time() + 10, '/');
    exit;    
}

/* Here add variables that are needed in all pages */
$_SESSION['cssFiles'] = array("/FableFlow/src/client/css/Footer.css", "/FableFlow/src/client/css/Header.css");
$_SESSION['jsFiles'] = array("/FableFlow/src/client/js/Footer.js", "/FableFlow/src/client/js/Header.js", '/FableFlow/src/client/js/Utilities.js');

$request = $_GET['url'];
$ip = $_SESSION['REMOTE_ADDR'] ?? $_SERVER['REMOTE_ADDR'];

$routes = [
    'GET' => [
        '/FableFlow/src/Index.php' => 'redirect',
        '/FableFlow/src/client/Login.php' => 'redirect',
        '/FableFlow/src/client/Register.php' => 'redirect',
        '/FableFlow/src/client/creation/CreateStory.php' => 'redirect',
        '/FableFlow/src/client/profile/Profile.php' => function($_) {
            if (isset($_SESSION['LOGGED'])) redirect('/FableFlow/src/client/profile/Profile.php');
            redirect('/FableFlow/src/client/Login.php');
        },
        '/FableFlow/src/client/post/ChapterPage.php' => 'redirect',
        '/FableFlow/src/client/post/SubChapterPage.php' => 'redirect',
        '/FableFlow/src/client/post/content/Story.php' => 'redirect',
        '/FableFlow/src/client/post/content/Comments.php' => 'redirect',
        '/FableFlow/src/client/post/content/proposal/CreateProposal.html' => 'redirect',
        '/FableFlow/src/server/api/GetNotifications.php' => 'redirect',
        '/FableFlow/src/server/api/GetChapters.php' => 'redirect',
        '/FableFlow/src/server/api/GetStory.php' => 'redirect',
        '/FableFlow/src/server/api/GetViewedUser.php' => 'redirect',
        '/FableFlow/src/server/api/GetChapterComments.php' => 'redirect',
        '/FableFlow/src/server/api/GetNumberOfFollowed.php' => 'redirect',
        '/FableFlow/src/server/api/GetNumberOfFollowers.php' => 'redirect',
        '/FableFlow/src/server/api/GetUserStories.php' => 'redirect',
        '/FableFlow/src/server/api/GetUserTags.php' => 'redirect',
        '/FableFlow/src/server/api/IsUserLogged.php' => 'redirect',
        '/FableFlow/src/server/api/IsItAlreadyAFollower.php' => 'redirect',
        '/FableFlow/src/server/api/GetLoggedUsername.php' => 'redirect',
        '/FableFlow/src/server/api/GetProposals.php' => 'redirect',
        '/FableFlow/src/client/post/content/proposal/Proposal.php' => 'redirect',
        '/FableFlow/src/server/api/GetUsers.php' => 'redirect',
        '/FableFlow/src/client/post/content/pool/Pool.php' => 'redirect',
        '/FableFlow/src/client/post/content/pool/PoolUserView.php' => 'redirect',
        '/FableFlow/src/server/api/GetChapter.php' => 'redirect',
        '/FableFlow/src/server/api/GetProposalComments.php' => 'redirect',
        '/FableFlow/src/server/api/GetChaptersOfUser.php' => 'redirect',
        '/FableFlow/src/server/api/GetPools.php' => 'redirect',
        '/FableFlow/src/server/api/GetAuthor.php' => 'redirect',
        '/FableFlow/src/client/creation/CreateChapter.php' => 'redirect',
        '/FableFlow/src/server/api/GetOwnerStories.php' => 'redirect',
        '/FableFlow/src/server/api/GetPoolInformations.php' => 'redirect',
    ],
    'POST' => [
        '/FableFlow/src/server/api/UpdateBio.php' => 'redirect',
        '/FableFlow/src/server/api/UploadChapterImage.php' => 'redirect',
        '/FableFlow/src/server/api/UpdateUserImage.php' => 'redirect',
        '/FableFlow/src/server/api/UploadImage.php' => 'redirect',
        '/FableFlow/src/server/api/UpdateFollowship.php' => 'redirect',
        '/FableFlow/src/server/api/AuthLogin.php' => 'redirect',
        '/FableFlow/src/server/api/DeleteNotification.php' => 'redirect',
        '/FableFlow/src/server/api/PostChapterComment.php' => 'redirect',
        '/FableFlow/src/server/api/UpdateCommentsLikesDislikes.php' => 'redirect',
        '/FableFlow/src/server/api/PostLogin.php' => 'redirect',
        '/FableFlow/src/server/api/PostRegister.php' => 'redirect',
        '/FableFlow/src/server/api/PostProposal.php' => 'redirect',
        '/FableFlow/src/server/api/UpdateChapterLike.php' => 'redirect',
        '/FableFlow/src/server/api/UpdateProposalLike.php' => 'redirect',
        '/FableFlow/src/server/api/PostProposalComment.php' => 'redirect',
        '/FableFlow/src/server/api/PostChapter.php' => 'redirect',
        '/FableFlow/src/server/api/PostStory.php' => 'redirect',
        '/FableFlow/src/server/api/PostUserPoolChoice.php' => 'redirect',
        '/FableFlow/src/server/api/RemoveUserPoolChoice.php' => 'redirect',
        '/FableFlow/src/server/api/AddPool.php' => 'redirect',
        '/FableFlow/src/server/api/Logout.php' => 'redirect',
    ]
];

$request_method = $_SERVER['REQUEST_METHOD'];


if (!isset($_SESSION["username"]) && $request != '/FableFlow/src/client/Login.php' && $request != '/FableFlow/src/client/Register.php' && $request != '/FableFlow/src/server/api/PostLogin.php' && $request != '/FableFlow/src/server/api/PostRegister.php' && $request != '/FableFlow/src/server/api/AuthLogin.php' && $request != '/FableFlow/src/server/api/Logout.php' && $request != '/FableFlow/src/400.php' && $request != '/FableFlow/src/404.php' && $request != '/FableFlow/src/500.php' && $request != '/FableFlow/src/client/creation/CreateStory.php' && $request != '/FableFlow/src/client/creation/CreateChapter.php' && $request != '/FableFlow/src/client/creation/CreatePool.php' && $request != '/FableFlow/src/client/creation/CreateProposal.php' && $request != '/FableFlow/src/client/creation/CreateSubChapter.php' && $request != '/FableFlow/src/server/api/PostRegister.php') {
    redirect('/FableFlow/src/client/Login.php');
} elseif (isset($routes[$request_method][$request])) {
    $action = $routes[$request_method][$request];
    if (is_callable($action)) {
        /*if(isset($_POST['risultato'])) {
            $risultato = $_POST['risultato']
            if($risultato == true){
                redirect('/FableFlow/Index.php')
            }
            else{
                redirect('/FableFlow/src/client/Login.html')
            }*/
            $action($request);
    } else {
        redirect('/FableFlow/src/404.php');
    }
} else {
    redirect('/FableFlow/src/404.php');
}
?>