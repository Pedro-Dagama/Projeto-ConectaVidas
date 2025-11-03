<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <link rel="stylesheet" href="/css/global.css" />
  <link rel="stylesheet" href="/css/perfil-ong.css" />
  <link rel="stylesheet" href="/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
  <title>Campanhas | ONG</title>
</head>

<body class="d-flex flex-column min-vh-100 bg-body">
  <!-- HEADER -->
  <header class="main-header">
    <!-- DESKTOP -->
    <div class="d-none d-md-flex container-fluid justify-content-between align-items-center py-2 px-4 border-bottom fixed-top shadow-sm bg-body">
      <a href="/?url=home" class="text-decoration-none text-body">
        <span style="color:var(--primary);" class="fw-bold fs-2">ConectaVidas+</span>
      </a>

      <nav class="d-flex align-items-center gap-4">
        <a href="/?url=dashboard" class="text-body text-decoration-none fw-semibold fs-5 nav-link">Início</a>
        <a href="/?url=campanha" class="text-body text-decoration-none fw-semibold fs-5 nav-link">Campanhas</a>
        <a href="/?url=empresas" class="text-body text-decoration-none fw-semibold fs-5 nav-link">Empresas</a>

        <button class="theme-toggle btn btn-outline-secondary fs-5" title="Alternar Tema" type="button">
          <i class="bi bi-moon-fill"></i>
        </button>

        <div class="dropdown" data-bs-theme="light">
          <a href="#" class="btn btn-outline-primary dropdown-toggle fw-semibold fs-5 d-flex align-items-center" data-bs-toggle="dropdown" role="button" aria-expanded="false">
            <span class="me-1"><?= htmlspecialchars($ong['nome_fantasia'] ?? 'Minha ONG') ?></span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end fs-5 shadow-sm">
            <li><a class="dropdown-item" href="/?url=ong/perfil"><i class="bi bi-person-circle me-2"></i>Perfil</a></li>
            <li><a class="dropdown-item" href="/?url=ong/config"><i class="bi bi-gear me-2"></i>Configurações</a></li>
            <li><a class="dropdown-item" href="/?url=relatorios"><i class="bi bi-bar-chart-line me-2"></i>Relatórios</a></li>
            <li><a class="dropdown-item" href="/?url=historico"><i class="bi bi-clock-history me-2"></i>Histórico</a></li>
            <li><hr class="dropdown-divider" /></li>
            <li><a class="dropdown-item text-danger" href="/?url=logout"><i class="bi bi-box-arrow-right me-2"></i>Sair</a></li>
          </ul>
        </div>
      </nav>
    </div>

    <!-- MOBILE -->
    <nav class="navbar navbar-expand-lg bg-body border-bottom fixed-top shadow-sm d-md-none">
      <div class="container-fluid">
        <a style="color:var(--primary);" class="navbar-brand fw-bold fs-3" href="/?url=home">ConectaVidas+</a>
        <div class="d-flex align-items-center gap-2">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMobile" aria-controls="navbarMobile" aria-expanded="false" aria-label="Alternar navegação">
            <span class="navbar-toggler-icon"></span>
          </button>
        </div>

        <div class="collapse navbar-collapse mt-3" id="navbarMobile">
          <ul class="navbar-nav ms-auto text-center gap-2">
            <li class="mt-2">
              <button class="theme-toggle btn btn-outline-secondary w-100" title="Alternar Tema" type="button">
                <i class="bi bi-moon-fill me-2"></i>Modo
              </button>
            </li>
            <li><a class="nav-link fw-semibold" href="/?url=dashboard"><i class="bi bi-house-door me-2"></i>Início</a></li>
            <li><a class="nav-link fw-semibold" href="/?url=campanha"><i class="bi bi-megaphone me-2"></i>Campanhas</a></li>
            <li><a class="nav-link fw-semibold" href="/?url=empresas"><i class="bi bi-building me-2"></i>Empresas</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="nav-link fw-semibold" href="/?url=ong/perfil"><i class="bi bi-person-circle me-2"></i>Perfil</a></li>
            <li><a class="nav-link fw-semibold" href="/?url=ong/config"><i class="bi bi-gear me-2"></i>Configurações</a></li>
            <li><a class="nav-link fw-semibold" href="/?url=relatorios"><i class="bi bi-bar-chart-line me-2"></i>Relatórios</a></li>
            <li><a class="nav-link fw-semibold" href="/?url=historico"><i class="bi bi-clock-history me-2"></i>Histórico</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="nav-link text-danger fw-semibold" href="/?url=logout"><i class="bi bi-box-arrow-right me-2"></i>Sair</a></li>
            
          </ul>
        </div>
      </div>
    </nav>
  </header>


