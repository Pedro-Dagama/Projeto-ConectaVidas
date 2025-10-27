<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="stylesheet" href="/css/global.css" />
    <link rel="stylesheet" href="/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
    <title>ConectaVidas+ — Home</title>
</head>

<body class="d-flex flex-column min-vh-100 bg-body">
    <div class="container">

  <!-- HEADER DESKTOP -->
  <header class="main-header">
    <div class="d-none d-md-flex container-fluid justify-content-between align-items-center py-2 px-4 border-bottom bg-body fixed-top shadow-sm">
      <a href="#" class="text-decoration-none text-body">
        <span style="color:var(--primary);" class="fw-bold fs-1">ConectaVidas+</span>
      </a>

      <nav class="d-flex align-items-center gap-4">
        <a href="#explorar" class="text-body text-decoration-none fw-semibold fs-5">Explorar</a>
        <a href="#sobre" class="text-body text-decoration-none fw-semibold fs-5">Sobre</a>
        <a href="#como" class="text-body text-decoration-none fw-semibold fs-5">Como Funciona</a>

        <button class="theme-toggle btn btn-outline-secondary fs-5" title="Alternar Tema" type="button">
          <i class="bi bi-moon-fill"></i>
        </button>

        <div class="dropdown" data-bs-theme="light">
          <a href="#" class="btn btn-outline-primary dropdown-toggle fw-semibold fs-5" data-bs-toggle="dropdown" role="button" aria-expanded="false">
            Entrar / Criar Conta
          </a>
          <ul class="dropdown-menu fs-5 dropdown-menu-end">
            <li><a class="dropdown-item" href="/?url=login">Entrar</a></li>
            <li><a class="dropdown-item" href="/?url=empresa/create">Criar Empresa</a></li>
            <li><a class="dropdown-item" href="/?url=ong/create">Criar ONG</a></li>
          </ul>
        </div>
      </nav>
    </div>

    <!-- HEADER MOBILE -->
    <nav class="navbar navbar-expand-lg bg-body border-bottom fixed-top shadow-sm d-md-none">
      <div class="container-fluid">
        <a style="color:var(--primary);" class="navbar-brand fw-bold fs-3" href="#">ConectaVidas+</a>
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
        <div class="collapse navbar-collapse " id="navbarMobile">
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
            <li><a class="nav-link" href="/?url=login">Entrar</a></li>
            <li><a class="nav-link" href="/?url=empresa/create">Criar Empresa</a></li>
            <li><a class="nav-link" href="/?url=ong/create">Criar Ong</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </header>