<?php

namespace Repositories;

use PDO;
use PDOException;

class EmpresaRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function createEmpresaWithUser(array $orgDados, array $userDados): int
    {
        $cnpjRaw = $orgDados['cnpj'] ?? '';
        $cnpj = preg_replace('/\D/', '', $cnpjRaw);

        if (strlen($cnpj) !== 14) {
            throw new \InvalidArgumentException('CNPJ inválido (deve conter 14 dígitos).');
        }

        $stmtCheck = $this->pdo->prepare('SELECT id_organizacao FROM organizacao WHERE cnpj = :cnpj LIMIT 1');
        $stmtCheck->execute([':cnpj' => $cnpj]);
        if ($stmtCheck->fetch(PDO::FETCH_ASSOC)) {
            throw new \RuntimeException('Já existe uma organização com este CNPJ.');
        }

        $stmtEmail = $this->pdo->prepare('SELECT id_usuario FROM usuario WHERE email = :email LIMIT 1');
        $stmtEmail->execute([':email' => $userDados['email']]);
        if ($stmtEmail->fetch(PDO::FETCH_ASSOC)) {
            throw new \RuntimeException('E-mail do responsável já cadastrado.');
        }

        try {
            $this->pdo->beginTransaction();

            $stmtOrg = $this->pdo->prepare('
                INSERT INTO organizacao (tipo, cnpj, razao_social, data_criacao)
                VALUES (:tipo, :cnpj, :razao_social, NOW())
            ');
            $stmtOrg->execute([
                ':tipo' => 'empresa',
                ':cnpj' => $cnpj,
                ':razao_social' => $orgDados['razao_social'] ?? null
            ]);
            $idOrg = (int)$this->pdo->lastInsertId();

            $stmtEmp = $this->pdo->prepare('
                INSERT INTO empresa (organizacao_id_organizacao, nome_fantasia)
                VALUES (:id_org, :nome_fantasia)
            ');
            $stmtEmp->execute([
                ':id_org' => $idOrg,
                ':nome_fantasia' => $orgDados['nome_fantasia'] ?? null
            ]);
            $idEmpresa = (int)$this->pdo->lastInsertId();

            $senhaPlain = $userDados['senha_plain'] ?? '';
            if ($senhaPlain === '') {
                throw new \InvalidArgumentException('Senha do responsável não pode ficar vazia.');
            }
            $senhaHash = password_hash($senhaPlain, PASSWORD_DEFAULT);

            $stmtUsr = $this->pdo->prepare('
                INSERT INTO usuario (nome, email, senha, telefone, endereco, tipo_usuario, status, data_cadastro)
                VALUES (:nome, :email, :senha, :telefone, :endereco, :tipo_usuario, :status, NOW())
            ');
            $stmtUsr->execute([
                ':nome' => $userDados['nome'],
                ':email' => $userDados['email'],
                ':senha' => $senhaHash,
                ':telefone' => $userDados['telefone'] ?? null,
                ':endereco' => $userDados['endereco'] ?? null,
                ':tipo_usuario' => 'empresa',
                ':status' => 'ativo'
            ]);
            $idUsuario = (int)$this->pdo->lastInsertId();

            $stmtLink = $this->pdo->prepare('
                INSERT INTO usuario_organizacao (usuario_id_usuario, organizacao_id_organizacao)
                VALUES (:id_usuario, :id_org)
            ');
            $stmtLink->execute([
                ':id_usuario' => $idUsuario,
                ':id_org' => $idOrg
            ]);

            $this->pdo->commit();
            return $idOrg;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function getOrganizacaoByUsuario(int $idUsuario): ?array
    {
        $stmt = $this->pdo->prepare('
            SELECT org.*
            FROM organizacao org
            JOIN usuario_organizacao uo ON uo.organizacao_id_organizacao = org.id_organizacao
            WHERE uo.usuario_id_usuario = :id_usuario
            LIMIT 1
        ');
        $stmt->execute([':id_usuario' => $idUsuario]);
        $org = $stmt->fetch(PDO::FETCH_ASSOC);
        return $org ?: null;
    }

    public function getEmpresaByOrganizacao(int $idOrganizacao): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM empresa WHERE organizacao_id_organizacao = :id_org LIMIT 1');
        $stmt->execute([':id_org' => $idOrganizacao]);
        $empresa = $stmt->fetch(PDO::FETCH_ASSOC);
        return $empresa ?: null;
    }
}
