<?php

declare(strict_types=1);

namespace Controllers;

use Config\Database;
use Repositories\DoacaoRepository;
use Repositories\CampanhaRepository;
use PDO;

class DoacaoController
{
    private PDO $pdo;
    private DoacaoRepository $doacaoRepository;
    private CampanhaRepository $campanhaRepository;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
        $this->doacaoRepository = new DoacaoRepository($this->pdo);
        $this->campanhaRepository = new CampanhaRepository($this->pdo);
    }

    private function ensureEmpresaOrRedirect(): ?int
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user']) || ($_SESSION['user']['tipo_usuario'] ?? '') !== 'empresa') {
            // redireciona para login se não autentificado como empresa
            header('Location: /?url=login');
            exit();
        }

        $usuarioId = (int)($_SESSION['user']['id_usuario'] ?? 0);
        // busca id_empresa vinculado ao usuário
        $stmt = $this->pdo->prepare("
            SELECT e.id_empresa
            FROM usuario_organizacao uo
            JOIN organizacao org ON org.id_organizacao = uo.organizacao_id_organizacao
            JOIN empresa e ON e.organizacao_id_organizacao = org.id_organizacao
            WHERE uo.usuario_id_usuario = :usuarioId
            LIMIT 1
        ");
        $stmt->execute([':usuarioId' => $usuarioId]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ? (int)$res['id_empresa'] : null;
    }

    // Exibe a página de doação (GET ?campanha_id=XX)
    public function create(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $campanhaId = (int)($_GET['campanha_id'] ?? 0);
        if ($campanhaId <= 0) {
            header('Location: /?url=home');
            exit();
        }

        $campanha = $this->campanhaRepository->findById($campanhaId);
        if (!$campanha) {
            $_SESSION['form_errors'] = ['Campanha não encontrada.'];
            header('Location: /?url=home');
            exit();
        }

        // requer empresa logada — create view irá redirecionar se não
        require_once __DIR__ . '/../Views/doacao/create.php';
    }

    // Processa o POST do formulário de doação
    /* public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /?url=home');
            exit();
        }

        if (session_status() === PHP_SESSION_NONE) session_start();

        // só empresas podem doar
        $empresaId = $this->ensureEmpresaOrRedirect();
        if ($empresaId === null) {
            $_SESSION['form_errors'] = ['Usuário não vinculado a nenhuma empresa.'];
            header('Location: /?url=home');
            exit();
        }

        $campanhaId = (int)($_POST['campanha_id'] ?? 0);
        $valor = (float)($_POST['valor'] ?? 0);
        $forma = trim((string)($_POST['forma_pagamento'] ?? 'pix'));

        $errors = [];
        if ($campanhaId <= 0) $errors[] = "Campanha inválida.";
        if ($valor <= 0) $errors[] = "Valor da doação deve ser maior que zero.";
        $allowed = ['cartao','pix','boleto','transferencia','outro'];
        if (!in_array($forma, $allowed, true)) $errors[] = "Forma de pagamento inválida.";

        $campanha = $this->campRepo->findById($campanhaId);
        if (!$campanha) $errors[] = "Campanha não encontrada.";
        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            header('Location: /?url=doacao/create&campanha_id=' . $campanhaId);
            exit();
        }

        try {
            // transação: inserir doação + pagamento + atualizar campanha
            $this->pdo->beginTransaction();

            // 1) criar doação (aqui já marcamos como 'confirmado' para demo)
            $doacaoId = $this->doacaoRepo->createDoacaoConfirmed([
                'valor' => $valor,
                'empresa_id' => $empresaId,
                'forma_pagamento' => $forma,
                'status' => 'confirmado',
                'campanha_id' => $campanhaId,
            ]);

            // 2) criar registro em pagamento (simples)
            $stmt = $this->pdo->prepare('INSERT INTO pagamento (tipo, valor, status, data_pagamento, codigo_transacao, doacao_id_doacao) VALUES (:tipo, :valor, :status, NOW(), :codigo, :doacao_id)');
            $stmt->execute([
                ':tipo' => $forma,
                ':valor' => $valor,
                ':status' => 'aprovado',
                ':codigo' => null,
                ':doacao_id' => $doacaoId,
            ]);

            // 3) atualizar campanha.valor_arrecadado
            $stmt = $this->pdo->prepare('UPDATE campanha SET valor_arrecadado = COALESCE(valor_arrecadado,0) + :valor WHERE id_campanha = :id');
            $stmt->execute([':valor' => $valor, ':id' => $campanhaId]);

            $this->pdo->commit();

            $_SESSION['success_message'] = "Doação realizada com sucesso. Obrigado pelo apoio!";
            header('Location: /?url=empresa'); // redireciona para painel da empresa (ajuste se preferir)
            exit();

        } catch (\Throwable $e) {
            if ($this->pdo->inTransaction()) $this->pdo->rollBack();
            $_SESSION['form_errors'] = ['Erro ao processar doação. Tente novamente mais tarde.'];
            header('Location: /?url=doacao/create&campanha_id=' . $campanhaId);
            exit();
        }
    } */

    /* public function store(): void
    {
        // logs para debug — remova depois
        if (session_status() === PHP_SESSION_NONE) session_start();
        error_log("DOACAO::store - START - session_id=" . session_id());
        error_log("DOACAO::store - COOKIE PHPSESSID=" . ($_COOKIE['PHPSESSID'] ?? 'NULL'));
        error_log("DOACAO::store - SERVER REQUEST_METHOD=" . ($_SERVER['REQUEST_METHOD'] ?? 'NULL'));
        error_log("DOACAO::store - RAW POST: " . json_encode($_POST));

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            error_log("DOACAO::store - Request method not POST, redirect home");
            header('Location: /?url=home');
            exit();
        }

        // NÃO destrua a sessão aqui — apenas garanta que o usuário é empresa
        $empresaId = $this->ensureEmpresaOrRedirect(); // mantenha a função que redireciona pra login
        error_log("DOACAO::store - empresaId resolved: " . var_export($empresaId, true));

        $campanhaId = (int)($_POST['campanha_id'] ?? 0);
        $valor = (float)($_POST['valor'] ?? 0);
        $forma = trim((string)($_POST['forma_pagamento'] ?? 'pix'));

        error_log("DOACAO::store - dados parsed campanhaId={$campanhaId} valor={$valor} forma={$forma}");

        // validação simples
        $errors = [];
        if ($campanhaId <= 0) $errors[] = "Campanha inválida.";
        if ($valor <= 0) $errors[] = "Valor da doação deve ser maior que zero.";
        $allowed = ['cartao', 'pix', 'boleto', 'transferencia', 'outro'];
        if (!in_array($forma, $allowed, true)) $errors[] = "Forma de pagamento inválida.";

        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            error_log("DOACAO::store - validation errors: " . json_encode($errors));
            header('Location: /?url=doacao/create&campanha_id=' . $campanhaId);
            exit();
        }

        // Continue com sua lógica normal (transação etc). Exemplo de commit mínimo:
        try {
            $this->pdo->beginTransaction();

            $doacaoId = $this->doacaoRepo->createDoacaoConfirmed([
                'valor' => $valor,
                'empresa_id' => $empresaId,
                'forma_pagamento' => $forma,
                'status' => 'confirmado',
                'campanha_id' => $campanhaId,
            ]);

            // marca pagamento aprovado
            $stmt = $this->pdo->prepare('INSERT INTO pagamento (tipo, valor, status, data_pagamento, codigo_transacao, doacao_id_doacao) VALUES (:tipo, :valor, :status, NOW(), :codigo, :doacao_id)');
            $stmt->execute([
                ':tipo' => $forma,
                ':valor' => $valor,
                ':status' => 'aprovado',
                ':codigo' => null,
                ':doacao_id' => $doacaoId,
            ]);

            // atualiza campanha
            $stmt2 = $this->pdo->prepare('UPDATE campanha SET valor_arrecadado = COALESCE(valor_arrecadado,0) + :valor WHERE id_campanha = :id');
            $stmt2->execute([':valor' => $valor, ':id' => $campanhaId]);

            $this->pdo->commit();

            $_SESSION['success_message'] = "Doação realizada com sucesso. Obrigado!";
            error_log("DOACAO::store - success, doacaoId={$doacaoId}");
            header('Location: /?url=empresa');
            exit();
        } catch (\Throwable $e) {
            if ($this->pdo->inTransaction()) $this->pdo->rollBack();
            error_log("DOACAO::store - ERRO: " . $e->getMessage());
            $_SESSION['form_errors'] = ['Erro ao processar doação.'];
            header('Location: /?url=doacao/create&campanha_id=' . $campanhaId);
            exit();
        }
    } */

    public function store(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // logs básicos
        error_log("DOACAO::store - START - session_id=" . session_id());
        error_log("DOACAO::store - RAW POST: " . json_encode($_POST));

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['form_errors'] = ['Requisição inválida.'];
            header('Location: /?url=home');
            exit();
        }

        // garante que é empresa autenticada
        $empresaId = $this->ensureEmpresaOrRedirect();
        if ($empresaId === null) {
            // usuário é 'empresa' mas não está vinculado a um registro empresa -> erro claro
            $_SESSION['form_errors'] = ['Conta de empresa não vinculada. Verifique seu perfil ou contate o suporte.'];
            header('Location: /?url=empresa');
            exit();
        }

        $campanhaId = (int)($_POST['campanha_id'] ?? 0);
        $valor = (float)($_POST['valor'] ?? 0);
        $forma = trim((string)($_POST['forma_pagamento'] ?? 'pix'));

        $errors = [];
        if ($campanhaId <= 0) $errors[] = "Campanha inválida.";
        if ($valor <= 0) $errors[] = "Valor da doação deve ser maior que zero.";
        $allowed = ['cartao', 'pix', 'boleto', 'transferencia', 'outro'];
        if (!in_array($forma, $allowed, true)) $errors[] = "Forma de pagamento inválida.";

        // checa existência da campanha
        $campanha = $this->campanhaRepository->findById($campanhaId);
        if (!$campanha) $errors[] = "Campanha não encontrada.";

        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            header('Location: /?url=doacao/create&campanha_id=' . $campanhaId);
            exit();
        }

        try {
            $this->pdo->beginTransaction();

            // cria doação
            $doacaoId = $this->doacaoRepository->createDoacaoConfirmed([
                'valor' => $valor,
                'empresa_id' => $empresaId,
                'forma_pagamento' => $forma,
                'status' => 'confirmado',
                'campanha_id' => $campanhaId,
            ]);

            // cria pagamento
            $pagamentoTipo = in_array($forma, ['pix', 'boleto'], true) ? $forma : 'outro';
            $stmt = $this->pdo->prepare('INSERT INTO pagamento (tipo, valor, status, data_pagamento, codigo_transacao, doacao_id_doacao) VALUES (:tipo, :valor, :status, NOW(), :codigo, :doacao_id)');
            $stmt->execute([
                ':tipo' => $pagamentoTipo,
                ':valor' => $valor,
                ':status' => 'aprovado',
                ':codigo' => null,
                ':doacao_id' => $doacaoId,
            ]);

            // atualiza campanha.valor_arrecadado
            $stmt2 = $this->pdo->prepare('UPDATE campanha SET valor_arrecadado = COALESCE(valor_arrecadado,0) + :valor WHERE id_campanha = :id');
            $stmt2->execute([':valor' => $valor, ':id' => $campanhaId]);

            $this->pdo->commit();

            $_SESSION['success_message'] = "Doação realizada com sucesso. Obrigado!";
            header('Location: /?url=empresa');
            exit();
        } catch (\Throwable $e) {
            if ($this->pdo->inTransaction()) $this->pdo->rollBack();

            // log completo para o console de logs do PHP
            error_log("DOACAO::store - EXCEPTION: " . $e->getMessage());
            error_log("DOACAO::store - TRACE: " . $e->getTraceAsString());

            // para debug em dev: mostra a msg de erro na tela (remova em produção)
            $_SESSION['form_errors'] = ['Erro ao processar doação: ' . $e->getMessage()];

            header('Location: /?url=doacao/create&campanha_id=' . $campanhaId);
            exit();
        }
    }
}
