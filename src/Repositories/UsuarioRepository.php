<?php

namespace Repositories;

use Models\Usuario;
use Models\Enums\TipoUsuario;
use Models\Enums\StatusUsuario;
use PDO;
use PDOException;

class UsuarioRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function createUser(Usuario $usuario): bool
    {
        $sql = '
            INSERT INTO usuario
                (nome, email, senha, telefone, endereco, tipo_usuario, status, data_cadastro)
            VALUES
                (:nome, :email, :senha, :telefone, :endereco, :tipo_usuario, :status, :data_cadastro)
        ';

        $stmt = $this->pdo->prepare($sql);

        $params = [
            ':nome' => $usuario->getNome(),
            ':email' => $usuario->getEmail(),
            ':senha' => $usuario->getSenha(),
            ':telefone' => $usuario->getTelefone(),
            ':endereco' => $usuario->getEndereco(),
            ':tipo_usuario' => $usuario->getTipoUsuario()->value,
            ':status' => $usuario->getStatus()->value,
            ':data_cadastro' => $usuario->getDataCadastro() ?? date('Y-m-d H:i:s'),
        ];

        try {
            $result = $stmt->execute($params);
            if ($result) {
                $lastId = $this->pdo->lastInsertId();
                if ($lastId) {
                    $usuario->setIdUsuario((int)$lastId);
                }
            }
            return $result;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function findByEmail(string $email): ?Usuario
    {
        $stmt = $this->pdo->prepare('SELECT * FROM usuario WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        return new Usuario(
            isset($data['id_usuario']) ? (int)$data['id_usuario'] : null,
            (string)($data['nome'] ?? ''),
            (string)($data['email'] ?? ''),
            (string)($data['senha'] ?? ''),
            $data['telefone'] ?? null,
            $data['endereco'] ?? null,
            $data['data_cadastro'] ?? null,
            isset($data['tipo_usuario']) ? TipoUsuario::from($data['tipo_usuario']) : TipoUsuario::EMPRESA,
            isset($data['status']) ? StatusUsuario::from($data['status']) : StatusUsuario::ATIVO
        );
    }

    public function updateUser(Usuario $usuario): bool
    {
        $id = $usuario->getIdUsuario();
        if ($id === null) {
            throw new PDOException("Usuário não possui ID definido para atualização.");
        }

        $sql = '
            UPDATE usuario SET
                nome = :nome,
                email = :email,
                senha = :senha,
                telefone = :telefone,
                endereco = :endereco,
                tipo_usuario = :tipo_usuario,
                status = :status
            WHERE id_usuario = :id_usuario
        ';

        $stmt = $this->pdo->prepare($sql);

        $params = [
            ':nome' => $usuario->getNome(),
            ':email' => $usuario->getEmail(),
            ':senha' => $usuario->getSenha(),
            ':telefone' => $usuario->getTelefone(),
            ':endereco' => $usuario->getEndereco(),
            ':tipo_usuario' => $usuario->getTipoUsuario()->value,
            ':status' => $usuario->getStatus()->value,
            ':id_usuario' => $id,
        ];

        try {
            $stmt->execute($params);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function login(string $email, string $senhaPlain): ?Usuario
    {
        $usuario = $this->findByEmail($email);
        if (!$usuario) {
            return null;
        }

        if ($usuario->verificarSenha($senhaPlain)) {
            return $usuario;
        }

        return null;
    }

    public function emailExists(string $email): bool
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM usuario WHERE email = :email');
        $stmt->execute([':email' => $email]);
        return (int)$stmt->fetchColumn() > 0;
    }
}
