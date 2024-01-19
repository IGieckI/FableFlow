<?php
    spl_autoload_register(function ($class_name) {
        $file = __DIR__ . '\\' . strtolower($class_name) . '.php';
        //$file = str_replace('\\', '/', $file);
        //print($file . '<br>');
        if (file_exists($file)) {
            require $file;
        }
    });
?>