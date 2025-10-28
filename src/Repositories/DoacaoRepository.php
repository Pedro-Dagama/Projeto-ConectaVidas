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

    /*     public function createDoacaoConfirmed(array $data): int
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
    } */

    public function createDoacaoConfirmed(array $data): int
    {
        $sql = "INSERT INTO doacao (data_doacao, valor, empresa_id_empresa, forma_pagamento, status, campanha_id_campanha) VALUES (NOW(), :valor, :empresa_id, :forma_pagamento, :status, :campanha_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':valor' => $data['valor'], ':empresa_id' => $data['empresa_id'], ':forma_pagamento' => $data['forma_pagamento'], ':status' => $data['status'], ':campanha_id' => $data['campanha_id'],]);
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

    public function findByEmpresa(int $empresaId, ?int $campanhaId = null, int $limit = 20, int $offset = 0): array
    {
        $sql = " SELECT d.id_doacao, d.data_doacao, d.valor, d.forma_pagamento, d.status AS status_doacao, c.id_campanha, c.titulo AS campanha_titulo, p.id_pagamento, p.status AS status_pagamento, p.tipo AS pagamento_tipo, p.codigo_transacao FROM doacao d LEFT JOIN campanha c ON c.id_campanha = d.campanha_id_campanha LEFT JOIN pagamento p ON p.doacao_id_doacao = d.id_doacao WHERE d.empresa_id_empresa = :empresaId ";
        $params = [':empresaId' => $empresaId];
        if ($campanhaId !== null && $campanhaId > 0) {
            $sql .= " AND d.campanha_id_campanha = :campanhaId";
            $params[':campanhaId'] = $campanhaId;
        }
        $sql .= " ORDER BY d.data_doacao DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        foreach ($params as $k => $v) {
            if ($k === ':limit' || $k === ':offset') continue;
            $stmt->bindValue($k, $v);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
