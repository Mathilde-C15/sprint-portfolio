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
}