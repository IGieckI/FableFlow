<?php
require __DIR__ . '/../utilities/DbHelper.php';
require __DIR__ . '/../models/Post.php';

$db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

$user = $_POST['username'];
$pass = $_POST['password'];
$remember = isset($_POST['rememberMe'])

try{
    if((isset($user) && ($user != "")) && (isset($pass) && ($pass != ""))){
        $authenticated = false;
        $user = $db->findBy(['username' => $user], null, null, Tables::Users);
        $user = $user[0];
        if(count($user) != 0){
            $hashed_pass = $user['password'];
            if (password_verify($password, $hashed_pass)){
                if($remember){
                    $token = bin2hex(random_bytes(16));
                    $sql = "UPDATE users SET cookie_token = ? WHERE username = ?";
                    $stmt = $db->prepare($sql);
                    $stmt->bind_param("s", $token, $user);
                    $stmt->execute();

                    setcookie("remember_token", $token, time() + (86400 * 30), "/", "", true, true); // 30 giorni, Secure e HttpOnly
                }
                header("Location: Main.js");
            }
            else{
                header("Location: Access.html");
            }
            exit();
        }
        else{
            header("Location: Access.html");
            exit();
        }
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>