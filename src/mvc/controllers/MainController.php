<?php

namespace mvc\controllers;

use \mvc\Controller;
use \mvc\models\Post;


class MainController extends Controller {
    public function index() {
        /*$posts = [
            new Post('John Doe', 'john@example.com'),
            new Post('Jane Doe', 'jane@example.com')
        ];*/
        $this->render('main/index', []);
    }
}