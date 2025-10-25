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
            $idOrg = $this->empresaRepository->createEmpresaWithUser($orgDados, $userDados);

            header('Location: /?url=login&created=1');
            exit();
        } catch (\Throwable $e) {
            $this->showCreateForm($e->getMessage());
        }
    }

    /* public function dashboard(): void
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
    } */
    /*     public function dashboard(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // proteção: redireciona se não for empresa
        if (!isset($_SESSION['user']) || ($_SESSION['user']['tipo_usuario'] ?? '') !== 'empresa') {
            header('Location: /?url=login');
            exit();
        }

        $campRepo = new \Repositories\CampanhaRepository(\Config\Database::getConnection());
        $campanhasAtivas = $campRepo->findActiveCampaigns();

        // passe $campanhasAtivas para a view
        require_once __DIR__ . '/../Views/empresa/dashboard.php';
    } */

    public function dashboard(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // proteção simples por tipo
        if (!isset($_SESSION['user']) || ($_SESSION['user']['tipo_usuario'] ?? '') !== 'empresa') {
            header('Location: /?url=login');
            exit();
        }

        // tentar extrair o id do usuário por várias chaves comuns
        $user = $_SESSION['user'] ?? [];
        $possibleKeys = ['id_usuario', 'id', 'usuario_id', 'idUser', 'user_id'];
        $userId = 0;
        foreach ($possibleKeys as $k) {
            if (!empty($user[$k]) && is_numeric($user[$k])) {
                $userId = (int)$user[$k];
                break;
            }
        }

        // log para debug (remova depois)
        error_log("EmpresaController::dashboard - user session keys: " . json_encode(array_keys($user)));
        error_log("EmpresaController::dashboard - resolved userId={$userId}");

        if ($userId <= 0) {
            // fallback: talvez a sessão já contenha organizacao/empresa diretamente
            if (!empty($user['organizacao_id']) || !empty($user['organizacao'])) {
                // tente usar dados da sessão (se existirem)
                // (aqui tentamos popular $organizacao/$empresa para não quebrar a view)
                $organizacao = $user['organizacao'] ?? ['id_organizacao' => (int)($user['organizacao_id'] ?? 0)];
            } else {
                // não temos id de usuário nem organização: volta pro login
                error_log("EmpresaController::dashboard - nenhum userId ou organização encontrado na sessão, redirecionando para login.");
                header('Location: /?url=login');
                exit();
            }
        } else {
            // pega organizacao via repository
            $organizacao = $this->empresaRepository->getOrganizacaoByUsuario($userId);
            if (!$organizacao) {
                // sem organização vinculada
                require_once __DIR__ . '/../Views/empresa/sem_organizacao.php';
                return;
            }
        }

        // pega empresa a partir da organização (se possível)
        $empresa = $this->empresaRepository->getEmpresaByOrganizacao((int)($organizacao['id_organizacao'] ?? 0));
        $empresaId = (int)($empresa['id_empresa'] ?? 0);

        // campanhas ativas
        $campRepo = new CampanhaRepository(Database::getConnection());
        $campanhasAtivas = $campRepo->findActiveCampaigns();

        // histórico de doações (se tivermos empresaId)
        $historicoDoacoes = [];
        if ($empresaId > 0) {
            $doacoesRepo = new DoacaoRepository(Database::getConnection());
            try {
                $historicoDoacoes = $doacoesRepo->getHistoricoPorEmpresa($empresaId);
            } catch (\Throwable $e) {
                error_log("EmpresaController::dashboard - erro ao buscar historicoDoacoes: " . $e->getMessage());
                $historicoDoacoes = [];
            }
        }

        // inclui a view (ela espera $organizacao, $empresa, $campanhasAtivas, $historicoDoacoes)
        require_once __DIR__ . '/../Views/empresa/dashboard.php';
    }
}
