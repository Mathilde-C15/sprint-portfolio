<?php

declare(strict_types=1);

namespace Controllers;

use Models\Skill;
use Repositories\SkillRepository;
use Services\Auth;
use Services\Flash;

// Contrôleur pour les compétences
class SkillController {
    public function save(): void {
        Auth::requireLogin();

        $skill = new Skill(
            trim($_POST['name'] ?? ''),
            isset($_POST['level']) ? (int) $_POST['level'] : null,
            isset($_POST['id']) && $_POST['id'] !== '' ? (int) $_POST['id'] : null
        );

        $errors = $skill->validate();

        if (!empty($errors)) {
            foreach ($errors as $error) {
                Flash::add('error', $error);
            }
            $redirectId = $skill->getId() !== null ? '&id=' . $skill->getId() : '';
            header('Location: index.php?page=dashboard_edit&type=skill' . $redirectId);
            exit;
        }

        (new SkillRepository())->save($skill);
        Flash::add('success', 'La compétence a bien été enregistrée.');
        header('Location: index.php?page=dashboard_list&type=skill');
        exit;
    }

    public function delete(): void {
        Auth::requireLogin();

        try {

            if (!isset($_GET['id'])) {
                Flash::add('error', 'Compétence introuvable.');
                header('Location: index.php?page=dashboard_list&type=skill');
                exit;
            }
    
            (new SkillRepository())->delete((int) $_GET['id']);
            Flash::add('success', 'La compétence a bien été supprimée.');
            header('Location: index.php?page=dashboard_list&type=skill');
            exit;
            
        } catch (\Exeption $e){
            Flash::add('error', 'La compétence n\'a pas pu être supprimée.');
            header('Location: index.php?page=dashboard_list&type=skill');
            exit;
        }
    }
}
