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

    
}