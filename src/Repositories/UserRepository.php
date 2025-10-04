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

    public function createuser(User $user): bool
    {
        $stmt = $this->pdo->prepare('
        INSERT INTO usuario
        (
            nome, 
            email, 
            senha, 
            tipo_usuario, 
            criado_em, 
            atualizado_em) 
        VALUES 
        (
            :nome, 
            :email, 
            :senha, 
            :tipo_usuario, 
            :criado_em, 
            :atualizado_em)');
        return $stmt->execute([
            ':nome' => $user->getNome(),
            ':email' => $user->getEmail(),
            ':senha' => $user->getSenha(),
            ':tipo_usuario' => $user->getTipoUsuario(),
            ':criado_em' => $user->getCriadoEm(),
            ':atualizado_em' => $user->getAtualizadoEm()
        ]);
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
                $data['atualizado_em']
            );
        }
        return null;
    }

    public function emailExists(string $email): bool
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM usuario WHERE email = :email');
        $stmt->execute(['email' => $email]);
        return $stmt->fetchColumn() > 0;
    }
}
