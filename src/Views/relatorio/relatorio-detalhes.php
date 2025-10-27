<?php
session_start();

require_once __DIR__ . '/../../../src/Config/Database.php';

use Config\Database;

// ✅ Conexão única — não precisa reconectar mais tarde
try {
    $pdo = Database::getConnection();
} catch (PDOException $e) {
    die("<p class='text-center text-danger mt-5'>Erro de conexão: " . htmlspecialchars($e->getMessage()) . "</p>");
}

// ====== Carregar campanhas relacionadas à ONG do usuário ======
$campanhas = [];

try {
    // 1) Se há ONG na sessão
    if (!empty($_SESSION['ong']['id_ong'] = 2)) {
        $ongId = (int) $_SESSION['ong']['id_ong'];

        $stmt = $pdo->prepare("
            SELECT id_campanha, titulo
            FROM campanha
            WHERE ong_id_ong = ?
            ORDER BY data_criacao DESC
        ");
        $stmt->execute([$ongId]);
        $campanhas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 2) Se há usuário logado, buscar campanhas pelas ONGs ligadas a ele
    } elseif (!empty($_SESSION['user']['id_usuario'])) {
        $userId = (int) $_SESSION['user']['id_usuario'];

        $stmt = $pdo->prepare("
            SELECT DISTINCT c.id_campanha, c.titulo
            FROM campanha c
            JOIN ong o ON c.ong_id_ong = o.id_ong
            JOIN organizacao org ON o.organizacao_id_organizacao = org.id_organizacao
            JOIN usuario_organizacao uo ON uo.organizacao_id_organizacao = org.id_organizacao
            WHERE uo.usuario_id_usuario = ?
            ORDER BY c.data_criacao DESC
        ");
        $stmt->execute([$userId]);
        $campanhas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 3) Nenhuma campanha encontrada
    if (empty($campanhas)) {
        die("<p class='text-center text-danger mt-5'>Nenhuma campanha disponível para gerar relatório.</p>");
    }

    // ✅ Usa o ID via GET ou, se não houver, a primeira campanha da lista
    $idCampanha = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?: (int)$campanhas[0]['id_campanha'];

    // === CONSULTAS PRINCIPAIS ===

    // 1️⃣ Dados da campanha
    $stmtCampanha = $pdo->prepare("
        SELECT 
            c.id_campanha,
            c.titulo,
            c.descricao,
            c.objetivo,
            c.meta,
            c.valor_arrecadado,
            c.impacto_esperado,
            c.impacto_alcancado,
            c.numero_curtidas,
            c.status,
            c.localizacao,
            c.data_criacao,
            c.data_encerramento,
            cat.nome AS categoria_nome,
            o.area_atuacao
        FROM campanha c
        LEFT JOIN categoria cat ON c.categoria_id_categoria = cat.id_categoria
        LEFT JOIN ong o ON c.ong_id_ong = o.id_ong
        WHERE c.id_campanha = ?
        LIMIT 1
    ");
    $stmtCampanha->execute([$idCampanha]);
    $campanha = $stmtCampanha->fetch(PDO::FETCH_ASSOC);

    if (!$campanha) {
        throw new Exception("Campanha não encontrada.");
    }

    // 2️⃣ Estatísticas das doações
    $stmtStats = $pdo->prepare("
        SELECT 
            IFNULL(SUM(valor), 0) AS total_arrecadado,
            COUNT(*) AS total_doacoes,
            IFNULL(AVG(valor), 0) AS media_doacao
        FROM doacao
        WHERE campanha_id_campanha = ?
        AND status = 'confirmado'
    ");
    $stmtStats->execute([$idCampanha]);
    $stats = $stmtStats->fetch(PDO::FETCH_ASSOC);

    // 3️⃣ Lista de doadores
    $stmtDoadores = $pdo->prepare("
        SELECT 
            e.nome_fantasia AS nome,
            d.valor,
            d.data_doacao AS data,
            d.forma_pagamento AS metodo
        FROM doacao d
        INNER JOIN empresa e ON d.empresa_id_empresa = e.id_empresa
        WHERE d.campanha_id_campanha = ?
        AND d.status = 'confirmado'
        ORDER BY d.valor DESC
    ");
    $stmtDoadores->execute([$idCampanha]);
    $doadores = $stmtDoadores->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    // ⚠️ Sempre escapar mensagens de erro
    die("<p class='text-center text-danger mt-5'>Erro: " . htmlspecialchars($e->getMessage()) . "</p>");
}
?>

<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Relatório - ConectaVidas+</title>

    <!-- Bootstrap e ícones -->
    <link rel="stylesheet" href="../../../public/css/global.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <style>
        .card-body canvas {
            min-height: 250px;
            max-height: 350px;
            width: 100% !important;
            height: auto !important;
        }

        .transition-shadow {
            transition: all 0.2s ease-in-out;
        }

        .transition-shadow:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.2) !important;
            transform: translateY(-2px);
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-body text-body" style="min-height: 100vh; display: flex; flex-direction: column;">
     <div class="container">

        <!-- HEADER DESKTOP -->
        <header class="main-header">
            <div class="d-none d-md-flex container-fluid justify-content-between align-items-center py-2 px-4 border-bottom bg-body fixed-top shadow-sm">
                <a href="#" class="text-decoration-none text-body">
                    <span style="color:var(--primary);" class="fw-bold fs-1">ConectaVidas+</span>
                </a>

                <nav class="d-flex align-items-center gap-4">
                    <a href="#explorar" class="text-body text-decoration-none fw-semibold fs-5">Inicio</a>
                    <a href="#sobre" class="text-body text-decoration-none fw-semibold fs-5">Campanhas</a>
                    <a href="#como" class="text-body text-decoration-none fw-semibold fs-5">Empresas</a>

                    <button class="theme-toggle btn btn-outline-secondary fs-5" title="Alternar Tema" type="button">
                        <i class="bi bi-moon-fill"></i>
                    </button>

                    <div class="dropdown" data-bs-theme="light">
                        <a href="#" class="btn btn-outline-primary dropdown-toggle fw-semibold fs-5" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                            <span class="me-2 fw-bold fs-5" id="navOngNameText">
                                <?= htmlspecialchars($ong['nome_fantasia'] ?? 'Nome da ONG') ?>
                            </span>
                            <i></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end fs-5">
                            <li><a class="dropdown-item" href="#">Perfil</a></li>
                            <li><a class="dropdown-item" href="#">Configurações</a></li>
                            <li><a class="dropdown-item" href="#">Relatórios</a></li>
                             <li><a class="dropdown-item" href="#">Historico</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li><a class="dropdown-item text-danger" href="#">Sair</a></li>
                        </ul>
                    </div>
                </nav>
            </div>

            <!-- HEADER MOBILE -->
            <nav class="navbar navbar-expand-lg bg-body border-bottom fixed-top shadow-sm d-md-none">
                <div class="container-fluid">
                    <a style="color:var(--primary);" class="navbar-brand fw-bold fs-3" href="#">ConectaVidas+</a>
                    
                  
                    <div class="d-flex align-items-center gap-2">
                        <!-- Ícone Home -->
                        <a href="/" class="btn btn-link text-body px-2">
                            <i class="bi bi-house-door fs-4"></i>
                        </a>
                        
                        <button
                            class="navbar-toggler"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#navbarMobile"
                            aria-controls="navbarMobile"
                            aria-expanded="false"
                            aria-label="Alternar navegação">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>

                    <div class="collapse navbar-collapse" id="navbarMobile">
                        <ul class="navbar-nav ms-auto text-center">
                            <!-- Botão de Tema no Mobile -->
                            <li class="nav-item mt-2">
                                <button
                                    class="theme-toggle btn btn-outline-secondary w-100"
                                    title="Alternar Tema"
                                    type="button">
                                    <i class="bi bi-moon-fill"></i> Modo
                                </button>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Perfil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Configurações</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Relatórios</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Histórico</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-danger" href="#">Sair</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
    </div>

    <main class="container my-5 pt-5 flex-grow-1">
    <h1 class="fw-bolder mt-5 mb-4 text-center text-secondary">Relatório da Campanha</h1>

    <!-- Escolher campanha -->
    <form method="get" class="mb-5 d-flex flex-column align-items-center">
        <div class="text-center mb-3">
            <h5 class="fw-semibold text-secondary mb-1">Escolha a campanha que deseja visualizar</h5>
            <p class="text-muted mb-0">Selecione uma campanha abaixo para gerar o relatório correspondente.</p>
        </div>

        <div class="d-flex justify-content-center" style="min-width:300px;">
            <label for="campanhaSelect" class="form-label visually-hidden">Escolher Campanha</label>
            <select id="campanhaSelect" name="id" class="form-select shadow-sm" onchange="this.form.submit()">
                <?php foreach ($campanhas as $c): ?>
                    <option value="<?= (int)$c['id_campanha']; ?>" <?= ((int)$c['id_campanha'] === (int)$idCampanha) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($c['titulo']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <noscript>
            <button type="submit" class="btn btn-primary mt-3">Carregar</button>
        </noscript>
    </form>

    <!-- Métricas  -->
    <div class="mb-5">
    
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3 text-center text-md-start">
            <h2 class="h3 fw-bold border-bottom pb-2 text-primary mb-0 w-100 w-md-auto">
                Resumo das Doações
            </h2>

            <!-- Botão Voltar ao Painel -->
            <a href="#" class="btn btn-outline-secondary shadow-sm d-inline-flex align-items-center">
                <i class="bi bi-arrow-left me-2 fs-5"></i> Voltar ao Painel
            </a>
        </div>

        <div class="row g-4 mb-4">
            <!-- Card 1: Total Arrecadado -->
            <div class="col-12 col-md-4">
                <div class="card shadow border-start border-5 border-success h-100 transition-shadow">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-uppercase text-muted small mb-1">Total Arrecadado</p>
                                <h3 class="fw-bolder mb-0 text-success">
                                    R$ <?php echo number_format($stats['total_arrecadado'], 2, ',', '.'); ?>
                                </h3>
                            </div>
                            <i class="bi bi-currency-dollar display-6 text-success opacity-75"></i>
                        </div>
                        <p class="mt-3 text-muted small mb-0">Valor total de todas as doações monetárias.</p>
                    </div>
                </div>
            </div>

            <!-- Card 2: Total de Doações -->
            <div class="col-12 col-md-4">
                <div class="card shadow border-start border-5 border-info h-100 transition-shadow">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-uppercase text-muted small mb-1">Total de Doações</p>
                                <h3 class="fw-bolder mb-0 text-info">
                                    <?php echo $stats['total_doacoes']; ?>
                                </h3>
                            </div>
                            <i class="bi bi-heart-fill display-6 text-info opacity-75"></i>
                        </div>
                        <p class="mt-3 text-muted small mb-0">Número total de transações/contribuições realizadas.</p>
                    </div>
                </div>
            </div>

                <!-- Card 3: Média por Doação -->
                <div class="col-12 col-md-4">
                    <div class="card shadow border-start border-5 border-warning h-100 transition-shadow">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-uppercase text-muted small mb-1">Média por Doação</p>
                                    <h3 class="fw-bolder mb-0 text-warning">
                                        R$ <?php echo number_format($stats['media_doacao'], 2, ',', '.'); ?>
                                    </h3>
                                </div>
                                <i class="bi bi-graph-up display-6 text-warning opacity-75"></i>
                            </div>
                            <p class="mt-3 text-muted small mb-0">Valor médio por transação de doação.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mensagem placeholder removida da div grid de métricas -->
        </div>


        <!-- Informações Gerais da Campanha -->
        <div class="card shadow mb-5 bg-body-tertiary border-0 rounded-4">
            <div class="card-body p-4 p-md-5">
                <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap">
                    <h4 class="fw-bold text-primary mb-3 mb-sm-0">
                        Detalhes da Campanha: <?php echo htmlspecialchars($campanha['titulo'] ?? ''); ?>
                    </h4>
                    <button id="btnBaixarPDF" class="btn btn-primary btn-lg shadow-sm">
                        <i class="bi bi-file-earmark-pdf-fill me-2"></i> Baixar Relatório PDF
                    </button>
                </div>

                <div class="row g-3">
                    <div class="col-12">
                        <p class="mb-1"><strong>Descrição:</strong></p>
                        <p class="text-muted border-start border-primary ps-3">
                            <?php echo htmlspecialchars($campanha['descricao'] ?? 'Nenhuma descrição detalhada fornecida.'); ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Objetivo:</strong></p>
                        <p class="text-info fw-semibold">
                            <?php echo htmlspecialchars($campanha['objetivo'] ?? 'Não especificado.'); ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Período:</strong></p>
                        <p class="text-muted">
                            <?php
                            echo date('d/m/Y', strtotime($campanha['data_criacao']));
                            echo ' - ';
                            echo $campanha['data_encerramento'] ? date('d/m/Y', strtotime($campanha['data_encerramento'])) : 'Em andamento';
                            ?>
                        </p>
                    </div>
                </div>

                <!-- NOVO BLOCO PARA INFORMAÇÕES ADICIONAIS -->
                <hr class="my-4 border-primary opacity-50">

                <div class="row g-3">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Impacto Esperado:</strong></p>
                        <p class="text-muted">
                            <?php echo htmlspecialchars($campanha['impacto_esperado'] ?? 'Não informado.'); ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Impacto Alcançado:</strong></p>
                        <p class="text-muted">
                            <?php echo htmlspecialchars($campanha['impacto_alcancado'] ?? 'Ainda não medido.'); ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Status da Campanha:</strong></p>
                        <p class="text-muted fw-semibold">
                            <?php echo htmlspecialchars(ucfirst($campanha['status'] ?? 'Desconhecido')); ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Localização:</strong></p>
                        <p class="text-muted">
                            <?php echo htmlspecialchars($campanha['localizacao'] ?? 'Global'); ?>
                        </p>
                    </div>
                </div>
                <!-- FIM DO NOVO BLOCO -->
            </div>
        </div>

        <!-- Gráficos -->
        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="card shadow-sm bg-body h-100 border-0 rounded-4">
                    <div class="card-header bg-primary text-white fw-bold fs-5 rounded-top-4">
                        Arrecadação Histórica
                    </div>
                    <div class="card-body">
                        <canvas id="graficoArrecadacao"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm bg-body h-100 border-0 rounded-4">
                    <div class="card-header bg-primary text-white fw-bold fs-5 rounded-top-4">
                        Distribuição de Recursos
                    </div>
                    <div class="card-body">
                        <canvas id="graficoDistribuicao"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estatísticas Detalhadas -->
        <div class="row g-4 mb-5">
            <div class="col-md-3 col-6">
                <div class="card text-center shadow-sm bg-body rounded-4 transition-shadow">
                    <div class="card-body py-4">
                        <h6 class="text-muted mb-1">Meta</h6>
                        <h3 class="fw-bolder text-primary mb-0">
                            R$ <?php echo number_format($campanha['meta'] ?? 0, 2, ',', '.'); ?>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card text-center shadow-sm bg-body rounded-4 transition-shadow">
                    <div class="card-body py-4">
                        <h6 class="text-muted mb-1">Arrecadado</h6>
                        <h3 class="fw-bolder text-success mb-0">
                            R$ <?php echo number_format($stats['total_arrecadado'], 2, ',', '.'); ?>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card text-center shadow-sm bg-body rounded-4 transition-shadow">
                    <div class="card-body py-4">
                        <h6 class="text-muted mb-1">Curtidas</h6>
                        <h3 class="fw-bolder text-danger mb-0">
                            <i class="bi bi-heart me-1"></i><?php echo $campanha['numero_curtidas'] ?? 0; ?>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card text-center shadow-sm bg-body rounded-4 transition-shadow">
                    <div class="card-body py-4">
                        <h6 class="text-muted mb-1">Área de Atuação</h6>
                        <h3 class="fw-bolder text-warning mb-0">
                            <?php echo htmlspecialchars($campanha['area_atuacao'] ?? 'N/A'); ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabela de Doadores -->
        <div class="card shadow-lg mb-5 bg-body border-0 rounded-4">
            <div class="card-header bg-primary text-white fw-bold fs-5 rounded-top-4">
                <i class="bi bi-table me-2"></i> Lista de Doadores Confirmados
            </div>
            <div class="card-body p-4">
                <div class="row mb-4 g-3">
                    <div class="col-md-4">
                        <input type="text" id="filtroNome" class="form-control form-control-lg rounded-pill" placeholder="Filtrar por nome do doador" />
                    </div>
                    <div class="col-md-4">
                        <select id="filtroMetodo" class="form-select form-select-lg rounded-pill">
                            <option value="">Todos métodos de pagamento</option>
                            <option value="pix">Pix</option>
                            <option value="cartao">Cartão</option>
                            <option value="boleto">Boleto</option>
                            <option value="transferencia">Transferência</option>
                            <option value="outro">Outro</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select id="filtroLimite" class="form-select form-select-lg rounded-pill" title="Limite de doadores a exibir, ordenado por valor.">
                            <option value="0">Todos Doadores</option>
                            <option value="5">Top 5 Doadores</option>
                            <option value="10">Top 10 Doadores</option>
                            <option value="20">Top 20 Doadores</option>
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0 border rounded-3" id="tabelaDoadores">
                        <thead class="table-light">
                            <tr>
                                <th>Nome</th>
                                <th>Valor Doado</th>
                                <th>Data</th>
                                <th>Método</th>
                            </tr>
                        </thead>
                        <tbody id="corpoTabela">
                            <?php foreach ($doadores as $doador): ?>
                                <tr class="transition-shadow">
                                    <td class="fw-semibold"><?php echo htmlspecialchars($doador['nome']); ?></td>
                                    <td class="fw-bold text-success">R$ <?php echo number_format($doador['valor'], 2, ',', '.'); ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($doador['data'])); ?></td>
                                    <td><span class="badge bg-secondary"><?php echo ucfirst($doador['metodo']); ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot class="table-group-divider">
                            <tr id="loadingRow" class="d-none">
                                <td colspan="4" class="text-center text-muted">Aguardando filtros...</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <nav class="mt-4">
                    <ul class="pagination justify-content-end" id="paginacaoDoadores"></ul>
                </nav>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer
        class="bg-body-tertiary text-body py-2 mt-auto"
        data-bs-theme="dark">
        <div class="container text-center text-md-start small">
            <div class="row">
                <div class="col-md-4 mb-2">
                    <h5 class="fw-bold fs-5">ConectaVidas+</h5>
                    <p>Conectando pessoas, empresas e ONGs para transformar vidas.</p>
                </div>
                <div class="col-md-4 mb-2">
                    <h6 class="fw-bold">Links úteis</h6>
                    <ul class="list-unstyled">
                        <li>
                            <a href="#" class="text-body-secondary text-decoration-none">Sobre</a>
                        </li>
                        <li>
                            <a href="#" class="text-body-secondary text-decoration-none">Campanhas</a>
                        </li>
                        <li>
                            <a href="#" class="text-body-secondary text-decoration-none">Contato</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4 mb-2 text-center">
                    <h6 class="fw-bold">Siga-nos</h6>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="#" class="text-body"><i class="bi bi-facebook fs-5"></i></a>
                        <a href="#" class="text-body"><i class="bi bi-instagram fs-5"></i></a>
                        <a href="#" class="text-body"><i class="bi bi-twitter-x fs-5"></i></a>
                        <a href="#" class="text-body"><i class="bi bi-whatsapp fs-5"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-1 border-body-secondary" />
            <p class="text-center mb-0 text-body-secondary">
                &copy; 2025 ConectaVidas+. Todos os direitos reservados.
            </p>
        </div>
    </footer>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>

    <!-- Scripts  -->
    <script src="../../../public/js/alternarTema.js"></script>
    <script src="../../../public/js/baixarRelatorioPdf.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <!-- ======= SCRIPT DE GRÁFICOS E FILTROS ======= -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const doadores = <?php echo json_encode($doadores, JSON_UNESCAPED_UNICODE); ?>;

            // ======== GRÁFICO DE ARRECADAÇÃO ========
            const ctx1 = document.getElementById("graficoArrecadacao").getContext("2d");
            const labels1 = doadores.map(d => new Date(d.data).toLocaleDateString("pt-BR"));
            const valores1 = doadores.map(d => d.valor);

            new Chart(ctx1, {
                type: "line",
                data: {
                    labels: labels1,
                    datasets: [{
                        label: "Valor doado (R$)",
                        data: valores1,
                        fill: true,
                        borderColor: "var(--primary)",
                        tension: 0.2,
                        backgroundColor: "rgba(75, 192, 192, 0.3)"
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            // ======== GRÁFICO DE DISTRIBUIÇÃO ========
            const ctx2 = document.getElementById("graficoDistribuicao").getContext("2d");
            const metodos = {};
            doadores.forEach(d => {
                const metodo = d.metodo.toLowerCase();
                metodos[metodo] = (metodos[metodo] || 0) + d.valor;
            });

            new Chart(ctx2, {
                type: "doughnut",
                data: {
                    labels: Object.keys(metodos),
                    datasets: [{
                        data: Object.values(metodos),
                        backgroundColor: [
                            "rgba(16, 245, 35, 0.7)",
                            "rgba(54, 162, 235, 0.7)",
                            "rgba(255, 206, 86, 0.7)",
                            "rgba(75, 192, 192, 0.7)",
                            "rgba(153, 102, 255, 0.7)"
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: "bottom"
                        }
                    }
                }
            });

            // ======== FILTRO DE TABELA ========
            const filtroNome = document.getElementById("filtroNome");
            const filtroMetodo = document.getElementById("filtroMetodo");
            const filtroLimite = document.getElementById("filtroLimite");
            const corpoTabela = document.getElementById("corpoTabela");

            function atualizarTabela() {
                let nomeFiltro = filtroNome.value.toLowerCase();
                let metodoFiltro = filtroMetodo.value.toLowerCase();
                let limite = parseInt(filtroLimite.value);

                let filtrados = doadores.filter(d =>
                    (!nomeFiltro || d.nome.toLowerCase().includes(nomeFiltro)) &&
                    (!metodoFiltro || d.metodo.toLowerCase() === metodoFiltro)
                );

                if (limite > 0) filtrados = filtrados.slice(0, limite);

                corpoTabela.innerHTML = filtrados.map(d => `
            <tr>
                <td>${d.nome}</td>
                <td class="fw-bold text-success">R$ ${d.valor.toLocaleString("pt-BR", { minimumFractionDigits: 2 })}</td>
                <td>${new Date(d.data).toLocaleDateString("pt-BR")}</td>
                <td><span class="badge bg-secondary">${d.metodo}</span></td>
            </tr>
        `).join("");
            }

            [filtroNome, filtroMetodo, filtroLimite].forEach(el => el.addEventListener("input", atualizarTabela));
        });
    </script>

    <script>

    </script>
</body>

</html>