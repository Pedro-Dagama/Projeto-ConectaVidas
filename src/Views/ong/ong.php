<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$ong = $_SESSION['ong'] ?? null;
$user = $_SESSION['user'] ?? null;
?>


<?php include __DIR__ . '/../../Components/header-ong.php'; ?>

<!-- Conteúdo -->
<section class="text-center mt-5 pt-5">
    <h1 class="fw-bold display-5 mt-4">Perfil da ONG</h1>
    <p class="text-muted fs-5">Gerencie suas informações, campanhas e impacto social.</p>
</section>

<main class="container-fluid mt-4 pt-2">
    <?php if(isset($_SESSION['message'])): ?>
        <div class="alert alert-<?= $_SESSION['message_type'] ?? 'info' ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
    <?php endif; ?>
    
    <div class="row g-4 px-3 px-md-5">
        <!-- Perfil ONG  -->
        <div class="col-12">
            <section class="card shadow-sm mb-4 p-3 p-md-4">
                <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
                    <div class="d-flex flex-column flex-md-row align-items-center text-center text-md-start">
                        <img src="<?= htmlspecialchars($ong['logo'] ?? '/img/co-an-ft3.png') ?>"
                            alt="Logo ONG"
                            class="perfil-foto border border-3 border-success mb-3 mb-md-0 me-md-3"
                            id="profilePhoto" />
                        <div>
                            <h3 class="fw-bold mb-2 mb-md-0" id="profileName">
                                <?= htmlspecialchars($ong['nome_fantasia'] ?? 'Nome da ONG') ?>
                            </h3>
                            <p class="text-muted mb-1" id="profileHandle">@<?= strtolower(str_replace(' ', '', $ong['nome_fantasia'] ?? 'ong')) ?></p>
                            <p class="text-secondary mb-0" id="profileDesc">
                                <?= htmlspecialchars($ong['descricao'] ?? 'ONG dedicada a transformar comunidades por meio da educação e solidariedade 💚📚') ?>
                            </p>
                        </div>
                    </div>

                    <div class="d-flex gap-2 flex-wrap justify-content-center">
                        <button class="btn btn-outline-primary"
                            data-bs-toggle="modal" data-bs-target="#editarPerfilModal">
                            <i class="bi bi-pencil"></i> <span class="d-none d-sm-inline">Editar Perfil</span>
                        </button>
                        <a href="../campanha/campanha.php" class="btn btn-outline-success">
                            <i class="bi bi-plus-circle"></i> <span class="d-none d-sm-inline">Nova Campanha</span>
                        </a>
                    </div>
                </div>
            </section>
        </div>

        <!-- Informações Cadastrais -->
        <div class="col-12 col-lg-7">
            <section class="card shadow-sm mb-4">
                <div class="card-header fw-bold bg-body-secondary d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <span>Informações Cadastrais</span>
                    <button class="btn btn-sm btn-outline-primary"
                        data-bs-toggle="modal" data-bs-target="#editarPerfilModal">
                        <i class="bi bi-pencil"></i> Editar
                    </button>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-semibold">CNPJ</label>
                            <input type="text" class="form-control form-control-sm" id="inputCNPJ"
                                value="<?= htmlspecialchars($ong['cnpj'] ?? '00.000.000/0000-00') ?>" readonly />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-semibold">Nome Fantasia</label>
                            <input type="text" class="form-control form-control-sm" id="inputNomeFantasia"
                                value="<?= htmlspecialchars($ong['nome_fantasia'] ?? 'Instituto Esperança') ?>" readonly />
                        </div>

                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-semibold">E-mail</label>
                            <input type="email" class="form-control form-control-sm" id="inputEmail"
                                value="<?= htmlspecialchars($user['email'] ?? 'contato@esperanca.org') ?>" readonly />
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-semibold">Telefone</label>
                            <input type="text" class="form-control form-control-sm" id="inputTelefone"
                                value="<?= htmlspecialchars($user['telefone'] ?? '(00) 00000-0000') ?>" readonly />
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Endereço</label>
                            <input type="text" class="form-control form-control-sm" id="inputEndereco"
                                value="<?= htmlspecialchars($ong['endereco'] ?? 'Endereço não informado') ?>" readonly />
                        </div>
                    </div>
                </div>
            </section>

            <!-- Impacto  -->
            <section class="card impacto-card shadow-sm mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12 col-sm-6 text-center text-sm-start mb-3 mb-sm-0">
                            <h5 class="fw-bold mb-1">Impacto Social</h5>
                            <p class="mb-0">Campanhas Ativas: <strong id="activeCampaigns">3</strong></p>
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            <h3 class="fw-bold mb-0" id="impactValue">
                                R$ <?= number_format($ong['valor_arrecadado'] ?? 0, 2, ',', '.') ?>
                            </h3>
                            <small id="impactNote">em doações arrecadadas</small>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Histórico de Campanhas -->
        <div class="col-12 col-lg-5">
            <section class="card shadow-sm mb-4">
                <div class="card-header fw-bold bg-body-secondary">
                    Campanhas Realizadas
                </div>
                <div class="card-body p-2 p-sm-3">
                    <div class="list-group" id="campaignList">
                        <?php if (!empty($ong['campaigns']) && count($ong['campaigns']) > 0): ?>
                            <?php foreach ($ong['campaigns'] as $campanha): ?>
                                <div class="list-group-item py-3">
                                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start gap-3">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 fw-bold">
                                                <?= htmlspecialchars($campanha['titulo'] ?? 'Sem título') ?>
                                            </h6>
                                            <div class="d-flex flex-wrap gap-2 text-secondary small">
                                                <span>Meta: <strong>R$ <?= number_format($campanha['meta'] ?? 0, 2, ',', '.') ?></strong></span>
                                                <span>Arrecadado: <strong>R$ <?= number_format($campanha['arrecadado'] ?? 0, 2, ',', '.') ?></strong></span>
                                                <span>Curtidas: <strong><?= (int)($campanha['curtidas'] ?? 0) ?></strong></span>
                                            </div>
                                            <small class="text-muted d-block mt-1">
                                                Status: <?= htmlspecialchars($campanha['status'] ?? 'Desconhecido') ?> |
                                                Local: <?= htmlspecialchars($campanha['localizacao'] ?? 'Não informada') ?>
                                            </small>
                                        </div>
                                        <div class="d-flex gap-2 flex-wrap">
                                            <button class="btn btn-outline-primary btn-sm">
                                                <i class="bi bi-file-text"></i>
                                            </button>
                                            <button class="btn btn-outline-success btn-sm">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Nenhuma campanha cadastrada.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </div>


        <!-- Modal Editar Perfil -->
        <div class="modal fade" id="editarPerfilModal" tabindex="-1" aria-labelledby="editarPerfilLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form class="modal-content" id="editarPerfilForm" 
                    method="POST" 
                    action="/?url=ong/update">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarPerfilLabel">Editar Perfil da ONG</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nome Fantasia</label>
                                <input type="text" name="nomeFantasia" id="formNomeFantasia" class="form-control" required
                                    value="<?= htmlspecialchars($ong['nome_fantasia'] ?? '') ?>" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">CNPJ</label>
                                <input type="text" name="cnpj" id="formCNPJ" class="form-control"
                                    value="<?= htmlspecialchars($ong['cnpj'] ?? '') ?>" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">E-mail</label>
                                <input type="email" name="email" id="formEmail" class="form-control" required
                                    value="<?= htmlspecialchars($user['email'] ?? '') ?>" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Telefone</label>
                                <input type="text" name="telefone" id="formTelefone" class="form-control"
                                    value="<?= htmlspecialchars($ong['telefone'] ?? '') ?>" />
                            </div>
                            <div class="col-12">
                                <label class="form-label">Endereço</label>
                                <input type="text" name="endereco" id="formEndereco" class="form-control"
                                    value="<?= htmlspecialchars($ong['endereco'] ?? '') ?>" />
                            </div>
                            <div class="col-12">
                                <label class="form-label">Descrição (breve)</label>
                                <textarea name="descricao" id="formDescricao" class="form-control" rows="2"><?= htmlspecialchars($ong['descricao'] ?? '') ?></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Alterar logo (URL)</label>
                                <input type="url" name="logo" id="formLogo" class="form-control" placeholder="https://..."
                                    value="<?= htmlspecialchars($ong['logo'] ?? '') ?>" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Senha nova (opcional)</label>
                                <input type="password" name="senha" id="formSenha" class="form-control" placeholder="Nova senha" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>  
</main>

<?php include __DIR__ . '/../../Components/footer-home.php'; ?>
</body>
</html>