<?php include __DIR__ . '/../../Components/header-empresa.php'; ?>

<!-- Header Responsivo -->
<header class="main-header">
    <!-- Navbar Desktop -->
    <div
        class="d-none d-md-flex container-fluid align-items-center py-2 px-4 border-bottom bg-body fixed-top shadow-sm">
        <div class="d-flex align-items-center me-4">
            <a href="#" class="text-decoration-none text-body">
                <span class="fw-bold fs-1">ConectaVidas+</span>
            </a>
        </div>

        <div class="d-flex align-items-center gap-4 ms-auto">
            <!-- Alternar Tema -->
            <button
                class="theme-toggle btn btn-outline-secondary fs-5"
                title="Alternar Tema">
                <i class="bi bi-moon-fill"></i>
            </button>

            <!-- Menu do Usuário -->
            <div class="dropdown menu-user p-2" data-bs-theme="light">
                <a
                    href="#"
                    class="d-flex align-items-center text-decoration-none dropdown-toggle text-body"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                    id="navCompanyName">
                    <span class="me-2 fw-bold fs-5" id="navCompanyNameText">TechSolidariedade</span>
                    <img
                        src="https://picsum.photos/100"
                        alt="avatar"
                        width="40"
                        height="40"
                        class="rounded-circle" />
                </a>
                <ul class="dropdown-menu dropdown-menu-end fs-5">
                    <li><a class="dropdown-item" href="#">Novo projeto</a></li>
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

    <!-- Navbar Mobile -->
    <nav
        class="navbar navbar-expand-lg bg-body border-bottom fixed-top shadow-sm d-md-none">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold fs-3" href="#">ConectaVidas+</a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMobile"
                aria-controls="navbarMobile"
                aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMobile">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <button class="btn btn-outline-primary w-100 my-2" data-bs-toggle="modal" data-bs-target="#editarPerfilModal">
                            <i class="bi bi-pencil me-2"></i> Editar Perfil
                        </button>
                    </li>
                    <li class="nav-item">
                        <button
                            class="theme-toggle btn btn-outline-secondary w-100 my-2"
                            title="Alternar Tema">
                            <i class="bi bi-moon-fill"></i> Tema
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<!-- Título da página fora do header -->
<section class="text-center mt-5 pt-5">
    <h1 class="fw-bold display-5 mt-4">Perfil da Empresa</h1>
    <p class="text-muted fs-5">Gerencie seus dados, conta e visualize seu histórico de doações.</p>
</section>

<main class="container-fluid mt-4 pt-2">
    <div class="row g-4 px-3 px-md-5">
        <!-- Perfil -->
        <div class="col-12">
            <section class="card shadow-sm mb-4 text-center p-4">
                <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <img
                            src="https://picsum.photos/200"
                            alt="Logo Empresa"
                            class="perfil-foto border border-3 border-primary mb-3 mb-md-0 me-3"
                            id="profilePhoto" />
                        <div class="text-start">
                            <h3 class="fw-bold mb-0" id="profileName">TechSolidariedade LTDA</h3>
                            <p class="text-muted mb-1" id="profileHandle">@techsolidariedade</p>
                            <p class="text-secondary mb-0" id="profileDesc">Empresa parceira no impacto social através da inovação e tecnologia 💡🤝</p>
                        </div>
                    </div>

                    <div class="mt-3 mt-md-0">
                        <!-- Edit profile button -->
                        <button class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#editarPerfilModal">
                            <i class="bi bi-pencil"></i> Editar Perfil
                        </button>
                        <button class="btn btn-outline-secondary" id="btnExportarRelatorio">
                            <i class="bi bi-file-earmark-arrow-down"></i> Exportar relatório
                        </button>
                    </div>
                </div>
            </section>
        </div>

        <!-- Informações e Conta / Doações -->
        <div class="col-12 col-md-7">
            <section class="card shadow-sm mb-4">
                <div class="card-header fw-bold bg-body-secondary d-flex justify-content-between align-items-center">
                    <span>Informações Cadastrais</span>
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editarPerfilModal">
                        <i class="bi bi-pencil"></i> Editar
                    </button>
                </div>
                <div class="card-body row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">CNPJ</label>
                        <input type="text" class="form-control" id="inputCNPJ" value="12.345.678/0001-90" readonly />
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Nome Fantasia</label>
                        <input type="text" class="form-control" id="inputNomeFantasia" value="TechSolidariedade" readonly />
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Razão Social</label>
                        <input type="text" class="form-control" id="inputRazao" value="TechSolidariedade LTDA" readonly />
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">E-mail</label>
                        <input type="email" class="form-control" id="inputEmail" value="contato@techsolidariedade.com" readonly />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Telefone</label>
                        <input type="text" class="form-control" id="inputTelefone" value="(13) 3322-4455" readonly />
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Endereço</label>
                        <input
                            type="text"
                            class="form-control"
                            id="inputEndereco"
                            value="Av. das Empresas, 500 - Guarujá/SP"
                            readonly />
                    </div>
                </div>
            </section>

            <section class="card saldo-card shadow-sm mb-4">
                <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-1">Conta Empresarial</h5>
                        <p class="mb-0">Número da conta: <strong id="accountNumber">0012345-9</strong></p>
                    </div>
                    <div class="text-end mt-3 mt-md-0">
                        <h3 class="fw-bold mb-0" id="accountBalance">R$ 12.540,00</h3>
                        <small id="accountLimit">Limite de crédito: R$ 5.000,00</small>
                    </div>
                </div>
            </section>
        </div>

        <!-- Histórico de Doações -->
        <div class="col-12 col-md-5">
            <section class="card shadow-sm mb-4">
                <div class="card-header fw-bold bg-body-secondary">
                    Histórico de Doações
                </div>
                <div class="card-body">
                    <div class="list-group" id="historyList">
                        <div class="list-group-item py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1 fw-bold">Campanha: Doe Energia</h6>
                                    <p class="mb-1 text-secondary">Valor: <strong>R$ 500,00</strong> — Cartão de Crédito</p>
                                    <small class="text-muted">Data: 05/10/2025 — Status: Confirmada</small>
                                </div>
                                <div class="d-flex flex-column gap-2">
                                    <button class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-file-earmark-text"></i> Comprovante
                                    </button>
                                    <button class="btn btn-outline-success btn-sm">
                                        <i class="bi bi-bar-chart"></i> Relatório
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="list-group-item py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1 fw-bold">Campanha: Conectando Escolas</h6>
                                    <p class="mb-1 text-secondary">Valor: <strong>R$ 750,00</strong> — PIX</p>
                                    <small class="text-muted">Data: 01/09/2025 — Status: Confirmada</small>
                                </div>
                                <div class="d-flex flex-column gap-2">
                                    <button class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-file-earmark-text"></i> Comprovante
                                    </button>
                                    <button class="btn btn-outline-success btn-sm">
                                        <i class="bi bi-bar-chart"></i> Relatório
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>
</main>

<!-- Modal Editar Perfil -->
<div class="modal fade" id="editarPerfilModal" tabindex="-1" aria-labelledby="editarPerfilLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" id="editarPerfilForm">
            <div class="modal-header">
                <h5 class="modal-title" id="editarPerfilLabel">Editar Perfil da Empresa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nome Fantasia</label>
                        <input type="text" name="nomeFantasia" id="formNomeFantasia" class="form-control" required />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Razão Social</label>
                        <input type="text" name="razao" id="formRazao" class="form-control" />
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">CNPJ</label>
                        <input type="text" name="cnpj" id="formCNPJ" class="form-control" />
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">E-mail</label>
                        <input type="email" name="email" id="formEmail" class="form-control" required />
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Telefone</label>
                        <input type="text" name="telefone" id="formTelefone" class="form-control" />
                    </div>

                    <div class="col-12">
                        <label class="form-label">Endereço</label>
                        <input type="text" name="endereco" id="formEndereco" class="form-control" />
                    </div>

                    <div class="col-12">
                        <label class="form-label">Descrição (breve)</label>
                        <textarea name="descricao" id="formDescricao" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Alterar logo (URL)</label>
                        <input type="url" name="logo" id="formLogo" class="form-control" placeholder="https://..." />
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
<?php include __DIR__ . '/../../Components/footer-empresa.php'; ?>