<?php
    require_once __DIR__ . '/../utilities/DbHelper.php';

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
            $db = null;
        if ($user[0]['password'] == $password) {
            $_SESSION['username'] = $username;
            $_SESSION['LOGGED'] = 'true';

            return true;
        }
        return false;
    }

    $on_success = '/FableFlow/src/client/profile/Profile.php';
    $on_failure = '/FableFlow/src/Access.php';
    $result = auth($_POST['username'], $_POST['password']) ? $on_success : $on_failure;
    header('Location: ' . $result);
    error_log("USERNAME ->" . $_SESSION['username']);

    exit;
?>