<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>

<?php include __DIR__ . '/../../Components/header-campanha.php'; ?>

<!-- Conteúdo -->
<section class="text-center mt-5 pt-5">
    <h1 class="fw-bold display-5 mt-4 text-primary">Gerenciar Campanhas</h1>
    <p class="text-muted fs-5">Crie novas campanhas, acompanhe arrecadações e gerencie suas ações sociais.</p>
</section>

<main class="container-fluid mt-4 pt-2">
    <div class="row g-4 px-3 px-md-5">

        <div class="col-12">
            <?php
            if (session_status() === PHP_SESSION_NONE) session_start();
            if (!empty($_SESSION['form_errors'])) {
                echo '<div class="alert alert-danger">';
                foreach ($_SESSION['form_errors'] as $err) {
                    echo '<div>' . htmlspecialchars($err) . '</div>';
                }
                echo '</div>';
                unset($_SESSION['form_errors']);
            }
            if (!empty($_SESSION['success_message'])) {
                echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['success_message']) . '</div>';
                unset($_SESSION['success_message']);
            }
            ?>
        </div>

        <!-- Botão Voltar ao Painel -->
        <div class="col-12 d-flex justify-content-start">
            <a href="painel.php" class="btn btn-outline-secondary shadow-sm d-inline-flex  align-items-center mb-3">
                <i class="bi bi-arrow-left me-2"></i> Voltar ao Painel
            </a>
        </div>

        <!-- Criar Nova Campanha -->
        <div class="col-12 col-lg-6">
            <section class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-primary text-white fw-bold d-flex align-items-center">
                    <i class="bi bi-plus-circle me-2"></i> Criar Nova Campanha
                </div>
                <div class="card-body p-4">
                    <form action="/?url=campanha/store" method="post">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Título da Campanha</label>
                            <input type="text" name="titulo" class="form-control" placeholder="Ex: Ação Solidária de Inverno" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Categoria</label>
                            <select name="categoria" class="form-select" required>
                                <option value="" selected disabled>Selecione a categoria</option>
                                <option value="educacao">Educação</option>
                                <option value="saude">Saúde</option>
                                <option value="meio_ambiente">Meio Ambiente</option>
                                <option value="animais">Animais</option>
                                <option value="outros">Outros</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Descrição</label>
                            <textarea name="descricao" class="form-control" rows="3" placeholder="Explique o objetivo da campanha..." required></textarea>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Meta (R$)</label>
                                <input type="number" name="meta" class="form-control" placeholder="Ex: 5000" required min="1" step="0.01">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Prazo</label>
                                <input type="date" name="prazo" class="form-control" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-4 py-2 fw-semibold shadow-sm">
                            <i class="bi bi-send-fill me-1"></i> Criar Campanha
                        </button>
                    </form>
                </div>
            </section>
        </div>

        <!-- Campanhas Realizadas -->
        <div class="col-12 col-lg-6">
            <section class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-success text-white fw-bold d-flex align-items-center">
                    <i class="bi bi-bullseye me-2"></i> Campanhas Realizadas
                </div>
                <div class="card-body p-4">
                    <div class="list-group" id="campaignList">
                        <?php if (!empty($campanhas)): ?>
                            <?php foreach ($campanhas as $c): ?>
                                <div class="list-group-item py-3 rounded-3 shadow-sm mb-3 border-0">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="me-3">
                                            <h5 class="mb-1 fw-bold text-primary"><?= htmlspecialchars($c['titulo']) ?></h5>
                                            <p class="mb-1 text-secondary small">
                                                Meta: <strong>R$ <?= number_format((float)$c['meta'], 2, ',', '.') ?></strong> |
                                                Arrecadado: <strong>R$ <?= number_format((float)$c['valor_arrecadado'], 2, ',', '.') ?></strong>
                                            </p>
                                            <p class="mb-1 small text-secondary">Categoria: <strong><?= htmlspecialchars($c['categoria_nome'] ?? '') ?></strong></p>
                                            <small class="text-muted">
                                                Status: <?= htmlspecialchars($c['status']) ?> |
                                                Localização: <?= htmlspecialchars($c['localizacao'] ?? '-') ?>
                                            </small>
                                        </div>

                                        <div class="d-flex flex-column align-items-end gap-2">
                                            <a href="/?url=campanha/view&id=<?= (int)$c['id_campanha'] ?>" class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-file-earmark-text"></i>
                                            </a>

                                            <?php if (isset($_SESSION['user']) && ($_SESSION['user']['tipo_usuario'] ?? '') === 'empresa'): ?>
                                                <a href="/?url=doacao/create&campanha_id=<?= (int)$c['id_campanha'] ?>" class="btn btn-success btn-sm">
                                                    <i class="bi bi-cash-coin"></i>
                                                </a>
                                            <?php elseif (isset($_SESSION['user']) && ($_SESSION['user']['tipo_usuario'] ?? '') === 'ong'): ?>
                                                <a href="/?url=campanha/edit&id=<?= (int)$c['id_campanha'] ?>" class="btn btn-outline-success btn-sm">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <a href="/?url=campanha/close&id=<?= (int)$c['id_campanha'] ?>" class="btn btn-outline-danger btn-sm"  onclick="return confirm('Tem certeza que deseja encerrar esta campanha?');">
                                                    <i class="bi bi-x-circle"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center text-muted py-3">Nenhuma campanha cadastrada ainda.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </div>

    </div>
</main>
<?php include __DIR__ . '/../../Components/footer.php'; ?>