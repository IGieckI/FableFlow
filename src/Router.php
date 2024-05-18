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
        if ($user[0]['password']==$password) {
            $_SESSION['username'] = $username;
            $_SESSION['LOGGED'] = 'true';
            return True;
        } 
        
        return False;
    
    }

    /* Only for GET requests */
    function redirect($page_requested) {
        $params = array();

        if (isset($_COOKIE['request'])) {
            unset($_COOKIE['request']);
        }

        foreach ($_GET as $key=>$val) {
            if($key != 'url' && $key != 'method') {
                $params[] = $key.'='.$val;
            } 
        }   

        setcookie('request', 'ok', time() + 10, '/'); 
        header('Location: '. $page_requested . "?" . implode("&", $params));
        exit;
    }

    /* Calls a script which should handle a POST request */
    function intermediate_post($phpfile) {
        require_once($phpfile);
        exit;
    }

    /* Here add variables that are needed in all pages*/
    $_SESSION['cssFiles'] = array("client/css/Footer.css", "client/css/Header.css");
    $_SESSION['jsFiles'] = array('client/js/Footer.js');
    
    $request = $_GET['url'];
    switch ($request) {
        case '/FableFlow/src/Index.php':
            redirect($request);
            break;
        case '/FableFlow/src/Access.php':
            redirect($request);
            break;
        case '/FableFlow/src/Profile.php':
            if (isset($_SESSION['LOGGED']))
                redirect($request);   
            break;
        case '/FableFlow/src/server/AuthLogin.php':    
            if (auth($_POST['username'], $_POST['password'])) {
                redirect("/FableFlow/src/Profile.php");
            }  else {
                redirect('/FableFlow/src/Access.php');   
            }   
            break;
        case '/FableFlow/src/server/api/GetLoggedUser.php':
            redirect($request);
            break;
        case '/FableFlow/src/server/api/GetNotifications.php':
            redirect($request);
            break;
        case '/FableFlow/src/server/api/GetPosts.php':
            redirect($request);
            break;
        default:
            include '404.php';
            break;
    }

?>
