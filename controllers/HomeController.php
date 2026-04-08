<?php

namespace Controllers;

use Repositories\CategoryRepository;
use Repositories\ProjectRepository;
use Repositories\SkillRepository;
use Repositories\UserRepository;

// Contrôleur pour la page d'accueil
class HomeController {
    public function index(): void {
        $userRepository = new UserRepository();
        $projectRepository = new ProjectRepository();
        $categoryRepository = new CategoryRepository();
        $skillRepository = new SkillRepository();

        $user = $userRepository->getDefaultUser();
        $projects = $projectRepository->getAllProjects();
        $categories = $categoryRepository->getAllCategories();
        $skills = $skillRepository->getAllSkills();

        $title = 'Accueil';
        $view = __DIR__ . '/../views/home/home.phtml';
        require __DIR__ . '/../views/layout.phtml';
    }
}
