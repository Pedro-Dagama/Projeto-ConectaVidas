<?php

namespace Controllers;

use Config\Database;
use Repositories\OngRepository;
use Repositories\CampanhaRepository;
use PDO;

class OngController
{
    private OngRepository $repo;
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
        $this->repo = new OngRepository($this->pdo);
    }

    public function showCreateForm(?string $error = null): void
    {
        require_once __DIR__ . '/../Views/ong/create.php';
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->showCreateForm();
            return;
        }

        $orgDados = [
            'cnpj' => $_POST['cnpj'] ?? '',
            'razao_social' => trim($_POST['razao_social'] ?? ''),
            'nome_fantasia' => trim($_POST['nome_fantasia'] ?? ''),
            'area_atuacao' => trim($_POST['area_atuacao'] ?? ''),
            'descricao' => trim($_POST['descricao'] ?? ''),
        ];

        $userDados = [
            'nome' => trim($_POST['responsavel_nome'] ?? ''),
            'email' => trim($_POST['responsavel_email'] ?? ''),
            'senha_plain' => $_POST['responsavel_senha'] ?? '',
            'telefone' => trim($_POST['telefone'] ?? ''),
            'endereco' => trim($_POST['endereco'] ?? '')
        ];

        if ($userDados['nome'] === '' || $userDados['email'] === '' || $userDados['senha_plain'] === '' || $orgDados['razao_social'] === '') {
            $this->showCreateForm("Preencha todos os campos obrigatórios.");
            return;
        }

        if (!filter_var($userDados['email'], FILTER_VALIDATE_EMAIL)) {
            $this->showCreateForm("E-mail do responsável inválido.");
            return;
        }

        if ($userDados['senha_plain'] !== ($_POST['responsavel_confirmar_senha'] ?? '')) {
            $this->showCreateForm("As senhas não conferem.");
            return;
        }

        try {
            $idOrg = $this->repo->createOngWithUser($orgDados, $userDados);
            header('Location: /?url=login&created=1');
            exit();
        } catch (\Throwable $e) {
            $this->showCreateForm($e->getMessage());
        }
    }

    public function loadSessionForUser(int $idUsuario): bool
    {
        if ($idUsuario <= 0) return false;

        // tenta pegar organizacao (já existente)
        $organizacao = $this->repo->getOrganizacaoByUsuario($idUsuario);
        if (!$organizacao) {
            return false;
        }

        // pega dados da tabela ong (pode retornar null se não houver)
        $ongRow = $this->repo->getOngByOrganizacao((int)$organizacao['id_organizacao']);

        // montar array unificado com prioridade para campos da tabela ong quando fizer sentido
        $sessionOng = [
            'id_organizacao'    => isset($organizacao['id_organizacao']) ? (int)$organizacao['id_organizacao'] : null,
            'id_ong'            => isset($ongRow['id_ong']) ? (int)$ongRow['id_ong'] : null,
            'cnpj'              => $organizacao['cnpj'] ?? null,
            'razao_social'      => $organizacao['razao_social'] ?? null,
            'nome_fantasia'     => $ongRow['nome_fantasia'] ?? $organizacao['razao_social'] ?? null,
            'telefone'          => $organizacao['telefone'] ?? $ongRow['telefone'] ?? null,
            'email'             => $organizacao['email'] ?? $ongRow['email'] ?? null,
            'cep'               => $organizacao['cep'] ?? null,
            'endereco'          => $organizacao['endereco'] ?? $ongRow['endereco'] ?? null,
            'numero'            => $organizacao['numero'] ?? $ongRow['numero'] ?? null,
            'cidade'            => $organizacao['cidade'] ?? $ongRow['cidade'] ?? null,
            'estado'            => $organizacao['estado'] ?? $ongRow['estado'] ?? null,
            'descricao'         => $ongRow['descricao'] ?? $organizacao['descricao'] ?? null,
            'logo'              => $ongRow['logo'] ?? $organizacao['logo'] ?? null,
            'area_atuacao'      => $ongRow['area_atuacao'] ?? $organizacao['area_atuacao'] ?? null,
            // campos extras para a view (pode calcular dinamicamente)
            'active_campaigns'  => 0,
            'impact_value'      => 'R$ 0,00',
            'campaigns'         => [],
        ];

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['ong'] = $sessionOng;
        return true;
    }

    /*  public function dashboard(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $user = $_SESSION['user'] ?? null;
        if (empty($user) || empty($user['id_usuario'])) {
            header('Location: /?url=login');
            exit();
        }

        $sessionOng = $_SESSION['ong'] ?? null;
        if (!$sessionOng || ($sessionOng['id_organizacao'] ?? null) === null) {
            $this->loadSessionForUser((int)$user['id_usuario']);
        }

        $organizacao = $_SESSION['ong'] ?? null;
        $ong = [
            'nome_fantasia' => $organizacao['nome_fantasia'] ?? null,
            'cnpj' => $organizacao['cnpj'] ?? null,
            'email' => $organizacao['email'] ?? null,
            'telefone' => $organizacao['telefone'] ?? null,
            'endereco' => $organizacao['endereco'] ?? null,
            'descricao' => $organizacao['descricao'] ?? null,
            'logo' => $organizacao['logo'] ?? null,
            'area_atuacao' => $organizacao['area_atuacao'] ?? null,
            'active_campaigns' => $organizacao['active_campaigns'] ?? 0,
            'impact_value' => $organizacao['impact_value'] ?? 'R$ 0,00',
            'campaigns' => $organizacao['campaigns'] ?? []
        ];

        require_once __DIR__ . '/../Views/ong/dashboard.php';
    } */

    /* public function dashboard(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user']) || ($_SESSION['user']['tipo_usuario'] ?? '') !== 'ong') {
            header('Location: /?url=login');
            exit();
        }

        $idUsuario = (int)($_SESSION['user']['id_usuario']);
        // recuperar id_ong parecido com getOngIdByUsuario
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
        SELECT o.id_ong
        FROM usuario_organizacao uo
        JOIN organizacao org ON org.id_organizacao = uo.organizacao_id_organizacao
        JOIN ong o ON o.organizacao_id_organizacao = org.id_organizacao
        WHERE uo.usuario_id_usuario = :usuarioId LIMIT 1
    ");
        $stmt->execute([':usuarioId' => $idUsuario]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        $ongId = $res ? (int)$res['id_ong'] : null;

        $campanhas = [];
        if ($ongId) {
            $campRepo = new CampanhaRepository($pdo);
            $campanhas = $campRepo->findByOng($ongId);
        }

        // possibilita $campanhas na view dashboard
        require_once __DIR__ . '/../Views/ong/dashboard.php';
    } */
    /* public function dashboard(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user']) || ($_SESSION['user']['tipo_usuario'] ?? '') !== 'ong') {
            header('Location: /?url=login');
            exit();
        }

        $user = $_SESSION['user'] ?? null;
        $idUsuario = (int)($user['id_usuario'] ?? 0);
        if ($idUsuario <= 0) {
            header('Location: /?url=login');
            exit();
        }

        // carrega sessão com dados reais se ainda não tiver
        if (empty($_SESSION['ong']) || empty($_SESSION['ong']['id_organizacao'])) {
            $this->loadSessionForUser($idUsuario);
        }

        $ong = $_SESSION['ong'] ?? null;

        // recuperar id_ong (se preciso)
        $ongId = $ong['id_ong'] ?? null;

        $campanhas = [];
        if ($ongId) {
            $pdo = Database::getConnection();
            $campRepo = new CampanhaRepository($pdo);
            $campanhas = $campRepo->findByOng($ongId);
        }

        // passa $ong e $campanhas à view
        require_once __DIR__ . '/../Views/ong/dashboard.php';
    } */
   public function dashboard(): void
{
    if (session_status() === PHP_SESSION_NONE) session_start();

    // proteção por tipo
    if (!isset($_SESSION['user']) || ($_SESSION['user']['tipo_usuario'] ?? '') !== 'ong') {
        header('Location: /?url=login');
        exit();
    }

    $user = $_SESSION['user'] ?? [];
    $idUsuario = (int)($user['id_usuario'] ?? 0);
    $userEmail = $user['email'] ?? null;

    if ($idUsuario <= 0) {
        header('Location: /?url=login');
        exit();
    }

    // buscar organizacao + ong do banco
    $organizacao = $this->repo->getOrganizacaoByUsuario($idUsuario);
    if (!$organizacao) {
        // sem organização vinculada
        require_once __DIR__ . '/../Views/ong/sem_organizacao.php';
        return;
    }

    $ongRow = $this->repo->getOngByOrganizacao((int)$organizacao['id_organizacao']);

    // 🔹 buscar telefone do usuário direto da tabela usuario
    $pdo = Database::getConnection();
    $stmt = $pdo->prepare("SELECT telefone FROM usuario WHERE id_usuario = :id");
    $stmt->execute([':id' => $idUsuario]);
    $telefoneUsuario = $stmt->fetchColumn();

    // montar array $ong com prioridade para campos da tabela ong quando apropriado
    $ong = [
        'id_organizacao' => isset($organizacao['id_organizacao']) ? (int)$organizacao['id_organizacao'] : null,
        'id_ong'         => isset($ongRow['id_ong']) ? (int)$ongRow['id_ong'] : null,
        'cnpj'           => $organizacao['cnpj'] ?? null,
        'razao_social'   => $organizacao['razao_social'] ?? null,
        'nome_fantasia'  => $ongRow['nome_fantasia'] ?? $organizacao['razao_social'] ?? null,
        'email'          => $userEmail ?? $organizacao['email'] ?? ($ongRow['email'] ?? null),
        'telefone'       => $telefoneUsuario ?? null,
        'cep'            => $organizacao['cep'] ?? null,
        'endereco'       => $organizacao['endereco'] ?? ($ongRow['endereco'] ?? null),
        'numero'         => $organizacao['numero'] ?? ($ongRow['numero'] ?? null),
        'cidade'         => $organizacao['cidade'] ?? ($ongRow['cidade'] ?? null),
        'estado'         => $organizacao['estado'] ?? ($ongRow['estado'] ?? null),
        'descricao'      => $ongRow['descricao'] ?? $organizacao['descricao'] ?? null,
        'logo'           => $ongRow['logo'] ?? $organizacao['logo'] ?? null,
        'area_atuacao'   => $ongRow['area_atuacao'] ?? $organizacao['area_atuacao'] ?? null,
    ];

    // opcional: salvar em sessão para uso posterior
    $_SESSION['ong'] = $ong;

    // carregar campanhas da ong (se houver id_ong)
    $campanhas = [];
    if (!empty($ong['id_ong'])) {
        $pdo = Database::getConnection();
        $campRepo = new CampanhaRepository($pdo);
        $campanhas = $campRepo->findByOng((int)$ong['id_ong']);
    }

    // passa $ong e $campanhas para a view
    require_once __DIR__ . '/../Views/ong/dashboard.php';
}
}
