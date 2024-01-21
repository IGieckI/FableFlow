<?php
    spl_autoload_register(function ($class_name) {
        $file = __DIR__ . '\\' . $class_name . '.php';
        //$file = str_replace('\\', '/', $file);
        //print_r($file . '<br>');
        file_put_contents('./log_'.date("j.n.Y").'.log', $file, FILE_APPEND . '\n');
        if (file_exists($file)) {
            require $file;
        }
    });
?>