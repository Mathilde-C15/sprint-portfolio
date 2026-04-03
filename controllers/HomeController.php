<?php

namespace Controllers;

class HomeController {

    public function index() {
        $title = "Accueil";
        $view = __DIR__ . '/../views/home/home.phtml';

        include __DIR__ . '/../views/layout.phtml';
    }
}