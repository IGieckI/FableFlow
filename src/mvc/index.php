<?php
    require '../autoloader.php';

    use mvc\Router;

    $uri = $_SERVER['REQUEST_URI'];
    
    $router = new Router();

    include './routes.php';

    $router->dispatch($uri);

?>