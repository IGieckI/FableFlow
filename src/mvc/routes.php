<?php
    namespace mvc;
    //include 'router.php';
    //include 'controllers\main.php';
    
    use mvc\Router;
    use mvc\controllers\MainController;

    $router->addRoute('/FableFlow/src/mvc/', MainController::class, 'index');
?>