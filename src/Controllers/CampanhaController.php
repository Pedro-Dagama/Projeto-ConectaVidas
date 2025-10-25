<?php

declare(strict_types=1);

namespace Controllers;

use Config\Database;
use Repositories\CampanhaRepository;
use PDO;

class CampanhaController
{
    private CampanhaRepository $repo;
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
        $this->repo = new CampanhaRepository($this->pdo);
    }

    private function ensureOngOr403(): int
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user']) || ($_SESSION['user']['tipo_usuario'] ?? '') !== 'ong') {
            http_response_code(403);
            echo "Acesso negado.";
            exit();
        }
        $idUsuario = (int)($_SESSION['user']['id_usuario'] ?? 0);
        $ongId = $this->getOngIdByUsuario($idUsuario);
        if ($ongId === null) {
            http_response_code(403);
            echo "Usuário não associado a ONG.";
            exit();
        }
        return $ongId;
    }

    public function index(): void
    {
        $ongId = $this->ensureOngOr403();
        $campanhas = $this->repo->findByOng($ongId);
        require_once __DIR__ . '/../Views/campanha/campanha.php';
    }

    public function view(): void
    {
        $ongId = $this->ensureOngOr403();

        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            header('Location: /?url=campanha');
            exit();
        }

        $campanha = $this->repo->findById($id);
        if (!$campanha || (int)$campanha['ong_id_ong'] !== $ongId) {
            http_response_code(403);
            echo "Campanha não encontrada ou sem permissão.";
            exit();
        }

        // Exibir uma view de detalhes (crie Views/Campanha/view.php se desejar)
        require_once __DIR__ . '/../Views/campanha/view.php';
    }

    public function edit(): void
    {
        $ongId = $this->ensureOngOr403();

        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            header('Location: /?url=campanha');
            exit();
        }

        $campanha = $this->repo->findById($id);
        if (!$campanha || (int)$campanha['ong_id_ong'] !== $ongId) {
            http_response_code(403);
            echo "Campanha não encontrada ou sem permissão.";
            exit();
        }

        // $campanha estará disponível para a view edit
        require_once __DIR__ . '/../Views/campanha/edit.php';
    }

    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /?url=campanha');
            exit();
        }

        $ongId = $this->ensureOngOr403();

        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['form_errors'] = ['ID inválido.'];
            header('Location: /?url=campanha');
            exit();
        }

        $campanha = $this->repo->findById($id);
        if (!$campanha || (int)$campanha['ong_id_ong'] !== $ongId) {
            http_response_code(403);
            echo "Campanha não encontrada ou sem permissão.";
            exit();
        }

        $titulo = trim((string)($_POST['titulo'] ?? ''));
        $categoriaKey = trim((string)($_POST['categoria'] ?? ''));
        $descricao = trim((string)($_POST['descricao'] ?? ''));
        $meta = (float)($_POST['meta'] ?? 0);
        $prazo = $_POST['prazo'] ?? null;

        $errors = [];
        if ($titulo === '') $errors[] = "Título é obrigatório.";
        if ($categoriaKey === '') $errors[] = "Categoria é obrigatória.";
        if ($descricao === '') $errors[] = "Descrição é obrigatória.";
        if ($meta <= 0) $errors[] = "Meta inválida.";
        if ($prazo === null || $prazo === '') $errors[] = "Data (prazo) é obrigatória.";

        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            header('Location: /?url=campanha/edit&id=' . $id);
            exit();
        }

        $categoriaId = $this->repo->getCategoriaIdByKey($categoriaKey);
        if ($categoriaId === null) {
            $stmt = $this->pdo->prepare('INSERT INTO categoria (nome, descricao) VALUES (:nome, :descricao)');
            $stmt->execute([':nome' => $categoriaKey, ':descricao' => ucfirst($categoriaKey)]);
            $categoriaId = (int)$this->pdo->lastInsertId();
        }

        $data = [
            'titulo' => $titulo,
            'descricao' => $descricao,
            'objetivo' => null,
            'meta' => $meta,
            'localizacao' => null,
            'data_encerramento' => $prazo . ' 23:59:59',
            'categoria_id' => $categoriaId,
        ];

        try {
            $ok = $this->repo->updateCampanha($id, $data);
            $_SESSION['success_message'] = $ok ? "Campanha atualizada com sucesso." : "Nenhuma alteração realizada.";
            header('Location: /?url=campanha');
            exit();
        } catch (\Throwable $e) {
            $_SESSION['form_errors'] = ['Erro ao atualizar campanha.'];
            header('Location: /?url=campanha/edit&id=' . $id);
            exit();
        }
    }

    public function close(): void
    {
        $ongId = $this->ensureOngOr403();

        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            header('Location: /?url=campanha');
            exit();
        }

        $campanha = $this->repo->findById($id);
        if (!$campanha || (int)$campanha['ong_id_ong'] !== $ongId) {
            http_response_code(403);
            echo "Campanha não encontrada ou sem permissão.";
            exit();
        }

        $ok = $this->repo->closeCampanha($id);
        $_SESSION['success_message'] = $ok ? "Campanha encerrada com sucesso." : "Falha ao encerrar campanha.";
        header('Location: /?url=campanha');
        exit();
    }

    private function getOngIdByUsuario(int $usuarioId): ?int
    {
        $sql = "
            SELECT o.id_ong
            FROM usuario_organizacao uo
            JOIN organizacao org ON org.id_organizacao = uo.organizacao_id_organizacao
            JOIN ong o ON o.organizacao_id_organizacao = org.id_organizacao
            WHERE uo.usuario_id_usuario = :usuarioId
            LIMIT 1
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':usuarioId' => $usuarioId]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$res) return null;
        return (int)$res['id_ong'];
    }

    /* public function index(): void
    {
        // Proteção: usuário logado e tipo ONG
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header('Location: /?url=login');
            exit();
        }

        if (($_SESSION['user']['tipo_usuario'] ?? '') !== 'ong') {
            http_response_code(403);
            echo "Acesso negado. Apenas usuários ONG podem acessar esta página.";
            exit();
        }

        $idUsuario = (int)($_SESSION['user']['id_usuario'] ?? 0);
        $ongId = $this->getOngIdByUsuario($idUsuario);

        $campanhas = [];
        if ($ongId !== null) {
            $campanhas = $this->repo->findByOng($ongId);
        }

        // a view espera $campanhas e mensagens em session
        require_once __DIR__ . '/../Views/campanha/campanha.php';
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /?url=campanha');
            exit();
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']) || ($_SESSION['user']['tipo_usuario'] ?? '') !== 'ong') {
            http_response_code(403);
            echo "Acesso negado.";
            exit();
        }

        $titulo = trim((string)($_POST['titulo'] ?? ''));
        $categoriaKey = trim((string)($_POST['categoria'] ?? ''));
        $descricao = trim((string)($_POST['descricao'] ?? ''));
        $meta = (float)($_POST['meta'] ?? 0);
        $prazo = $_POST['prazo'] ?? null;

        $errors = [];
        if ($titulo === '') $errors[] = "Título é obrigatório.";
        if ($categoriaKey === '') $errors[] = "Categoria é obrigatória.";
        if ($descricao === '') $errors[] = "Descrição é obrigatória.";
        if ($meta <= 0) $errors[] = "Meta inválida.";
        if ($prazo === null || $prazo === '') $errors[] = "Data (prazo) é obrigatória.";

        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            header('Location: /?url=campanha');
            exit();
        }

        // encontra categoria id
        $categoriaId = $this->repo->getCategoriaIdByKey($categoriaKey);
        if ($categoriaId === null) {
            $stmt = $this->pdo->prepare('INSERT INTO categoria (nome, descricao) VALUES (:nome, :descricao)');
            $stmt->execute([':nome' => $categoriaKey, ':descricao' => ucfirst($categoriaKey)]);
            $categoriaId = (int)$this->pdo->lastInsertId();
        }

        // obtém ong id
        $idUsuario = (int)($_SESSION['user']['id_usuario'] ?? 0);
        $ongId = $this->getOngIdByUsuario($idUsuario);
        if ($ongId === null) {
            $_SESSION['form_errors'] = ['Usuário não está associado a uma ONG.'];
            header('Location: /?url=campanha');
            exit();
        }

        // preparar dados
        $data = [
            'titulo' => $titulo,
            'descricao' => $descricao,
            'objetivo' => null,
            'meta' => $meta,
            'localizacao' => null,
            'data_encerramento' => $prazo . ' 23:59:59',
            'categoria_id' => $categoriaId,
            'ong_id' => $ongId,
        ];

        try {
            $campanhaId = $this->repo->createCampanha($data);
            $_SESSION['success_message'] = "Campanha criada com sucesso!";
            header('Location: /?url=campanha');
            exit();
        } catch (\Throwable $e) {
            $_SESSION['form_errors'] = ['Erro ao salvar campanha.'];
            header('Location: /?url=campanha');
            exit();
        }
    }

    private function getOngIdByUsuario(int $usuarioId): ?int
    {
        $sql = "
            SELECT o.id_ong
            FROM usuario_organizacao uo
            JOIN organizacao org ON org.id_organizacao = uo.organizacao_id_organizacao
            JOIN ong o ON o.organizacao_id_organizacao = org.id_organizacao
            WHERE uo.usuario_id_usuario = :usuarioId
            LIMIT 1
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':usuarioId' => $usuarioId]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$res) return null;
        return (int)$res['id_ong'];
    } */
}
