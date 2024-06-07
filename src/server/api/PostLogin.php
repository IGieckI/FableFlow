<?php
require __DIR__ . '/../utilities/DbHelper.php';
require __DIR__ . '/../models/Post.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

    $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

$username = $_POST['username'];
$password = $_POST['password'];
//$remember = isset($_POST['rememberMe']);

try{
    if(!empty($username) && !empty($password)){
        $users = $db->findBy(['username' => $username], ['username' => 's'] , null, null, Tables::Users);
        if(count($users) != 0){
            $user = $users[0];
            $hashed_pass = $user['password'];
            if (password_verify($password, $hashed_pass)){
                /*if ($remember) {
                    $token = bin2hex(random_bytes(16));
                    $sql = "UPDATE users SET cookie_token = ? WHERE username = ?";
                    $stmt = $db->prepare($sql);
                    $stmt->bind_param("ss", $token, $user['username']); // Assicurati di passare il nome utente corretto
                    $stmt->execute();

                    setcookie("remember_token", $token, time() + (86400 * 30), "/", "", true, true); // 30 giorni, Secure e HttpOnly
                }*/
                $_SESSION['username'] = $username;
                $_SESSION['LOGGED']=true;
                header("Location: /FableFlow/src/client/profile/Main.php");
            }
            else{
                header("Location: /FableFlow/src/client/Login.php");
            }
            exit();
        }
        else{
            header("Location: /FableFlow/src/client/Login.php");
            exit();
        }
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>