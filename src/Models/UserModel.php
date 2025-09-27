<?php

namespace Models;

use PDO;

class UserModel
{
    private $pdo;

    public function __construct()
    {
        require_once __DIR__ . '/../Config/conn-db.php';
        $this->pdo = $pdo;
    }

    public function getUserByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
