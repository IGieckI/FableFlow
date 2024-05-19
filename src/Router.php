<?php
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
        if ($user[0]['password']==$password) {
            $_SESSION['username'] = $username;
            $_SESSION['LOGGED'] = 'true';
            return True;
        } 
        
        return False;
    
    }

    function redirect($ip_addr, $page_requested) {
        if (isset($_COOKIE['request'])) {
            unset($_COOKIE['request']);
        }
        setcookie('request', 'ok', time() + 10, '/'); 
        header('Location: '. $ip_addr . $page_requested);
        exit;
    }

    /* Calls a script which should handle a post request */
    function intermediate_post($phpfile) {
        require_once($phpfile);
        exit;
    }

    /* Here add variables that are needed in all pages*/
    $_SESSION['cssFiles'] = array("client/css/Footer.css", "client/css/Header.css");
    $_SESSION['jsFiles'] = array('client/js/Footer.js');
    
    $request = $_GET['url'];
    $ip = $_SESSION['REMOTE_ADDR'];
    switch ($request) {
        case '/FableFlow/src/Index.php':
            redirect($ip, $request);
            break;
        case '/FableFlow/src/Access.php':
            redirect($ip, $request);
            break;
        case '/FableFlow/src/Profile.php':
            if (isset($_SESSION['LOGGED']))
                redirect($ip, $request);   
            break;
        case '/FableFlow/src/server/AuthLogin.php':    
            if (auth($_POST['username'], $_POST['password'])) {
                redirect($ip, "/FableFlow/src/Profile.php");
            }  else {
                redirect($ip, '/FableFlow/src/Access.php');   
            }   
            break;
        case '/FableFlow/src/server/api/GetLoggedUser.php':
            redirect($ip, $request);
            break;
        case '/FableFlow/src/server/api/GetNotifications.php':
            redirect($ip, $request);
            break;
        case '/FableFlow/src/server/api/GetPosts.php':
            redirect($ip, $request);
            break;
        case '/FableFlow/src/server/api/GetNumberOfFollowers.php':
            intermediate_post("./server/api/GetNumberOfFollowers.php");
            break;
        case '/FableFlow/src/server/api/GetNumberOfFollowed.php':
            intermediate_post("./server/api/GetNumberOfFollowed.php");
            break;
        case '/FableFlow/src/server/api/GetUserTags.php':
            intermediate_post("./server/api/GetUserTags.php");
            break;
        case '/FableFlow/src/server/api/GetUserStories.php':
            intermediate_post("./server/api/GetUserStories.php");
            break;
        default:
            include '404.php';
            break;
    }

?>