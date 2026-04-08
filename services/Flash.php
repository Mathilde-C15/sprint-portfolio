<?php


namespace Services;

// Pour affichier les messages de confirmation ou d'erreur
class Flash{

    public static function add(string $type, string $message): void {
        $_SESSION['flashes'][] = ['type' => $type,'message' => $message,];
    }

    public static function getAll(): array {
        $flashes = $_SESSION['flashes'] ?? [];
        unset($_SESSION['flashes']);

        return $flashes;
    }
}
