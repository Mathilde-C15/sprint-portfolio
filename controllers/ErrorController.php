<?php

namespace Controllers;

// Contrôleur pour les erreurs
class ErrorController {
    public function index(): void{
        $title = 'Erreur 404';
        $view = __DIR__ .'/../views/error/error.phtml';
        require __DIR__ . '/../views/layout.phtml';
    }
}