<?php

namespace Controllers;

use Models\Category;
use Repositories\CategoryRepository;
use Services\Auth;
use Services\Flash;

// Contrôleur pour les catégories
class CategoryController
{
    public function save(): void
    {
        Auth::requireLogin();

        $category = new Category(
            trim($_POST['name'] ?? ''),
            isset($_POST['id']) && $_POST['id'] !== '' ? (int) $_POST['id'] : null
        );

        $errors = $category->validate();

        if (!empty($errors)) {
            foreach ($errors as $error) {
                Flash::add('error', $error);
            }
            $redirectId = $category->getId() !== null ? '&id=' . $category->getId() : '';
            header('Location: index.php?page=dashboard_edit&type=category' . $redirectId);
            exit;
        }

        (new CategoryRepository())->save($category);
        Flash::add('success', 'La catégorie a bien été enregistrée.');
        header('Location: index.php?page=dashboard_list&type=category');
        exit;
    }

    public function delete(): void
    {
        Auth::requireLogin();

        if (!isset($_GET['id'])) {
            Flash::add('error', 'Catégorie introuvable.');
            header('Location: index.php?page=dashboard_list&type=category');
            exit;
        }

        (new CategoryRepository())->delete((int) $_GET['id']);
        Flash::add('success', 'La catégorie a bien été supprimée.');
        header('Location: index.php?page=dashboard_list&type=category');
        exit;
    }
}
