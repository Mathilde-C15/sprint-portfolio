<?php

namespace Repositories;

use Models\Skill;

// Gère les requêtes SQL pour les compétences
class SkillRepository extends AbstractRepository {
    public function getAllSkills(): array {
        $stmt = $this->pdo->query('SELECT * FROM skill ORDER BY level DESC, name ASC');
        $rows = $stmt->fetchAll();
        $skills = [];

        foreach ($rows as $row) {
            $skills[] = new Skill($row['name'], (int) $row['level'], (int) $row['id']);
        }

        return $skills;
    }

    // Récupérer un skill par son ID
    public function getSkillById(int $id): ?Skill {
        $stmt = $this->pdo->prepare('SELECT * FROM skill WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        return new Skill($row['name'], (int) $row['level'], (int) $row['id']);
    }

    // Créer un skill
    public function save(Skill $skill): bool {
        if ($skill->getId() === null) {
            $stmt = $this->pdo->prepare('INSERT INTO skill (name, level) VALUES (:name, :level)');
            $success = $stmt->execute([
                'name' => trim((string) $skill->getName()),
                'level' => $skill->getLevel(),
            ]);

            if ($success) {
                $skill->setId((int) $this->pdo->lastInsertId());
            }

            return $success;
        }

        $stmt = $this->pdo->prepare('UPDATE skill SET name = :name, level = :level WHERE id = :id');
        return $stmt->execute([
            'name' => trim((string) $skill->getName()),
            'level' => $skill->getLevel(),
            'id' => $skill->getId(),
        ]);
    }

    // Supprimer un skill
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare('DELETE FROM skill WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    // Récupérer les skills d'un projet
    public function getSkillsByProjectId(int $projectId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT skill.*
             FROM skill
             INNER JOIN skill_project ON skill_project.id_skill = skill.id
             WHERE skill_project.id_project = :project_id
             ORDER BY skill.level DESC, skill.name ASC'
        );
        $stmt->execute(['project_id' => $projectId]);
        $rows = $stmt->fetchAll();
        $skills = [];

        foreach ($rows as $row) {
            $skills[] = new Skill($row['name'], (int) $row['level'], (int) $row['id']);
        }

        return $skills;
    }
}
