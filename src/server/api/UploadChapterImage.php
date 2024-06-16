<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    function uploadChapterImage ($image){
        $error_found = FALSE;

        // Directory where the image is going to be stored
        $imagedir = __DIR__ . '/../../../resources/images/';
    
        // Generate random name for the image
        $id = uniqid('', FALSE);
    
        $extension = array_pop(explode('.', $_FILES['chapter-image']['name']));
        $filename = $imagedir . $id . "." . $extension;
        $imageExtension = pathinfo($filename, PATHINFO_EXTENSION);
    
        //Valid image extensions
        $valid = array('jpg', 'jpeg', 'png');
    
        /* Check file extension */
        if(!in_array(strtolower($imageExtension),$valid) 
                    || !move_uploaded_file($_FILES['chapter-image']['tmp_name'], $filename)) {
            $error_found = TRUE;
        }
        
        if ($error_found==false) {
            return (['result'=>'ok', 'id'=>"$id.$extension"]);
        }
        
    }
?>