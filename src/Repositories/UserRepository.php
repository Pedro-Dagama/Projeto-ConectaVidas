<?php

namespace Repositories;

use Models\User;
use PDO;

class UserRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findByEmail(string $email): ?User
    {
        $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch();
        if ($data) {
            return new User(
                $data['id'],
                $data['nome'],
                $data['email'],
                $data['senha'],
                $data['tipo_usuario']);
        }
        return null;
    }
}
