<?php

namespace Services;

// Authentification
class Auth {
    public static function login(int $userId): void {
        $_SESSION['user_id'] = $userId;
    }

    public static function logout(): void {
        unset($_SESSION['user_id']);
    }

    public static function isLogged(): bool {
        return isset($_SESSION['user_id']);
    }

    public static function requireLogin(): void {
        if (!self::isLogged()) {
            Flash::add('error', 'Vous devez être connecté pour accéder au dashboard.');
            header('Location: index.php?page=login');
            exit;
        }
    }
}
