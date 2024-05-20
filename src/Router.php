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
        error_log("Document root: " . $_SERVER['DOCUMENT_ROOT'] . "page_request" . $page_requested);
        require_once($_SERVER['DOCUMENT_ROOT'] . $page_requested);
    }
    setcookie('request', 'ok', time() + 10, '/');
    exit;    
}

/* Here add variables that are needed in all pages */
$_SESSION['cssFiles'] = array("/FableFlow/src/client/css/Footer.css", "/FableFlow/src/client/css/Header.css");
$_SESSION['jsFiles'] = array("/FableFlow/src/client/js/Footer.js", "/FableFlow/src/client/js/Header.js");

$request = $_GET['url'];
$ip = $_SESSION['REMOTE_ADDR'] ?? $_SERVER['REMOTE_ADDR'];

error_log("Request: " . $request . " from " . $ip);

$routes = [
    'GET' => [
        '/FableFlow/src/Index.php' => 'redirect',
        '/FableFlow/src/Access.php' => 'redirect',
        '/FableFlow/src/Profile.php' => function($_) {
            if (isset($_SESSION['LOGGED'])) redirect('/FableFlow/src/Profile.php');
        },
        '/FableFlow/src/client/post/PostPage.php' => 'redirect',
        '/FableFlow/src/client/post/SubPostPage.php' => 'redirect',
        '/FableFlow/src/client/post/content/Story.php' => 'redirect',
        '/FableFlow/src/client/post/content/Comments.php' => 'redirect',
        '/FableFlow/src/server/api/GetNotifications.php' => 'redirect',
        '/FableFlow/src/server/api/GetPosts.php' => 'redirect',        
        '/FableFlow/src/server/api/GetStory.php' => 'redirect',
        '/FableFlow/src/server/api/GetLoggedUser.php' => 'redirect',
        '/FableFlow/src/server/api/GetComments.php' => 'redirect',
    ],
    'POST' => [
        '/FableFlow/src/server/api/AuthLogin.php' => 'redirect',
        '/FableFlow/src/server/api/DeleteNotification.php' => 'redirect',
        '/FableFlow/src/server/api/PostComment.php' => 'redirect',
        '/FableFlow/src/server/api/UpdateCommentsLikesDislikes.php' => 'redirect',
        '/FableFlow/src/server/api/PostLogin.php' => 'redirect',
        '/FableFlow/src/server/api/PostRegister.php' => 'redirect',
    ]
];

$request_method = $_SERVER['REQUEST_METHOD'];

if (isset($routes[$request_method][$request])) {
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
