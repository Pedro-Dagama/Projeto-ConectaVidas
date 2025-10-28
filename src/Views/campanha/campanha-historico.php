<?php include __DIR__ . '/../../Components/header-campanha-historico.php'; ?>

<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$campanha = $campanha ?? null;
$doacoes = $doacoes ?? [];

// helper
function fmt_money($v)
{
    return number_format((float)$v, 2, ',', '.');
}
?>

<header class="main-header">
    <!-- ... (mantenha seu header existente ou inclua o component) -->
    <div class="d-none d-md-flex container-fluid align-items-center py-2 px-4 border-bottom bg-body fixed-top shadow-sm">
        <a href="/?url=home" class="text-decoration-none text-body"><span class="fw-bold fs-1">ConectaVidas+</span></a>
        <div class="d-flex align-items-center gap-4 ms-auto">
            <button class="theme-toggle btn btn-outline-secondary fs-5" title="Alternar Tema"><i class="bi bi-moon-fill"></i></button>
            <div class="dropdown menu-user p-2" data-bs-theme="light">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-body" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="me-2 fw-bold fs-5"><?= htmlspecialchars($_SESSION['user']['nome'] ?? 'Empresa') ?></span>
                </a>
            </div>
        </div>
    </div>
</header>

<main class="container mt-5 pt-5">
    <div class="text-center mb-4">
        <h1 class="fw-bold display-5 mt-4">Histórico de Doações</h1>
        <p class="text-muted fs-5">Acompanhe todas as doações recebidas por suas campanhas.</p>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <!-- <h1 class="fw-bold display-5"><?= htmlspecialchars($campanha['titulo'] ?? 'Histórico de Doações') ?></h1>
            <p class="text-muted fs-5"><?= htmlspecialchars($campanha['descricao'] ?? '') ?></p> -->
        </div>
        <div>
            <a href="/?url=empresa" class="btn btn-outline-secondary">Voltar ao Painel</a>
        </div>
    </div>

    <!-- Resumo: total arrecadado para esta campanha feito por esta empresa -->
    <?php
    $total = 0.0;
    foreach ($doacoes as $d) {
        $total += (float)($d['valor'] ?? 0);
    }
    ?>
    <div class="row mb-4 g-3">
        <div class="col-12 col-md-4">
            <div class="card shadow-sm p-3 border-0 text-center">
                <small class="text-muted">Total Arrecadado (por você)</small>
                <h4 class="text-success mb-0">R$ <?= fmt_money($total) ?></h4>
            </div>
        </div>

        <div class="col-12 col-md-8">
            <form class="row g-2" method="get" action="/?url=doacao/historico">
                <input type="hidden" name="campanha_id" value="<?= (int)($campanha['id_campanha'] ?? $_GET['campanha_id'] ?? 0) ?>" />
                <div class="col-6 col-md-4">
                    <input type="date" name="from" class="form-control" />
                </div>
                <div class="col-6 col-md-4">
                    <input type="date" name="to" class="form-control" />
                </div>
                <div class="col-6 col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Todos os status</option>
                        <option value="confirmado">Confirmado</option>
                        <option value="pendente">Pendente</option>
                        <option value="cancelado">Cancelado</option>
                    </select>
                </div>
                <div class="col-6 col-md-1">
                    <button class="btn btn-primary w-100" type="submit"><i class="bi bi-funnel"></i></button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabela -->
    <div class="table-responsive">
        <table class="table table-hover table-striped shadow-sm align-middle">
            <thead class="bg-body-secondary">
                <tr>
                    <th>Data</th>
                    <th>Valor</th>
                    <th>Doador</th>
                    <th>Campanha</th>
                    <th>Forma</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($doacoes)): ?>
                    <?php foreach ($doacoes as $d): ?>
                        <tr>
                            <td><?= htmlspecialchars(date('d/m/Y', strtotime($d['data_doacao'] ?? $d['data'] ?? date('Y-m-d')))) ?></td>
                            <td class="fw-bold text-success">R$ <?= fmt_money($d['valor'] ?? 0) ?></td>
                            <td><?= htmlspecialchars($_SESSION['user']['nome'] ?? 'Empresa') ?></td>
                            <td><?= htmlspecialchars($d['campanha_titulo'] ?? $d['campanha'] ?? ($campanha['titulo'] ?? '-')) ?></td>
                            <td><?= htmlspecialchars($d['forma_pagamento'] ?? $d['pagamento_tipo'] ?? '-') ?></td>
                            <td>
                                <?php
                                $s = strtolower($d['status_doacao'] ?? $d['status'] ?? 'pendente');
                                $badge = 'text-bg-secondary';
                                if (strpos($s, 'confirm') !== false || $s === 'confirmado') $badge = 'text-bg-success';
                                if ($s === 'pendente') $badge = 'text-bg-warning';
                                if ($s === 'cancelado' || $s === 'failed') $badge = 'text-bg-danger';
                                ?>
                                <span class="badge <?= $badge ?>"><?= htmlspecialchars(ucfirst($s)) ?></span>
                            </td>
                            <td>
                                <a href="/?url=doacao/comprovante&id=<?= (int)$d['id_doacao'] ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-file-earmark-text"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Nenhuma doação registrada para esta campanha por sua empresa.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Paginação futura -->
</main>

<?php include __DIR__ . '/../../Components/footer-campanha-historico.php'; ?>