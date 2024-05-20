<?php

/* This script should be called via a POST request, since its main purpose 
is that of loading an image on the server. */

$error_found = FALSE;

// Directory where the image is going to be stored
$imagedir = '/opt/lampp/htdocs/FableFlow/resources/icons/';

// Generate random name for the image
$id = uniqid('', FALSE);

$extension = array_pop(explode('.', $_FILES['filename']['name']));
$filename = $imagedir . $id . "." . $extension;
$imageExtension = pathinfo($filename, PATHINFO_EXTENSION);

//Valid image extensions
$valid = array('jpg', 'jpeg', 'png');
error_log($_FILES['filename']['tmp_name']);

/* Check file extension */
if(!in_array(strtolower($imageExtension),$valid) 
            || !move_uploaded_file($_FILES['filename']['tmp_name'], $filename)) {
    $error_found = TRUE;
}

if ($error_found) {
    echo json_encode(['result'=>'notok']);
} else {
    echo json_encode(['result'=>'ok', 'id'=>$id]);
}

error_log((string)$_FILES);

?>