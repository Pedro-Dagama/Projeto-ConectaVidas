<?php

declare(strict_types=1);

namespace Repositories;

use PDO;
use PDOException;

class CampanhaRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getCategoriaIdByKey(string $key): ?int
    {
        $stmt = $this->pdo->prepare('SELECT id_categoria FROM categoria WHERE nome = :nome LIMIT 1');
        $stmt->execute([':nome' => $key]);
        $id = $stmt->fetchColumn();
        return $id ? (int)$id : null;
    }

    public function createCampanha(array $data): int
    {
        $sql = "INSERT INTO campanha
            (titulo, descricao, objetivo, meta, valor_arrecadado, status, localizacao, data_criacao, data_encerramento, categoria_id_categoria, ong_id_ong)
            VALUES
            (:titulo, :descricao, :objetivo, :meta, 0, 'ativa', :localizacao, NOW(), :data_encerramento, :categoria_id, :ong_id)";
        $stmt = $this->pdo->prepare($sql);
        $params = [
            ':titulo' => $data['titulo'],
            ':descricao' => $data['descricao'],
            ':objetivo' => $data['objetivo'] ?? null,
            ':meta' => $data['meta'],
            ':localizacao' => $data['localizacao'] ?? null,
            ':data_encerramento' => $data['data_encerramento'],
            ':categoria_id' => $data['categoria_id'],
            ':ong_id' => $data['ong_id'],
        ];
        try {
            $stmt->execute($params);
            return (int)$this->pdo->lastInsertId();
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function findByOng(int $ongId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT c.*, cat.nome as categoria_nome FROM campanha c
             LEFT JOIN categoria cat ON cat.id_categoria = c.categoria_id_categoria
             WHERE c.ong_id_ong = :ongId ORDER BY c.data_criacao DESC'
        );
        $stmt->execute([':ongId' => $ongId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT c.*, cat.nome as categoria_nome FROM campanha c LEFT JOIN categoria cat ON cat.id_categoria = c.categoria_id_categoria WHERE c.id_campanha = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function updateCampanha(int $id, array $data): bool
    {
        $sql = 'UPDATE campanha SET titulo = :titulo, descricao = :descricao, objetivo = :objetivo, meta = :meta, data_encerramento = :data_encerramento, categoria_id_categoria = :categoria_id, localizacao = :localizacao WHERE id_campanha = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':titulo' => $data['titulo'],
            ':descricao' => $data['descricao'],
            ':objetivo' => $data['objetivo'] ?? null,
            ':meta' => $data['meta'],
            ':data_encerramento' => $data['data_encerramento'],
            ':categoria_id' => $data['categoria_id'],
            ':localizacao' => $data['localizacao'] ?? null,
            ':id' => $id,
        ]);
        return $stmt->rowCount() > 0;
    }

    public function closeCampanha(int $id): bool
    {
        $stmt = $this->pdo->prepare("UPDATE campanha SET status = 'finalizada' WHERE id_campanha = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }
}
