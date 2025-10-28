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

    /**
     * @throws \InvalidArgumentException|\RuntimeException|\PDOException
     */
    public function createEmpresaWithUser(array $orgDados, array $userDados): int
    {
        // Normalizações básicas
        $cnpjRaw = $orgDados['cnpj'] ?? '';
        $cnpj = preg_replace('/\D/', '', (string)$cnpjRaw);

        if ($cnpj === '' || strlen($cnpj) !== 14) {
            throw new \InvalidArgumentException('CNPJ inválido (deve conter 14 dígitos).');
        }

        // verifica se já existe organizacao com o mesmo CNPJ
        $stmtCheck = $this->pdo->prepare('SELECT id_organizacao FROM organizacao WHERE cnpj = :cnpj LIMIT 1');
        $stmtCheck->execute([':cnpj' => $cnpj]);
        if ($stmtCheck->fetch(PDO::FETCH_ASSOC)) {
            throw new \RuntimeException('Já existe uma organização com este CNPJ.');
        }

        // verifica email do usuário
        $email = $userDados['email'] ?? '';
        if ($email === '') {
            throw new \InvalidArgumentException('E-mail do responsável é obrigatório.');
        }
        $stmtEmail = $this->pdo->prepare('SELECT id_usuario FROM usuario WHERE email = :email LIMIT 1');
        $stmtEmail->execute([':email' => $email]);
        if ($stmtEmail->fetch(PDO::FETCH_ASSOC)) {
            throw new \RuntimeException('E-mail do responsável já cadastrado.');
        }

        // senha
        $senhaPlain = $userDados['senha'] ?? '';
        if ($senhaPlain === '') {
            throw new \InvalidArgumentException('Senha do responsável não pode ficar vazia.');
        }

        // inserir em transação
        try {
            $this->pdo->beginTransaction();

            // 1) organizacao
            $stmtOrg = $this->pdo->prepare('
                INSERT INTO organizacao (tipo, cnpj, razao_social, cep, endereco, numero, cidade, estado)
                VALUES (:tipo, :cnpj, :razao_social, :cep, :endereco, :numero, :cidade, :estado)
            ');
            $stmtOrg->execute([
                ':tipo' => 'empresa',
                ':cnpj' => $cnpj,
                ':razao_social' => $orgDados['razao_social'] ?? null,
                ':cep' => $orgDados['cep'] ?? null,
                ':endereco' => $orgDados['endereco'] ?? null,
                ':numero' => $orgDados['numero'] ?? null,
                ':cidade' => $orgDados['cidade'] ?? null,
                ':estado' => $orgDados['estado'] ?? null,
            ]);
            $idOrg = (int)$this->pdo->lastInsertId();

            // 2) empresa
            $stmtEmp = $this->pdo->prepare('
                INSERT INTO empresa (organizacao_id_organizacao, nome_fantasia)
                VALUES (:id_org, :nome_fantasia)
            ');
            $stmtEmp->execute([
                ':id_org' => $idOrg,
                ':nome_fantasia' => $orgDados['nome_fantasia'] ?? null
            ]);
            $idEmpresa = (int)$this->pdo->lastInsertId();

            // 3) usuario
            $senhaHash = password_hash($senhaPlain, PASSWORD_DEFAULT);
            $stmtUsr = $this->pdo->prepare('
                INSERT INTO usuario (nome, email, senha, telefone, endereco, tipo_usuario, status)
                VALUES (:nome, :email, :senha, :telefone, :endereco, :tipo_usuario, :status)
            ');
            $stmtUsr->execute([
                ':nome' => $userDados['nome'] ?? null,
                ':email' => $email,
                ':senha' => $senhaHash,
                ':telefone' => $userDados['telefone'] ?? null,
                ':endereco' => $orgDados['endereco'] ?? null, // preferir endereço da org
                ':tipo_usuario' => 'empresa',
                ':status' => 'ativo'
            ]);
            $idUsuario = (int)$this->pdo->lastInsertId();

            // 4) vinculo usuario_organizacao
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
            // relança para o Controller lidar (ou log)
            throw $e;
        }
    }

    /**
     * Recupera a organizacao vinculada a um usuario via tabela usuario_organizacao.
     */
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

    /**
     * Retorna a linha da tabela empresa para uma organização.
     */
    public function getEmpresaByOrganizacao(int $idOrganizacao): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM empresa WHERE organizacao_id_organizacao = :id_org LIMIT 1');
        $stmt->execute([':id_org' => $idOrganizacao]);
        $empresa = $stmt->fetch(PDO::FETCH_ASSOC);
        return $empresa ?: null;
    }
}
