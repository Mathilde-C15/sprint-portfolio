<?php

namespace Services;

use PDO;
use PDOException;

// Connexion à la base de données
class DataBase
{
    private string $host = 'localhost';
    private string $dbname = 'db-portfolio';
    private string $username = 'root';
    private string $password = '';
    private ?PDO $pdo = null;

    public function __construct() {
        try {
            $this->pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
                $this->username,
                $this->password
            );

            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            die('Erreur de connexion : ' . $exception->getMessage());
        }
    }

    public function getConnection(): PDO {
        return $this->pdo;
    }
}
