<?php
require './server/utilities/DbHelper.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/**
 * As side effect it sets the session variable LOGGED
 * which enables to enter pages for only logged users.
 *
 * Returns True iff the entered password corresponds to a user.
 * Otherwise it returns False.
 */
function auth($username, $password) {
    $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);
    $user = $db->getUser($username);
    $db->disconnect();
    if ($user[0]['password'] == $password) {
        $_SESSION['username'] = $username;
        $_SESSION['LOGGED'] = 'true';
        return true;
    }

    return false;
}

function redirect($page_requested) {
    if (isset($_COOKIE['request'])) {
        unset($_COOKIE['request']);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $parameters = array_slice($_GET, 2);
        $page_requested .= '?';
        foreach ($parameters as $key => $value) {
            $page_requested .= $key . '=' . $value . '&';
        }
    }

    setcookie('request', 'ok', time() + 10, '/');
    header('Location: ' . $page_requested);
    exit;
}

/* Calls a script which should handle a post request */
function intermediate_post($phpfile) {
    require_once($phpfile);
    exit;
}

/* Here add variables that are needed in all pages */
$_SESSION['cssFiles'] = array("/FableFlow/src/client/css/Footer.css", "/FableFlow/src/client/css/Header.css");
$_SESSION['jsFiles'] = array("/FableFlow/src/client/js/Footer.js", "/FableFlow/src/client/js/Header.js");

$request = $_GET['url'];
$ip = $_SESSION['REMOTE_ADDR'] ?? $_SERVER['REMOTE_ADDR'];

$routes = [
    'GET' => [
        '/FableFlow/src/Index.php' => 'redirect',
        '/FableFlow/src/Access.php' => 'redirect',
        '/FableFlow/src/Profile.php' => function() {
            if (isset($_SESSION['LOGGED'])) redirect('/FableFlow/src/Profile.php');
        },
        '/FableFlow/src/client/post/PostPage.php' => 'redirect',
        '/FableFlow/src/client/post/SubPostPage.php' => 'redirect',
        '/FableFlow/src/client/post/content/Story.php' => 'redirect',
        '/FableFlow/src/client/post/content/Comments.php' => 'redirect',
        '/FableFlow/src/server/api/GetLoggedUser.php' => 'redirect',
        '/FableFlow/src/server/api/GetNotifications.php' => 'redirect',
        '/FableFlow/src/server/api/GetPosts.php' => 'redirect',
    ],
    'POST' => [
        '/FableFlow/src/server/AuthLogin.php' => function() {
            if (auth($_POST['username'], $_POST['password'])) {
                redirect("/FableFlow/src/Profile.php");
            } else {
                redirect('/FableFlow/src/Access.php');
            }
        }
    ]
];

$request_method = $_SERVER['REQUEST_METHOD'];
if (isset($routes[$request_method][$request])) {
    $action = $routes[$request_method][$request];
    if (is_callable($action)) {
        $action($request);
    } else {
        $action($request);
    }
} else {
    include '404.php';
}
?>
