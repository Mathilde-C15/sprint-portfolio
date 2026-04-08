<?php

namespace Controllers;

use Repositories\UserRepository;
use Services\Auth;
use Services\Flash;

// Contrôleur pour la connexion
class LoginController {
    public function index(): void {
        if (!empty($_POST) && isset($_POST['email'], $_POST['password'])) {
            $this->login();
            return;
        }

        $title = 'Connexion';
        $view = __DIR__ . '/../views/auth/login.phtml';
        require __DIR__ . '/../views/layout.phtml';
    }

    private function login(): void {
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        $userRepository = new UserRepository();
        $user = $userRepository->findByEmail($email);

        if ($user === null || !password_verify($password, (string) $user->getPassword())) {
            Flash::add('error', 'Identifiants invalides.');
            header('Location: index.php?page=login');
            exit;
        }

        Auth::login((int) $user->getId());
        Flash::add('success', 'Connexion réussie.');
        header('Location: index.php?page=dashboard');
        exit;
    }

    public function logout(): void {
        Auth::logout();
        Flash::add('success', 'Vous êtes maintenant déconnecté.');
        header('Location: index.php');
        exit;
    }
}
