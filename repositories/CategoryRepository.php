<?php

namespace Repositories;

use Models\Category;

// Gère les requêtes SQL pour les catégories
class CategoryRepository extends AbstractRepository {
    public function getAllCategories(): array {
        $stmt = $this->pdo->query('SELECT * FROM category ORDER BY name ASC');
        $rows = $stmt->fetchAll();
        $categories = [];

        foreach ($rows as $row) {
            $categories[] = new Category($row['name'], (int) $row['id']);
        }

        return $categories;
    }

    public function getCategoryById(int $id): ?Category {
        $stmt = $this->pdo->prepare('SELECT * FROM category WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        return new Category($row['name'], (int) $row['id']);
    }

    public function save(Category $category): bool {
        if ($category->getId() === null) {
            $stmt = $this->pdo->prepare('INSERT INTO category (name) VALUES (:name)');
            $success = $stmt->execute(['name' => trim((string) $category->getName())]);

            if ($success) {
                $category->setId((int) $this->pdo->lastInsertId());
            }

            return $success;
        }

        $stmt = $this->pdo->prepare('UPDATE category SET name = :name WHERE id = :id');
        return $stmt->execute([
            'name' => trim((string) $category->getName()),
            'id' => $category->getId(),
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare('DELETE FROM category WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}
