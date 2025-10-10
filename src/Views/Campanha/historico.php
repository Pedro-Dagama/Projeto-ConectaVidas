<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Histórico de Doações | ConectaVidas+</title>
  <link rel="stylesheet" href="../../../public/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="d-flex flex-column min-vh-100 bg-body">

<!-- Header -->
<header class="main-header">
  <!-- Desktop -->
  <div class="d-none d-md-flex container-fluid align-items-center py-2 px-4 border-bottom bg-body fixed-top shadow-sm">
    <a href="#" class="text-decoration-none text-body">
      <span class="fw-bold fs-1">ConectaVidas+</span>
    </a>
    <div class="d-flex align-items-center gap-4 ms-auto">
      <button class="theme-toggle btn btn-outline-secondary fs-5" title="Alternar Tema">
        <i class="bi bi-moon-fill"></i>
      </button>
      <div class="dropdown menu-user p-2" data-bs-theme="light">
        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-body" data-bs-toggle="dropdown" aria-expanded="false" id="navOngName">
          <span class="me-2 fw-bold fs-5" id="navOngNameText">Instituto Esperança</span>
          <img src="https://picsum.photos/100" alt="avatar" width="40" height="40" class="rounded-circle">
        </a>
        <ul class="dropdown-menu dropdown-menu-end fs-5">
          <li><a class="dropdown-item active" href="#">Histórico de Doações</a></li>
          <li><a class="dropdown-item" href="criar-campanha.html">Nova Campanha</a></li>
          <li><a class="dropdown-item" href="lista-campanhas.html">Lista de Campanhas</a></li>
          <li><a class="dropdown-item" href="perfil-ong.html">Perfil</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="logout.php">Sair</a></li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Mobile -->
  <nav class="navbar navbar-expand-lg bg-body border-bottom fixed-top shadow-sm d-md-none">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold fs-3" href="#">ConectaVidas+</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMobile" aria-controls="navbarMobile" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarMobile">
        <ul class="navbar-nav w-100">
          <li class="nav-item my-2">
            <button class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#filtroDoacoesModal">
              Filtrar Doações
            </button>
          </li>
          <li class="nav-item my-2">
            <button class="theme-toggle btn btn-outline-secondary w-100" title="Alternar Tema">
              Tema
            </button>
          </li>
          <li class="nav-item my-2">
            <div class="dropdown w-100">
              <button class="btn btn-outline-secondary w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Instituto Esperança
              </button>
              <ul class="dropdown-menu w-100 fs-5">
                <li><a class="dropdown-item active" href="#">Histórico de Doações</a></li>
                <li><a class="dropdown-item" href="criar-campanha.html">Nova Campanha</a></li>
                <li><a class="dropdown-item" href="lista-campanhas.html">Lista de Campanhas</a></li>
                <li><a class="dropdown-item" href="perfil-ong.html">Perfil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="logout.php">Sair</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>

<main class="container mt-5 pt-5">
  <div class="text-center mb-4">
    <h1 class="fw-bold display-5 mt-4">Histórico de Doações</h1>
    <p class="text-muted fs-5">Acompanhe todas as doações recebidas por suas campanhas.</p>
  </div>

  <!-- Resumo -->
  <div class="row mb-4 g-3">
    <div class="col-12 col-md-4">
      <div class="card shadow-sm p-3 border-0 text-center">
        <small class="text-muted">Total Arrecadado (Mês)</small>
        <h4 class="text-success mb-0">R$ 4.560,00</h4>
      </div>
    </div>
    <div class="col-12 col-md-8">
      <form class="row g-2">
        <div class="col-12 col-md">
          <input type="date" class="form-control" placeholder="Data Início">
        </div>
        <div class="col-12 col-md">
          <input type="date" class="form-control" placeholder="Data Fim">
        </div>
        <div class="col-12 col-md">
          <select class="form-select">
            <option selected disabled>Filtrar por Campanha</option>
            <option>Campanha A</option>
            <option>Campanha B</option>
          </select>
        </div>
        <div class="col-12 col-md-auto">
          <button class="btn btn-primary w-100" type="submit"><i class="bi bi-funnel"></i></button>
        </div>
      </form>
    </div>
  </div>

  <!-- Tabela -->
  <div class="table-responsive">
    <table class="table table-hover table-striped shadow-sm align-middle">
      <thead class="bg-body-secondary">
        <tr>
          <th>Data</th>
          <th>Valor</th>
          <th>Doador</th>
          <th>Campanha</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>25/08/2025</td>
          <td class="fw-bold text-success">R$ 50,00</td>
          <td>Maria S. (Anônimo)</td>
          <td>Ajuda aos Animais</td>
          <td><span class="badge text-bg-success">Confirmado</span></td>
          <td><button class="btn btn-sm btn-outline-info"><i class="bi bi-info-circle"></i></button></td>
        </tr>
        <tr>
          <td>24/08/2025</td>
          <td class="fw-bold text-success">R$ 200,00</td>
          <td>João P. Silva</td>
          <td>Reforma Escolar</td>
          <td><span class="badge text-bg-success">Confirmado</span></td>
          <td><button class="btn btn-sm btn-outline-info"><i class="bi bi-info-circle"></i></button></td>
        </tr>
        <tr>
          <td>23/08/2025</td>
          <td class="fw-bold text-warning">R$ 10,00</td>
          <td>Anônimo</td>
          <td>Meio Ambiente Limpo</td>
          <td><span class="badge text-bg-warning">Pendente</span></td>
          <td><button class="btn btn-sm btn-outline-info"><i class="bi bi-info-circle"></i></button></td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- Paginação -->
  <nav class="d-flex justify-content-center mt-4">
    <ul class="pagination">
      <li class="page-item disabled"><a class="page-link" href="#">Anterior</a></li>
      <li class="page-item active"><a class="page-link" href="#">1</a></li>
      <li class="page-item"><a class="page-link" href="#">2</a></li>
      <li class="page-item"><a class="page-link" href="#">3</a></li>
      <li class="page-item"><a class="page-link" href="#">Próxima</a></li>
    </ul>
  </nav>
</main>

<!-- Footer -->
<footer class="bg-body-tertiary text-body py-2 mt-auto" data-bs-theme="dark">
  <div class="container text-center text-md-start small">
    <div class="row">
      <div class="col-md-4 mb-2">
        <h5 class="fw-bold fs-5">ConectaVidas+</h5>
        <p>Conectando pessoas, empresas e ONGs para transformar vidas.</p>
      </div>
      <div class="col-md-4 mb-2">
        <h6 class="fw-bold">Links úteis</h6>
        <ul class="list-unstyled">
          <li><a href="#" class="text-body-secondary text-decoration-none">Sobre</a></li>
          <li><a href="#" class="text-body-secondary text-decoration-none">Campanhas</a></li>
          <li><a href="#" class="text-body-secondary text-decoration-none">Contato</a></li>
        </ul>
      </div>
      <div class="col-md-4 mb-2 text-center">
        <h6 class="fw-bold">Siga-nos</h6>
        <div class="d-flex justify-content-center gap-2">
          <a href="#" class="text-body"><i class="bi bi-facebook fs-5"></i></a>
          <a href="#" class="text-body"><i class="bi bi-instagram fs-5"></i></a>
          <a href="#" class="text-body"><i class="bi bi-twitter-x fs-5"></i></a>
          <a href="#" class="text-body"><i class="bi bi-whatsapp fs-5"></i></a>
        </div>
      </div>
    </div>
    <hr class="my-1 border-body-secondary">
    <p class="text-center mb-0 text-body-secondary">&copy; 2025 ConectaVidas+. Todos os direitos reservados.</p>
  </div>
</footer>

<script src="../../../public/js/bootstrap.bundle.min.js"></script>
<script src="../../../public/js/trocar-dark-light.js"></script>
</body>
</html>
