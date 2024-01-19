<?php

namespace mvc;

class Controller {
    protected function render($view, $data = []) {
        extract($data);
        include "views/header.php";
        echo "<main>";
            include "views/$view.php";
        echo "</main>";
        include "views/footer.php";
    }
}