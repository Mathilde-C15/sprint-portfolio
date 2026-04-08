<?php


namespace Controllers;

use Models\Project;
use Repositories\PictureRepository;
use Repositories\ProjectRepository;
use Services\Auth;
use Services\Flash;

// Contrôleur pour les projets
class ProjectController {
    public function show(): void {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $project = (new ProjectRepository())->getProjectById($id);

        if ($project === null) {
            Flash::add('error', 'Projet introuvable.');
            header('Location: index.php');
            exit;
        }

        $title = 'Détail du projet';
        $view = __DIR__ . '/../views/project/show.phtml';
        require __DIR__ . '/../views/layout.phtml';
    }

    public function save(): void {
        Auth::requireLogin();

        $skillIds = array_map('intval', $_POST['skill_ids'] ?? []);
        $primarySkillId = isset($_POST['primary_skill_id']) && $_POST['primary_skill_id'] !== ''
            ? (int) $_POST['primary_skill_id']
            : ($skillIds[0] ?? null);

        if ($primarySkillId !== null && !in_array($primarySkillId, $skillIds, true)) {
            $skillIds[] = $primarySkillId;
        }

        $project = new Project(
            trim($_POST['name'] ?? ''),
            trim($_POST['description'] ?? ''),
            $primarySkillId,
            isset($_POST['category_id']) && $_POST['category_id'] !== '' ? (int) $_POST['category_id'] : null,
            isset($_POST['id']) && $_POST['id'] !== '' ? (int) $_POST['id'] : null
        );

        $errors = $project->validate();

        if (!empty($errors)) {
            foreach ($errors as $error) {
                Flash::add('error', $error);
            }
            $redirectId = $project->getId() !== null ? '&id=' . $project->getId() : '';
            header('Location: index.php?page=dashboard_edit&type=project' . $redirectId);
            exit;
        }

        $repository = new ProjectRepository();
        $success = $repository->save($project, $skillIds);

        if (!$success) {
            Flash::add('error', 'Une erreur est survenue lors de la sauvegarde du projet.');
            header('Location: index.php?page=dashboard_edit&type=project');
            exit;
        }

        $imagePaths = $_POST['image_paths'] ?? [];
        $imageAlts = $_POST['image_alts'] ?? [];
        $pictures = [];

        foreach ($imagePaths as $index => $imagePath) {
            $path = trim((string) $imagePath);
            $alt = trim((string) ($imageAlts[$index] ?? ''));

            if ($path === '') {
                continue;
            }

            $pictures[] = [
                'path' => $path,
                'alt' => $alt !== '' ? $alt : (string) $project->getName(),
            ];
        }

        (new PictureRepository())->saveProjectPictures((int) $project->getId(), $pictures);

        Flash::add('success', 'Le projet a bien été enregistré.');
        header('Location: index.php?page=dashboard_list&type=project');
        exit;
    }

    public function delete(): void {
        Auth::requireLogin();

        if (!isset($_GET['id'])) {
            Flash::add('error', 'Projet introuvable.');
            header('Location: index.php?page=dashboard_list&type=project');
            exit;
        }

        (new ProjectRepository())->delete((int) $_GET['id']);
        Flash::add('success', 'Le projet a bien été supprimé.');
        header('Location: index.php?page=dashboard_list&type=project');
        exit;
    }
}
