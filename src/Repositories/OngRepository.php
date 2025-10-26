<?php

namespace Repositories;

use PDO;
use PDOException;

class OngRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function createOngWithUser(array $orgDados, array $userDados): int
    {
        $cnpjRaw = $orgDados['cnpj'] ?? '';
        $cnpj = $cnpjRaw !== '' ? preg_replace('/\D/', '', $cnpjRaw) : '';

        if ($cnpj !== '' && strlen($cnpj) !== 14) {
            throw new \InvalidArgumentException('CNPJ inválido (deve conter 14 dígitos) quando informado.');
        }

        if ($cnpj !== '') {
            $stmtCheck = $this->pdo->prepare('SELECT id_organizacao FROM organizacao WHERE cnpj = :cnpj LIMIT 1');
            $stmtCheck->execute([':cnpj' => $cnpj]);
            if ($stmtCheck->fetch(PDO::FETCH_ASSOC)) {
                throw new \RuntimeException('Já existe uma organização com este CNPJ.');
            }
        }

        $stmtEmail = $this->pdo->prepare('SELECT id_usuario FROM usuario WHERE email = :email LIMIT 1');
        $stmtEmail->execute([':email' => $userDados['email']]);
        if ($stmtEmail->fetch(PDO::FETCH_ASSOC)) {
            throw new \RuntimeException('E-mail do responsável já cadastrado.');
        }

        try {
            $this->pdo->beginTransaction();

            // o campo `cep` no schema é NOT NULL — se o formulário não enviar,
            // string vazia '' para satisfazer a restrição.
            $stmtOrg = $this->pdo->prepare('
            INSERT INTO organizacao (tipo, cnpj, razao_social, cep, endereco, numero, cidade, estado, data_criacao)
            VALUES (:tipo, :cnpj, :razao_social, :cep, :endereco, :numero, :cidade, :estado, NOW())
        ');
            $stmtOrg->execute([
                ':tipo' => 'ong',
                ':cnpj' => $cnpj !== '' ? $cnpj : null,
                ':razao_social' => $orgDados['razao_social'] ?? null,
                ':cep' => $orgDados['cep'] ?? '',           // <<--- aqui
                ':endereco' => $orgDados['endereco'] ?? null,
                ':numero' => $orgDados['numero'] ?? null,
                ':cidade' => $orgDados['cidade'] ?? null,
                ':estado' => $orgDados['estado'] ?? null,
            ]);
            $idOrg = (int)$this->pdo->lastInsertId();

            $stmtOng = $this->pdo->prepare('
            INSERT INTO ong (organizacao_id_organizacao, area_atuacao)
            VALUES (:id_org, :area_atuacao)
        ');
            $stmtOng->execute([
                ':id_org' => $idOrg,
                ':area_atuacao' => $orgDados['area_atuacao'] ?? null
            ]);
            $idOng = (int)$this->pdo->lastInsertId();

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
                ':tipo_usuario' => 'ong',
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

    public function getOngByOrganizacao(int $idOrganizacao): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM ong WHERE organizacao_id_organizacao = :id_org LIMIT 1');
        $stmt->execute([':id_org' => $idOrganizacao]);
        $ong = $stmt->fetch(PDO::FETCH_ASSOC);
        return $ong ?: null;
    }

    public function findOrganizacaoWithOngByUsuario(int $idUsuario): ?array
{
    $sql = "
        SELECT org.*, o.id_ong, o.area_atuacao, o.nome_fantasia, o.logo
        FROM usuario_organizacao uo
        JOIN organizacao org ON org.id_organizacao = uo.organizacao_id_organizacao
        LEFT JOIN ong o ON o.organizacao_id_organizacao = org.id_organizacao
        WHERE uo.usuario_id_usuario = :usuarioId
        LIMIT 1
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([':usuarioId' => $idUsuario]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ?: null;
}
}
