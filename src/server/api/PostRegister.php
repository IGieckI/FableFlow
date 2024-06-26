<?php
    require __DIR__ . '/../utilities/DbHelper.php';
    require __DIR__ . '/../models/Post.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

try {
    $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);
    $username = $_POST['username'];
    $password = $_POST['password'];
    //$email = $_POST['email'];
    
    if(!empty($username) && !empty($password)){
        $user = $db->findBy(['username' => $username], ['username' => 's'], null, null, Tables::Users);
        if(count($user) != 0){
            header("Location: FableFlow/src/client/Register.php");
            exit();
        } else {
            $hashed_pass = password_hash($password, PASSWORD_BCRYPT);
            $insert = $db->insertUser($username, $hashed_pass);
            if($insert){
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['LOGGED']=true;
                header("Location: /FableFlow/src/Index.php");
                exit();
            }
        }
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

?>