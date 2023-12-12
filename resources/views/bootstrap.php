<?php

include_once '../db/dbhelper.php';
include_once '../db/config.php';
$dbhelper = new DbHelper(SERVER, USER, PASS, DB, PORT);
include 'home.php';
?>