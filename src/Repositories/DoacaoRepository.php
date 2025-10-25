<?php

declare(strict_types=1);

namespace Repositories;

use PDO;
use PDOException;

class DoacaoRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function createDoacaoConfirmed(array $data): int
    {
        $sql = "INSERT INTO doacao (data_doacao, valor, empresa_id_empresa, forma_pagamento, status, campanha_id_campanha)
                VALUES (NOW(), :valor, :empresa_id, :forma_pagamento, :status, :campanha_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':valor' => $data['valor'],
            ':empresa_id' => $data['empresa_id'],
            ':forma_pagamento' => $data['forma_pagamento'],
            ':status' => $data['status'],
            ':campanha_id' => $data['campanha_id'],
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM doacao WHERE id_doacao = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }
}
