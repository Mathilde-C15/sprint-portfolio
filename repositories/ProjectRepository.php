<?php

namespace Repositories;

use Services\DataBase;
use Models\Project;
use PDO;

class ProjectRepository{
    private PDO $pdo;

    public function __construct(){
        $db = new DataBase();
        $this->pdo = $db->getConnection();
    }

    // Retourne tous les projets
    public function getAllProjects(){
        $stmt = $this->pdo->query("SELECT * FROM project ORDER BY name");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $projects = [];

        foreach ($rows as $row) {
            $project = new Project();
            $project->setId($row['id']);
            $project->setName($row['name']);
            $project->setDescription($row['description']);
            
            $projects[] = $project;
        }

        return $projects;
    }

    // Retourne une seul projet
    public function getOneProject(int $id){

        $stmt = $this->pdo->prepare("SELECT * FROM project WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null; // project non trouvé
        }

        $project = new Project();
        $project->setId($row['id']);
        $project->setName($row['name']);
        $project->setDescription($row['description']);

        return $project;
    }

    // Créer un projet
    public function createProject(string $name, string $description){
        $stmt = $this->pdo->prepare("INSERT INTO `project` (name, description) VALUES (:name, :description)");
        $stmt->execute(['name' => $name],['description' => $description]);

        $project = new Project();
        $project->setId((int) $this->pdo->lastInsertId());
        $project->setName($name);
        $project->setDescription($description);

        return $project;
    }
}