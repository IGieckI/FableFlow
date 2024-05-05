<?php
require '../utilities/DbHelper.php';
require '../models/Post.php';

$db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

$username = $_POST['username'];
$password = $_POST['password'];

try {
    if((isset($username) && ($username != "")) && (isset($password) && ($password != ""))){
        $user = $db->findBy(['username' => $user], null, null, Tables::Users);
        $user = $user[0];
        if(count($user) != 0){
            header("Location: Access.html");
            exit();
        }
        else{
            $hashed_pass = password_hash($password, PASSWORD_BCRYPT);
            $n = $db->insertUser($username, $password);
            $_SESSION['username']=$_POST['username'];
            header("Location: main.js");
            exit();
        }
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

?>