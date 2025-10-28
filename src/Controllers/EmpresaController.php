<?php

namespace Controllers;

use Config\Database;
use Repositories\EmpresaRepository;
use Repositories\DoacaoRepository;
use Repositories\CampanhaRepository;

class EmpresaController
{
    private EmpresaRepository $empresaRepository;

    public function __construct()
    {
        $this->empresaRepository = new EmpresaRepository(Database::getConnection());
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

        // monta arrays conforme formulário
        $orgDados = [
            'razao_social'   => trim($_POST['razao_social'] ?? ''),
            'nome_fantasia'  => trim($_POST['nome_fantasia'] ?? ''),
            'cnpj'           => trim($_POST['cnpj'] ?? ''),
            'cep'            => trim($_POST['cep'] ?? ''),
            'endereco'       => trim($_POST['endereco'] ?? ''),
            'numero'         => trim($_POST['numero'] ?? ''),
            'cidade'         => trim($_POST['cidade'] ?? ''),
            'estado'         => trim($_POST['estado'] ?? '')
        ];

        $userDados = [
            'nome'     => trim($_POST['nome'] ?? ''),
            'email'    => trim($_POST['email'] ?? ''),
            'senha'    => $_POST['senha'] ?? '',
            'telefone' => trim($_POST['telefone'] ?? '')
        ];

        // validações mínimas
        $requiredOrg = [$orgDados['cnpj'], $orgDados['razao_social'], $orgDados['cep']];
        $requiredUser = [$userDados['nome'], $userDados['email'], $userDados['senha']];

        if (in_array('', $requiredOrg, true) || in_array('', $requiredUser, true)) {
            $this->showCreateForm("Preencha todos os campos obrigatórios.");
            return;
        }

        if (!filter_var($userDados['email'], FILTER_VALIDATE_EMAIL)) {
            $this->showCreateForm("E-mail inválido.");
            return;
        }

        // senha confirm
        $senhaConfirm = $_POST['nova_senha'] ?? '';
        if ($userDados['senha'] !== $senhaConfirm) {
            $this->showCreateForm("As senhas não conferem.");
            return;
        }

        // Tenta criar
        try {
            $idOrg = $this->empresaRepository->createEmpresaWithUser($orgDados, $userDados);

            // criação ok — redireciona para login
            header('Location: /?url=login&created=1');
            exit();
        } catch (\Throwable $e) {
            error_log("EmpresaController::store - erro: " . $e->getMessage());
            $this->showCreateForm($e->getMessage());
        }
    }

    /* public function dashboard(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user']) || ($_SESSION['user']['tipo_usuario'] ?? '') !== 'empresa') {
            header('Location: /?url=login');
            exit();
        }

        $userId = (int)($_SESSION['user']['id_usuario'] ?? 0);
        if ($userId <= 0) {
            header('Location: /?url=login');
            exit();
        }

        $organizacao = $this->empresaRepository->getOrganizacaoByUsuario($userId);
        if (!$organizacao) {
            require_once __DIR__ . '/../Views/empresa/sem_organizacao.php';
            return;
        }

        $empresa = $this->empresaRepository->getEmpresaByOrganizacao((int)$organizacao['id_organizacao']);

        $campanhaRepository = new CampanhaRepository(Database::getConnection());
        $campanhasAtivas = $campanhaRepository->findActiveCampaigns();

        $historicoDoacoes = [];
        if (!empty($empresa['id_empresa'])) {
            $doacaoRepository = new DoacaoRepository(Database::getConnection());
            try {
                $historicoDoacoes = $doacaoRepository->getHistoricoPorEmpresa((int)$empresa['id_empresa']);
            } catch (\Throwable $e) {
                error_log("EmpresaController::dashboard - erro ao buscar historicoDoacoes: " . $e->getMessage());
                $historicoDoacoes = [];
            }
        }

        require_once __DIR__ . '/../Views/empresa/dashboard.php';
    } */

    public function dashboard(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user']) || ($_SESSION['user']['tipo_usuario'] ?? '') !== 'empresa') {
            header('Location: /?url=login');
            exit();
        }

        $userId = (int)($_SESSION['user']['id_usuario'] ?? 0);
        if ($userId <= 0) {
            header('Location: /?url=login');
            exit();
        }

        try {
            $pdo = \Config\Database::getConnection();
            $stmt = $pdo->prepare('SELECT telefone, endereco FROM usuario WHERE id_usuario = :id LIMIT 1');
            $stmt->execute([':id' => $userId]);
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);
            if ($row) {
                if (session_status() === PHP_SESSION_NONE) session_start();

                if (!empty($row['telefone'])) {
                    $_SESSION['user']['telefone'] = $row['telefone'];
                } elseif (!isset($_SESSION['user']['telefone'])) {
                    $_SESSION['user']['telefone'] = null;
                }

                if (!empty($row['endereco'])) {
                    $_SESSION['user']['endereco'] = $row['endereco'];
                } elseif (!isset($_SESSION['user']['endereco'])) {
                    $_SESSION['user']['endereco'] = null;
                }
            }
        } catch (\Throwable $e) {
            error_log("EmpresaController::dashboard - erro ao obter telefone/endereco do usuário: " . $e->getMessage());
        }

        $organizacao = $this->empresaRepository->getOrganizacaoByUsuario($userId);
        if (!$organizacao) {
            require_once __DIR__ . '/../Views/empresa/sem_organizacao.php';
            return;
        }

        $empresa = $this->empresaRepository->getEmpresaByOrganizacao((int)$organizacao['id_organizacao']);

        $campanhaRepository = new CampanhaRepository(Database::getConnection());
        $campanhasAtivas = $campanhaRepository->findActiveCampaigns();

        $historicoDoacoes = [];
        if (!empty($empresa['id_empresa'])) {
            $doacaoRepository = new DoacaoRepository(Database::getConnection());
            try {
                $historicoDoacoes = $doacaoRepository->getHistoricoPorEmpresa((int)$empresa['id_empresa']);
            } catch (\Throwable $e) {
                error_log("EmpresaController::dashboard - erro ao buscar historicoDoacoes: " . $e->getMessage());
                $historicoDoacoes = [];
            }
        }

        require_once __DIR__ . '/../Views/empresa/dashboard.php';
    }
}
