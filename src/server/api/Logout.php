<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['username'] = "";
$_SESSION['LOGGED'] = false;
?>