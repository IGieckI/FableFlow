<?php

namespace mvc\controllers;

use \mvc\Controller;
use \mvc\models\Post;


class MainController extends Controller {
    public function index() {
        $this->render('main/index', []);
    }
}