<?php

namespace Services;

use PDO;
use PDOException;

class DataBase
{
    // Attributs privés
    private string $host = "localhost";
    private string $dbname = "portfolio-db";
    private string $username = "root";
    private string $password = "";
    private ?PDO $pdo = null;

    // Constructeur
    public function __construct()
    {
        try {
            $this->pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8",
                $this->username,
                $this->password
            );

            // Activation des erreurs PDO
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    // Méthode publique pour récupérer la connexion
    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}

// $bd = new Database();
// var_dump($bd-> getConnection());