<?php

namespace Repository;

use Services\DatBase;
use Models\User;
use PDO;

class UserRepository{
    private PDO $pdo;

    public function __construct(){
        $db = new DataBase();
        $this->pdo = $db->getConnection();
    }

    public function updateUserInfo(string $email, 
                                    string $phone, 
                                    string $name, 
                                    string $familyName,
                                    string $password, 
                                    string $description, 
                                    string $birthdate, 
                                    string $github,
                                    string $linkedin,
                                    string $cv,
                                    int $idPicture,
                                    int $id
                                    ) {
        $stmt = $this->pdo->prepare("UPDATE user SET
                                                    email = :email,
                                                    phone = :phone,
                                                    name = :name,
                                                    family_name = :familyName,
                                                    password = :password,
                                                    description = :description,
                                                    birthdate = :birthdate,
                                                    github = :github,
                                                    linkedin = :linkedin,
                                                    cv = :cv,
                                                    id_picture = :idPicture
                                    WHERE id = :id");

        return $stmt->execute([
            'email' => $email,
            'phone' => $phone,
            'name' => $name,
            'familyName' => $familyName,
            'password' => $password,
            'description' => $description,
            'birthdate' => $birthdate,
            'github' => $github,
            'linkedin' => $linkedin,
            'cv' => $cv,
            'idPicture' => $idPicture,
            'id' => $id
        ]);
    }
        
}