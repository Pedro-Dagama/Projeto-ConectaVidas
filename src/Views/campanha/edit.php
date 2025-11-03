<?php include __DIR__ . '/../../Components/header-campanha.php'; ?>

<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($campanha)) {
    echo "<div class='container py-5'>
            <div class='alert alert-danger shadow-sm text-center'>
                <i class='bi bi-exclamation-triangle-fill me-2'></i> Campanha não encontrada.
            </div>
          </div>";
    include __DIR__ . '/../../Components/footer-campanha.php';
    exit();
}
?>
<section class="text-center mt-5 pt-5">
   <h1 class="fw-bold text-primary">
            <i class="bi bi-pencil-square me-2"></i>Editar Campanha
        </h1>
    <p class="text-muted mb-0">
            Atualize as informações da sua campanha e mantenha seus apoiadores informados.
        </p>
</section>
<main class="container py-4 px-3 px-md-5">
    

    <?php if (!empty($_SESSION['form_errors'])): ?>
        <div class="alert alert-danger shadow-sm">
            <h6 class="fw-bold mb-2">
                <i class="bi bi-x-circle-fill me-2"></i>Erros ao salvar:
            </h6>
            <?php foreach ($_SESSION['form_errors'] as $err): ?>
                <div>- <?= htmlspecialchars($err) ?></div>
            <?php endforeach; ?>
        </div>
        <?php unset($_SESSION['form_errors']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success_message'])): ?>
        <div class="alert alert-success shadow-sm">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= htmlspecialchars($_SESSION['success_message']) ?>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <div class="card shadow border-0 rounded-4">
        <div class="card-body p-4">
            <form action="/?url=campanha/update&id=<?= (int)$campanha['id_campanha'] ?>" method="post" class="needs-validation" novalidate>

                <!-- Título -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Título da Campanha</label>
                    <input type="text" name="titulo" class="form-control form-control-lg shadow-sm"
                           required value="<?= htmlspecialchars($campanha['titulo']) ?>">
                </div>

                <!-- Categoria -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Categoria</label>
                    <select name="categoria" class="form-select form-select-lg shadow-sm" required>
                        <option value="educacao" <?= ($campanha['categoria_nome'] === 'educacao') ? 'selected' : '' ?>>Educação</option>
                        <option value="saude" <?= ($campanha['categoria_nome'] === 'saude') ? 'selected' : '' ?>>Saúde</option>
                        <option value="meio_ambiente" <?= ($campanha['categoria_nome'] === 'meio_ambiente') ? 'selected' : '' ?>>Meio Ambiente</option>
                        <option value="animais" <?= ($campanha['categoria_nome'] === 'animais') ? 'selected' : '' ?>>Animais</option>
                        <option value="outros" <?= ($campanha['categoria_nome'] === 'outros') ? 'selected' : '' ?>>Outros</option>
                    </select>
                </div>

                <!-- Descrição -->
                <div class="mb-3">
                    <label class="form-label fw-semibold">Descrição</label>
                    <textarea name="descricao" class="form-control shadow-sm" rows="5" required><?= htmlspecialchars($campanha['descricao']) ?></textarea>
                </div>

                <!-- Meta e Prazo -->
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Meta (R$)</label>
                        <input type="number" name="meta" class="form-control shadow-sm" required step="0.01" min="1"
                               value="<?= htmlspecialchars($campanha['meta']) ?>">
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Prazo (Data de Encerramento)</label>
                        <input type="date" name="prazo" class="form-control shadow-sm" required
                               value="<?= date('Y-m-d', strtotime($campanha['data_encerramento'])) ?>">
                    </div>
                </div>

                <!-- Botões -->
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3 mt-4">
                    <a href="/?url=campanha" class="btn btn-outline-secondary w-100 w-sm-auto d-flex align-items-center justify-content-center shadow-sm">
                        <i class="bi bi-arrow-left me-2"></i> Voltar
                    </a>
                    <button type="submit" class="btn btn-primary w-100 w-sm-auto px-4 shadow-sm d-flex align-items-center justify-content-center">
                        <i class="bi bi-save me-2"></i> Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../../Components/footer.php'; ?>
