<?php
    namespace mvc;
    
    use mvc\Router;
    use mvc\controllers\MainController;

    $router->addRoute('/FableFlow/src/mvc/', MainController::class, 'index');
?>