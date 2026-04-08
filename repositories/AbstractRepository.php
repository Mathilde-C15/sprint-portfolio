<?php

namespace Repositories;

use PDO;
use Services\DataBase;

// Fait la connexion à la base de données depuis le constructeur
abstract class AbstractRepository {
    protected PDO $pdo;

    public function __construct() {
        $database = new DataBase();
        $this->pdo = $database->getConnection();
    }
}
