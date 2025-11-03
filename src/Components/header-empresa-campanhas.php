<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>ConectaVidas+ | Empresa</title>

  <!-- Bootstrap e Ícones -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="/css/global.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
</head>

<body class="d-flex flex-column min-vh-100 bg-body">

  <!-- HEADER -->
  <header class="main-header">
    <!-- DESKTOP -->
    <div class="d-none d-md-flex container-fluid justify-content-between align-items-center py-2 px-4 border-bottom fixed-top shadow-sm bg-body flex-wrap">
      <!-- Logo -->
      <a href="/?url=home" class="text-decoration-none">
        <span class="fw-bold fs-2" style="color:var(--primary);">ConectaVidas+</span>
      </a>

      <!-- Barra de busca -->
      <form class="d-flex mx-3 flex-grow-1" style="max-width: 500px;">
        <input class="form-control me-2" type="search" placeholder="Buscar..." aria-label="Buscar">
        <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i></button>
      </form>

      <!-- Menu categorias -->
      <div class="dropdown me-3">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          Categorias
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#">Campanhas</a></li>
          <li><a class="dropdown-item" href="#">Colaboradores</a></li>
          <li><a class="dropdown-item" href="#">Relatórios</a></li>
          <li><a class="dropdown-item" href="#">Parceiros</a></li>
        </ul>
      </div>

      <!-- Navegação principal -->
      <nav class="d-flex align-items-center gap-4 flex-shrink-0">
        <a href="/?url=dashboard" class="text-body text-decoration-none fw-semibold fs-5 nav-link">Início</a>
        <a href="/?url=campanhas" class="text-body text-decoration-none fw-semibold fs-5 nav-link">Campanhas</a>
        <a href="/?url=colaboradores" class="text-body text-decoration-none fw-semibold fs-5 nav-link">Colaboradores</a>
        <a href="/?url=relatorios" class="text-body text-decoration-none fw-semibold fs-5 nav-link">Relatórios</a>

        <!-- Botão Tema -->
        <button class="theme-toggle btn btn-outline-secondary fs-5" title="Alternar Tema" type="button">
          <i class="bi bi-moon-fill"></i>
        </button>

        <!-- Menu Usuário -->
        <div class="dropdown">
          <a href="#" class="btn btn-outline-primary dropdown-toggle fw-semibold fs-5 d-flex align-items-center"
            data-bs-toggle="dropdown" role="button" aria-expanded="false">
            <span class="me-2"><i class="bi bi-building me-1"></i>Minha Empresa</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end fs-5 shadow-sm">
            <li><a class="dropdown-item" href="/?url=empresa/perfil"><i class="bi bi-person-circle me-2"></i>Perfil</a></li>
            <li><a class="dropdown-item" href="/?url=empresa/config"><i class="bi bi-gear me-2"></i>Configurações</a></li>
            <li><a class="dropdown-item" href="/?url=empresa/equipe"><i class="bi bi-people me-2"></i>Equipe</a></li>
            <li><a class="dropdown-item" href="/?url=empresa/parceiros"><i class="bi bi-handshake me-2"></i>Parceiros</a></li>
            <li><hr class="dropdown-divider" /></li>
            <li><a class="dropdown-item text-danger" href="/?url=logout"><i class="bi bi-box-arrow-right me-2"></i>Sair</a></li>
          </ul>
        </div>
      </nav>
    </div>

    <!-- MOBILE -->
    <nav class="navbar navbar-expand-lg bg-body border-bottom fixed-top shadow-sm d-md-none">
      <div class="container-fluid">
        <a class="navbar-brand fw-bold fs-3 text-primary" href="/?url=home">ConectaVidas+</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMobile"
          aria-controls="navbarMobile" aria-expanded="false" aria-label="Alternar navegação">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse mt-3" id="navbarMobile">
          <!-- Barra de busca -->
          <form class="d-flex mb-3" role="search">
            <input class="form-control me-2" type="search" placeholder="Buscar..." aria-label="Buscar">
            <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i></button>
          </form>

          <!-- Menu de categorias -->
          <div class="dropdown mb-3">
            <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Categorias
            </button>
            <ul class="dropdown-menu w-100">
              <li><a class="dropdown-item" href="#">Campanhas</a></li>
              <li><a class="dropdown-item" href="#">Colaboradores</a></li>
              <li><a class="dropdown-item" href="#">Relatórios</a></li>
              <li><a class="dropdown-item" href="#">Parceiros</a></li>
            </ul>
          </div>

          <ul class="navbar-nav ms-auto text-center gap-2">
            <li>
              <button class="theme-toggle btn btn-outline-secondary w-100" title="Alternar Tema" type="button">
                <i class="bi bi-moon-fill me-2"></i>Modo
              </button>
            </li>
            <li><a class="nav-link fw-semibold" href="/?url=dashboard"><i class="bi bi-house-door me-2"></i>Início</a></li>
            <li><a class="nav-link fw-semibold" href="/?url=campanhas"><i class="bi bi-megaphone me-2"></i>Campanhas</a></li>
            <li><a class="nav-link fw-semibold" href="/?url=colaboradores"><i class="bi bi-people me-2"></i>Colaboradores</a></li>
            <li><a class="nav-link fw-semibold" href="/?url=relatorios"><i class="bi bi-bar-chart-line me-2"></i>Relatórios</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="nav-link fw-semibold" href="/?url=empresa/perfil"><i class="bi bi-person-circle me-2"></i>Perfil</a></li>
            <li><a class="nav-link fw-semibold" href="/?url=empresa/config"><i class="bi bi-gear me-2"></i>Configurações</a></li>
            <li><a class="nav-link fw-semibold" href="/?url=empresa/equipe"><i class="bi bi-people me-2"></i>Equipe</a></li>
            <li><a class="nav-link fw-semibold" href="/?url=empresa/parceiros"><i class="bi bi-handshake me-2"></i>Parceiros</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="nav-link text-danger fw-semibold" href="/?url=logout"><i class="bi bi-box-arrow-right me-2"></i>Sair</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
    <!-- FIM HEADER -->