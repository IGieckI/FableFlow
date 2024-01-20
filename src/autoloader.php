<?php
    spl_autoload_register(function ($class_name) {
        $file = __DIR__ . '\\' . $class_name . '.php';
        //$file = str_replace('\\', '/', $file);
        //print_r($file . '<br>');
        //var_dump($file);
        if (file_exists($file)) {
            require $file;
        }
    });
?>