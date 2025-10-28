<?php include __DIR__ . '/../../Components/header-campanha.php'; ?>

<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($campanha)) {
    echo "<div class='container py-5'><div class='alert alert-danger'>Campanha não encontrada.</div></div>";
    include __DIR__ . '/../../Components/footer-campanha.php';
    exit();
}
?>

<main class="container mt-5 pt-4">
    <h1 class="mb-4">Editar Campanha</h1>

    <?php
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

    <form action="/?url=campanha/update&id=<?= (int)$campanha['id_campanha'] ?>" method="post">
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" required value="<?= htmlspecialchars($campanha['titulo']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Categoria</label>
            <select name="categoria" class="form-select" required>
                <option value="educacao" <?= ($campanha['categoria_nome'] === 'educacao') ? 'selected' : '' ?>>Educação</option>
                <option value="saude" <?= ($campanha['categoria_nome'] === 'saude') ? 'selected' : '' ?>>Saúde</option>
                <option value="meio_ambiente" <?= ($campanha['categoria_nome'] === 'meio_ambiente') ? 'selected' : '' ?>>Meio Ambiente</option>
                <option value="animais" <?= ($campanha['categoria_nome'] === 'animais') ? 'selected' : '' ?>>Animais</option>
                <option value="outros" <?= ($campanha['categoria_nome'] === 'outros') ? 'selected' : '' ?>>Outros</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea name="descricao" class="form-control" rows="5" required><?= htmlspecialchars($campanha['descricao']) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Meta (R$)</label>
            <input type="number" name="meta" class="form-control" required step="0.01" min="1" value="<?= htmlspecialchars($campanha['meta']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Prazo (data de encerramento)</label>
            <input type="date" name="prazo" class="form-control" required value="<?= date('Y-m-d', strtotime($campanha['data_encerramento'])) ?>">
        </div>

        <div class="d-flex gap-2">
            <a href="/?url=campanha" class="btn btn-secondary">Voltar</a>
            <button type="submit" class="btn btn-primary">Salvar alterações</button>
        </div>
    </form>
</main>

<?php include __DIR__ . '/../../Components/footer-campanha.php'; ?>