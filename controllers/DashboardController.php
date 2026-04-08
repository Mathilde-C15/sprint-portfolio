<?php

namespace Controllers;

use Models\User;
use Repositories\CategoryRepository;
use Repositories\ProjectRepository;
use Repositories\SkillRepository;
use Repositories\UserRepository;
use Services\Auth;
use Services\Flash;

// Contrôleur pour le tableau de bord
class DashboardController {
    public function index(): void {
        Auth::requireLogin();

        $userRepository = new UserRepository();
        $projectRepository = new ProjectRepository();
        $categoryRepository = new CategoryRepository();
        $skillRepository = new SkillRepository();

        $user = $userRepository->getDefaultUser();
        $projects = $projectRepository->getAllProjects();
        $categories = $categoryRepository->getAllCategories();
        $skills = $skillRepository->getAllSkills();

        $title = 'Dashboard';
        $view = __DIR__ . '/../views/dashboard/dashboard.phtml';
        require __DIR__ . '/../views/layout.phtml';
    }

    public function listing(): void {
        Auth::requireLogin();

        $type = $_GET['type'] ?? 'project';
        $items = [];

        switch ($type) {
            case 'category':
                $items = (new CategoryRepository())->getAllCategories();
                break;
            case 'skill':
                $items = (new SkillRepository())->getAllSkills();
                break;
            default:
                $type = 'project';
                $items = (new ProjectRepository())->getAllProjects();
                break;
        }

        $title = 'Dashboard - Liste';
        $view = __DIR__ . '/../views/dashboard/list.phtml';
        require __DIR__ . '/../views/layout.phtml';
    }

    public function edit(): void {
        Auth::requireLogin();

        $type = $_GET['type'] ?? 'project';
        $id = isset($_GET['id']) ? (int) $_GET['id'] : null;
        $item = null;
        $categories = (new CategoryRepository())->getAllCategories();
        $skills = (new SkillRepository())->getAllSkills();

        switch ($type) {
            case 'user':
                $item = (new UserRepository())->getDefaultUser();
                break;
            case 'category':
                $item = $id ? (new CategoryRepository())->getCategoryById($id) : null;
                break;
            case 'skill':
                $item = $id ? (new SkillRepository())->getSkillById($id) : null;
                break;
            default:
                $type = 'project';
                $item = $id ? (new ProjectRepository())->getProjectById($id) : null;
                break;
        }

        $title = 'Dashboard - Édition';
        $view = __DIR__ . '/../views/dashboard/edit.phtml';
        require __DIR__ . '/../views/layout.phtml';
    }

    public function saveUser(): void {
        Auth::requireLogin();

        $userRepository = new UserRepository();
        $currentUser = $userRepository->getDefaultUser();

        if ($currentUser === null) {
            Flash::add('error', 'Utilisateur introuvable.');
            header('Location: index.php?page=dashboard');
            exit;
        }

        $password = trim($_POST['password'] ?? '');
        $user = new User(
            trim($_POST['email'] ?? ''),
            trim($_POST['phone'] ?? ''),
            trim($_POST['name'] ?? ''),
            trim($_POST['familyName'] ?? ''),
            $password !== '' ? password_hash($password, PASSWORD_DEFAULT) : $currentUser->getPassword(),
            trim($_POST['description'] ?? ''),
            trim($_POST['birthdate'] ?? ''),
            trim($_POST['github'] ?? ''),
            trim($_POST['linkedin'] ?? ''),
            trim($_POST['cv'] ?? ''),
            $currentUser->getPictureId(),
            $currentUser->getId()
        );

        $errors = $user->validate($password !== '');

        if (!empty($errors)) {
            foreach ($errors as $error) {
                Flash::add('error', $error);
            }
            header('Location: index.php?page=dashboard_edit&type=user');
            exit;
        }

        $userRepository->save($user, $password !== '');
        Flash::add('success', 'Les informations du profil ont bien été mises à jour.');
        header('Location: index.php?page=dashboard');
        exit;
    }
}
