<?php

namespace Controllers;

use Config\Database;
use Repositories\EmpresaRepository;

class EmpresaController
{
    private EmpresaRepository $repo;

    public function __construct()
    {
        $this->repo = new EmpresaRepository(Database::getConnection());
    }

    public function showCreateForm(?string $error = null): void
    {
        require_once __DIR__ . '/../Views/empresa/create.php';
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
            'nome_fantasia' => trim($_POST['nome_fantasia'] ?? '')
        ];

        $userDados = [
            'nome' => trim($_POST['responsavel_nome'] ?? ''),
            'email' => trim($_POST['responsavel_email'] ?? ''),
            'senha_plain' => $_POST['responsavel_senha'] ?? '',
            'telefone' => trim($_POST['telefone'] ?? ''),
            'endereco' => trim($_POST['endereco'] ?? '')
        ];

        if ($orgDados['cnpj'] === '' || $userDados['nome'] === '' || $userDados['email'] === '' || $userDados['senha_plain'] === '') {
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
            $idOrg = $this->repo->createEmpresaWithUser($orgDados, $userDados);

            header('Location: /?url=login&created=1');
            exit();
        } catch (\Throwable $e) {
            $this->showCreateForm($e->getMessage());
        }
    }

    public function dashboard(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user'])) {
            header('Location: /?url=login');
            exit();
        }

        $idUsuario = (int)($_SESSION['user']['id_usuario'] ?? 0);
        if ($idUsuario <= 0) {
            header('Location: /?url=login');
            exit();
        }

        $organizacao = $this->repo->getOrganizacaoByUsuario($idUsuario);
        if (!$organizacao) {
            $error = "Nenhuma organização vinculada ao seu usuário.";
            require_once __DIR__ . '/../Views/empresa/sem_organizacao.php';
            return;
        }

        $empresa = $this->repo->getEmpresaByOrganizacao((int)$organizacao['id_organizacao']);

        require_once __DIR__ . '/../Views/empresa/dashboard.php';
    }
}
