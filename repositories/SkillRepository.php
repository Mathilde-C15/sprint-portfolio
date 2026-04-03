<?php

namespace Repository;

class SkillRepository{
    private PDO $pdo;

    public function __construct(){
        $db = new DataBase();
        $this->pdo = $db->getConnection();
    }

    // Retourne tous les skills
    public function getAllSkills(){
        $stmt = $this->pdo->query("SELECT * FROM skill ORDER BY name");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $skills = [];

        foreach ($rows as $row){

        }
    }

    // Créer un skill
    public function createSkill(string $name){
        $stmt = $this->pdo->prepare("INSERT INTO `skill` (name) VALUES (:name)");
        $stmt->execute(['name' => $name]);

        $skill = new Skill();
        $skill->setId((int) $this->pdo->lastInsertId());
        $skill->setName($name);
        $skill->setDescription($description);

        return $skill;
    }

    // Supprimer un skill
    public function deleteSkill(int $id){
        $stmt = $this->pdo->prepare("DELETE FROM skill WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}