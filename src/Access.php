<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$_SESSION['cssFiles'][] = ['client/css/Access.css'];
$_SESSION['jsFiles'][] = ['client/js/Access.js']

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Register</title>
    <?php
    include './client/Access.html'
    ?>
</head>
<body>
    <h1>Login</h1>
    <form action="/FableFlow/src/server/api/AuthLogin.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Accedi</button>
    </form>
    
    <h1>Registrazione</h1>
    <form action="PostRegister.php" method="post">
        <label for="username-register">Username:</label>
        <input type="text" id="username-register" name="username" required>
        <br>
        <label for="password-register">Password:</label>
        <input type="password" id="password-register" name="password" required>
        <br>
        <button type="submit">Registrati</button>
    </form>
</body>
</html>
