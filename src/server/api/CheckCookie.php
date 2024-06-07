
<?php
require '../utilities/DbHelper.php';
require '../models/Post.php';


try{
    $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

    if (isset($_COOKIE['remember_token'])) {
        $token = $_COOKIE['remember_token'];

        $sql = "SELECT * FROM users WHERE token_cookie = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $_SESSION['username']= $row["username"];
            $result=true;
            header('Content-Type: application/json');
            echo json_encode($result);
            exit();
        }
    }
    else{
        $result = false;
        header('Content-Type: application/json');
        echo json_encode($result);
        exit();
}
$conn->close();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>