<?php

namespace Controllers;

use Config\Database;
use Repositories\OngRepository;

class OngController
{
    private OngRepository $repo;

    public function __construct()
    {
        $this->repo = new OngRepository(Database::getConnection());
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

        $organizacao = $this->repo->getOrganizacaoByUsuario($idUsuario);
        if (!$organizacao) {
            return false;
        }

        $ong = $this->repo->getOngByOrganizacao((int)$organizacao['id_organizacao']);

        $sessionOng = [
            'id_organizacao'   => $organizacao['id_organizacao'] ?? null,
            'cnpj'             => $organizacao['cnpj'] ?? ($ong['cnpj'] ?? null),
            'razao_social'     => $organizacao['razao_social'] ?? ($ong['razao_social'] ?? null),
            'nome_fantasia'    => $ong['nome_fantasia'] ?? $organizacao['razao_social'] ?? null,
            'telefone'         => $organizacao['telefone'] ?? ($ong['telefone'] ?? null),
            'endereco'         => $organizacao['endereco'] ?? ($ong['endereco'] ?? null),
            'email'            => $organizacao['email'] ?? ($ong['email'] ?? null),
            'descricao'        => $organizacao['descricao'] ?? ($ong['descricao'] ?? null),
            'logo'             => $ong['logo'] ?? ($organizacao['logo'] ?? null),
            'area_atuacao'     => $ong['area_atuacao'] ?? ($organizacao['area_atuacao'] ?? null),

            // mock
            'active_campaigns' => $ong['active_campaigns'] ?? 0,
            'impact_value'     => $ong['impact_value'] ?? 'R$ 0,00',
            'campaigns'        => $ong['campaigns'] ?? [],
        ];

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['ong'] = $sessionOng;
        return true;
    }

    public function dashboard(): void
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
    }
}
