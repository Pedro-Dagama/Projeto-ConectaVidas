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

    public function getHistoricoPorEmpresa(int $empresaId): array
    {
        $sql = "
        SELECT d.id_doacao, d.valor, d.data_doacao, d.status,
               c.titulo AS campanha, c.id_campanha,
               COALESCE(u.nome, 'Anônimo') AS doador_nome,
               d.forma_pagamento AS metodo_pagamento
        FROM doacao d
        INNER JOIN campanha c ON d.campanha_id_campanha = c.id_campanha
        LEFT JOIN usuario u ON d.usuario_id_usuario = u.id_usuario
        WHERE d.empresa_id_empresa = :empresaId
        ORDER BY d.data_doacao DESC
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':empresaId', $empresaId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
