<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ConectaVidas+</title>

    <!-- CSS Global e Bootstrap -->
    <link rel="stylesheet" href="/css/global.css" />
    <link rel="stylesheet" href="/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />

</head>

<body class="d-flex flex-column min-vh-100 bg-body">
    <!-- HEADER -->
    <header class="main-header">

        <!-- Desktop Header -->
        <div class="d-none d-md-flex container-fluid align-items-center py-2 px-4 border-bottom bg-body fixed-top shadow-sm">
            <!-- Logo -->
            <div class="d-flex align-items-center me-4">
                <a href="#" class="text-decoration-none text-body">
                    <span class="fw-bold fs-1">ConectaVidas+</span>
                </a>
            </div>

            <!-- Menu direito: alternar tema e menu usuário -->
            <div class="d-flex align-items-center gap-4 ms-auto">
                <!-- Botão alternar tema -->
                <button class="theme-toggle btn btn-outline-secondary fs-5" title="Alternar Tema" aria-label="Alternar tema claro/escuro">
                    <i class="bi bi-moon-fill"></i>
                </button>

                <!-- Menu do usuário -->
                <div class="dropdown menu-user p-2" data-bs-theme="light">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-body"
                        data-bs-toggle="dropdown" aria-expanded="false" aria-label="Menu do usuário">
                        <span class="me-2 fw-bold fs-5">Empresa</span>
                        <img src="https://github.com/mdo.png" alt="avatar" width="40" height="40" class="rounded-circle" />
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end fs-5">
                        <li><a class="dropdown-item" href="#">Novo projeto</a></li>
                        <li><a class="dropdown-item" href="#">Configurações</a></li>
                        <li><a class="dropdown-item" href="#">Perfil</a></li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li><a class="dropdown-item" href="#">Sair</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Mobile Navbar -->
        <nav class="navbar navbar-expand-lg bg-body border-bottom fixed-top shadow-sm d-md-none">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold fs-3" href="#">ConectaVidas+</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMobile"
                    aria-controls="navbarMobile" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarMobile">
                    <ul class="navbar-nav ms-auto">
                        <!-- Botão tema -->
                        <li class="nav-item">
                            <button class="theme-toggle btn btn-outline-secondary w-100 my-2" title="Alternar Tema" aria-label="Alternar tema claro/escuro">
                                <i class="bi bi-moon-fill"></i> Tema
                            </button>
                        </li>

                        <!-- Dropdown menu usuário -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-bold" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false" aria-label="Menu do usuário">
                                Empresa
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="#">Novo projeto</a></li>
                                <li><a class="dropdown-item" href="#">Configurações</a></li>
                                <li><a class="dropdown-item" href="#">Perfil</a></li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li><a class="dropdown-item" href="#">Sair</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>