<?php include __DIR__ . '/../../Components/header-campanha.php'; ?>
<!-- Header (você pode incluir seu header comum aqui) -->
<header class="main-header">
    <!-- Desktop -->
    <div class="d-none d-md-flex container-fluid align-items-center py-2 px-4 border-bottom bg-body fixed-top shadow-sm">
        <div class="d-flex align-items-center me-4">
            <a href="#" class="text-decoration-none text-body">
                <span class="fw-bold fs-1">ConectaVidas+</span>
            </a>
        </div>

        <div class="d-flex align-items-center gap-4 ms-auto">
            <button class="theme-toggle btn btn-outline-secondary fs-5" title="Alternar Tema">
                <i class="bi bi-moon-fill"></i>
            </button>

            <div class="dropdown menu-user p-2" data-bs-theme="light">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-body" data-bs-toggle="dropdown" aria-expanded="false" id="navOngName">
                    <span class="me-2 fw-bold fs-5" id="navOngNameText"><?= htmlspecialchars($_SESSION['user']['nome'] ?? 'ONG') ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end fs-5">
                    <li><a class="dropdown-item" href="/?url=campanha">Nova campanha</a></li>
                    <li><a class="dropdown-item" href="#">Configurações</a></li>
                    <li><a class="dropdown-item" href="#">Perfil</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="/?url=logout">Sair</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Mobile (se preferir manter) -->
    <nav class="navbar navbar-expand-lg bg-body border-bottom fixed-top shadow-sm d-md-none">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold fs-3" href="#">ConectaVidas+</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMobile" aria-controls="navbarMobile" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMobile">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <button class="theme-toggle btn btn-outline-secondary fs-5 w-100 my-2" title="Alternar Tema"></button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<!-- Conteúdo -->
<section class="text-center mt-5 pt-5">
    <h1 class="fw-bold display-5 mt-4">Gerenciar Campanhas</h1>
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

        <!-- Criar Nova Campanha -->
        <div class="col-12 col-md-6">
            <section class="card shadow-sm mb-4">
                <div class="card-header fw-bold bg-body-secondary">
                    <i class="bi bi-plus-circle me-1"></i> Criar Nova Campanha
                </div>
                <div class="card-body">
                    <form action="/?url=campanha/store" method="post">
                        <div class="mb-3"><input type="text" name="titulo" class="form-control" placeholder="Título da campanha" required></div>
                        <div class="mb-3">
                            <select name="categoria" class="form-select" required>
                                <option value="" selected disabled>Selecione a Categoria</option>
                                <option value="educacao">Educação</option>
                                <option value="saude">Saúde</option>
                                <option value="meio_ambiente">Meio Ambiente</option>
                                <option value="animais">Animais</option>
                                <option value="outros">Outros</option>
                            </select>
                        </div>
                        <div class="mb-3"><textarea name="descricao" class="form-control" placeholder="Descrição" required></textarea></div>
                        <div class="mb-3"><input type="number" name="meta" class="form-control" placeholder="Meta R$" required min="1" step="0.01"></div>
                        <div class="mb-3"><input type="date" name="prazo" class="form-control" required></div>
                        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-send-fill me-1"></i>Criar Campanha</button>
                    </form>
                </div>
            </section>
        </div>

        <!-- Campanhas Realizadas -->
        <div class="col-12 col-md-6">
            <section class="card shadow-sm mb-4">
                <div class="card-header fw-bold bg-body-secondary">Campanhas Realizadas</div>
                <div class="card-body">
                    <div class="list-group" id="campaignList">
                        <?php if (!empty($campanhas)): ?>
                            <?php foreach ($campanhas as $c): ?>
                                <div class="list-group-item py-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="me-3">
                                            <h6 class="mb-1 fw-bold"><?= htmlspecialchars($c['titulo']) ?></h6>
                                            <p class="mb-1 text-secondary">Meta: <strong>R$ <?= number_format((float)$c['meta'], 2, ',', '.') ?></strong> | Arrecadado: <strong>R$ <?= number_format((float)$c['valor_arrecadado'], 2, ',', '.') ?></strong></p>
                                            <p class="mb-1 text-secondary">Categoria: <strong><?= htmlspecialchars($c['categoria_nome'] ?? '') ?></strong></p>
                                            <small class="text-muted">Status: <?= htmlspecialchars($c['status']) ?> | Localização: <?= htmlspecialchars($c['localizacao'] ?? '-') ?></small>
                                        </div>
                                        <div class="d-flex flex-column gap-2">
                                            <a href="/?url=campanha/view&id=<?= (int)$c['id_campanha'] ?>" class="btn btn-outline-primary btn-sm"><i class="bi bi-file-earmark-text"></i> Relatório</a>
                                            <a href="/?url=campanha/edit&id=<?= (int)$c['id_campanha'] ?>" class="btn btn-outline-success btn-sm"><i class="bi bi-pencil-square"></i> Editar</a>
                                            <a href="/?url=campanha/close&id=<?= (int)$c['id_campanha'] ?>" class="btn btn-outline-danger btn-sm"><i class="bi bi-x-circle"></i> Encerrar</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center text-muted">Nenhuma campanha cadastrada ainda.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </div>

    </div>
</main>
<?php include __DIR__ . '/../../Components/footer-campanha.php'; ?>