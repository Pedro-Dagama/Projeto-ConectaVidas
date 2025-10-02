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
        $stmt = $this->pdo->prepare('SELECT * FROM usuario WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch();
        if ($data) {
            return new User(
                $data['id_usuario'],
                $data['nome'],
                $data['email'],
                $data['senha'],
                $data['tipo_usuario'],
                $data['criado_em'],
                $data['atualizado_em']);
        }
        return null;
    }
}
