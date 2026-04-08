<?php

namespace Repositories;

use Models\Picture;

// Gère les requêtes SQL pour les images
class PictureRepository extends AbstractRepository {

    public function getPictureByProjectId(int $projectId): ?Picture {
        $pictures = $this->getPicturesByProjectId($projectId);
        return $pictures[0] ?? null;
    }

    public function getPicturesByProjectId(int $projectId): array {
        $stmt = $this->pdo->prepare('SELECT * FROM picture WHERE id_project = :project_id ORDER BY id ASC');
        $stmt->execute(['project_id' => $projectId]);
        $rows = $stmt->fetchAll();

        $pictures = [];
        foreach ($rows as $row) {
            $pictures[] = new Picture($row['image_path'], $row['image_alt'], (int) $row['id_project'], (int) $row['id']);
        }

        return $pictures;
    }

    public function saveProjectPictures(int $projectId, array $pictures): bool {
        $delete = $this->pdo->prepare('DELETE FROM picture WHERE id_project = :project_id');
        $delete->execute(['project_id' => $projectId]);

        if (empty($pictures)) {
            return true;
        }

        $stmt = $this->pdo->prepare('INSERT INTO picture (image_path, image_alt, id_project) VALUES (:image_path, :image_alt, :project_id)');

        foreach ($pictures as $picture) {
            $path = trim((string) ($picture['path'] ?? ''));
            $alt = trim((string) ($picture['alt'] ?? ''));

            if ($path === '') {
                continue;
            }

            $success = $stmt->execute([
                'image_path' => $path,
                'image_alt' => $alt !== '' ? $alt : 'Illustration du projet',
                'project_id' => $projectId,
            ]);

            if (!$success) {
                return false;
            }
        }

        return true;
    }
}
