<?php

namespace Repositories;

use Services\DataBase;
use Models\Category;
use PDO;

class CategorieRepository{
    private PDO $pdo;

    public function __construct(){
        $db = new DataBase();
        $this->pdo = $db->getConnection();
    }    

    // Retourne toutes les catégories
    public function getAllCategories(){
        $stmt = $this->pdo->query("SELECT * FROM category ORDER BY name");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $categories = [];

        foreach ($rows as $row){
            $category = new Category();
            $category->setId($row['id']);
            $category->setName($row['name']);

            $categories[] = $category;
        }

        return $categories;
    }

    // Retourne une seule catégorie
    public function getOneCategory(int $id){
        $stmt = $this->pdo->prepare("SELECT * FROM category WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row){
            return null;
        }

        $category = new Category();
        $category->setId($row['id']);
        $category->setName($row['name']);

        return $category;
    
    }

    // Créer une catégorie
    public function createCategory(string $name){
        $stmt = $this->pdo->prepare("INSERT INTO `category` (name) VALUES (:name)");
        $stmt->execute(['name' => $name]);

        $category = new Category();
        $category->setId((int) $this->pdo->lastInsertId());
        $category->setName($name);

        return $category;
    }

    // Supprimer une catégorie
    public function deleteCategory(int $id) {
        $stmt = $this->pdo->prepare("DELETE FROM category WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

}