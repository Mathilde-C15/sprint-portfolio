<?php

namespace Repositories;

use Models\Project;

// Gère les requêtes SQL pour les projets
class ProjectRepository extends AbstractRepository {
    public function getAllProjects(): array {
        $stmt = $this->pdo->query('SELECT * FROM project ORDER BY id DESC');
        $rows = $stmt->fetchAll();
        return $this->hydrateProjects($rows);
    }

    public function getProjectsByCategory(?int $categoryId = null): array {
        if ($categoryId === null) {
            return $this->getAllProjects();
        }

        $stmt = $this->pdo->prepare('SELECT * FROM project WHERE id_category = :category_id ORDER BY id DESC');
        $stmt->execute(['category_id' => $categoryId]);
        return $this->hydrateProjects($stmt->fetchAll());
    }

    public function getProjectById(int $id): ?Project {
        $stmt = $this->pdo->prepare('SELECT * FROM project WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $rows = $stmt->fetchAll();
        $projects = $this->hydrateProjects($rows);
        return $projects[0] ?? null;
    }

    public function save(Project $project, array $skillIds = []): bool {
        $this->pdo->beginTransaction();

        try {
            if ($project->getId() === null) {
                $stmt = $this->pdo->prepare(
                    'INSERT INTO project (name, description, id_skill, id_category)
                     VALUES (:name, :description, :id_skill, :id_category)'
                );
                $success = $stmt->execute([
                    'name' => trim((string) $project->getName()),
                    'description' => $project->getDescription(),
                    'id_skill' => $project->getPrimarySkillId(),
                    'id_category' => $project->getCategoryId(),
                ]);

                if (!$success) {
                    $this->pdo->rollBack();
                    return false;
                }

                $project->setId((int) $this->pdo->lastInsertId());
            } else {
                $stmt = $this->pdo->prepare(
                    'UPDATE project
                     SET name = :name,
                         description = :description,
                         id_skill = :id_skill,
                         id_category = :id_category
                     WHERE id = :id'
                );
                $success = $stmt->execute([
                    'name' => trim((string) $project->getName()),
                    'description' => $project->getDescription(),
                    'id_skill' => $project->getPrimarySkillId(),
                    'id_category' => $project->getCategoryId(),
                    'id' => $project->getId(),
                ]);

                if (!$success) {
                    $this->pdo->rollBack();
                    return false;
                }

                $delete = $this->pdo->prepare('DELETE FROM skill_project WHERE id_project = :project_id');
                $delete->execute(['project_id' => $project->getId()]);
            }

            $insertPivot = $this->pdo->prepare('INSERT INTO skill_project (id_skill, id_project) VALUES (:skill_id, :project_id)');
            foreach ($skillIds as $skillId) {
                $insertPivot->execute([
                    'skill_id' => (int) $skillId,
                    'project_id' => $project->getId(),
                ]);
            }

            $this->pdo->commit();
            return true;
        } catch (\Throwable $throwable) {
            $this->pdo->rollBack();
            return false;
        }
    }

    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare('DELETE FROM project WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    private function hydrateProjects(array $rows): array {
        $projects = [];
        $categoryRepository = new CategoryRepository();
        $skillRepository = new SkillRepository();
        $pictureRepository = new PictureRepository();

        foreach ($rows as $row) {
            $project = new Project(
                $row['name'],
                $row['description'],
                isset($row['id_skill']) ? (int) $row['id_skill'] : null,
                isset($row['id_category']) ? (int) $row['id_category'] : null,
                (int) $row['id']
            );

            if (isset($row['id_category'])) {
                $project->setCategory($categoryRepository->getCategoryById((int) $row['id_category']));
            }

            $project->setSkills($skillRepository->getSkillsByProjectId((int) $row['id']));
            $pictures = $pictureRepository->getPicturesByProjectId((int) $row['id']);
            $project->setPictures($pictures);
            $project->setPicture($pictures[0] ?? null);
            $projects[] = $project;
        }

        return $projects;
    }
}
