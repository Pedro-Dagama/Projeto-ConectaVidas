<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Gerenciar Campanhas | ConectaVidas+</title>
  <link rel="stylesheet" href="../../../public/css/global.css" />
  <link rel="stylesheet" href="../../../public/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
</head>

<body class="d-flex flex-column min-vh-100 bg-body">
  <!-- Header -->
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
            <span class="me-2 fw-bold fs-5" id="navOngNameText">Instituto Esperança</span>
            <img src="https://picsum.photos/100" alt="avatar" width="40" height="40" class="rounded-circle" />
          </a>
          <ul class="dropdown-menu dropdown-menu-end fs-5">
            <li><a class="dropdown-item" href="#">Nova campanha</a></li>
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

    <!-- Mobile -->
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

      <!-- Criar Nova Campanha -->
      <div class="col-12 col-md-6">
        <section class="card shadow-sm mb-4">
          <div class="card-header fw-bold bg-body-secondary">
            <i class="bi bi-plus-circle me-1"></i> Criar Nova Campanha
          </div>
          <div class="card-body">
            <form action="#" method="post" enctype="multipart/form-data">
              <div class="mb-3"><input type="text" name="titulo" class="form-control" placeholder="Título da campanha" required></div>
              <div class="mb-3">
                <select name="categoria" class="form-select" required>
                  <option value="" selected disabled>Selecione a Categoria</option>
                  <option value="educacao">Educação</option>
                  <option value="saude">Saúde</option>
                  <option value="alimentacao">Meio Ambiente</option>
                  <option value="animais">Animais</option>
                  <option value="outros">Outros</option>
                </select>
              </div>
              <div class="mb-3"><textarea name="descricao" class="form-control" placeholder="Descrição" required></textarea></div>
              <div class="mb-3"><input type="number" name="meta" class="form-control" placeholder="Meta R$" required min="1"></div>
              <div class="mb-3"><input type="date" name="prazo" class="form-control" required></div>
              <div class="mb-3">
                <label for="foto" class="form-label">Foto de Capa</label>
                <input type="file" name="foto" id="foto" class="form-control" accept="image/*" required>
              </div>
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
              <!-- Campanha 1 -->
              <div class="list-group-item py-3">
                <div class="d-flex justify-content-between align-items-start">
                  <div class="me-3">
                    <h6 class="mb-1 fw-bold">Campanha: Doe Calor</h6>
                    <p class="mb-1 text-secondary">Meta: <strong>R$ 10.000</strong> | Arrecadado: <strong>R$ 6.500</strong></p>
                    <p class="mb-1 text-secondary">Curtidas: <strong>245</strong></p>
                    <small class="text-muted">Status: Ativa | Localização: São Paulo, SP</small>
                  </div>
                  <div class="d-flex flex-column gap-2">
                    <button class="btn btn-outline-primary btn-sm"><i class="bi bi-file-earmark-text"></i> Relatório</button>
                    <button class="btn btn-outline-success btn-sm"><i class="bi bi-pencil-square"></i> Editar</button>
                    <button class="btn btn-outline-danger btn-sm"><i class="bi bi-x-circle"></i> Encerrar</button>
                  </div>
                </div>
              </div>

              <!-- Campanha 2 -->
              <div class="list-group-item py-3">
                <div class="d-flex justify-content-between align-items-start">
                  <div class="me-3">
                    <h6 class="mb-1 fw-bold">Campanha: Alimente um Sorriso</h6>
                    <p class="mb-1 text-secondary">Meta: <strong>R$ 5.000</strong> | Arrecadado: <strong>R$ 4.200</strong></p>
                    <p class="mb-1 text-secondary">Curtidas: <strong>198</strong></p>
                    <small class="text-muted">Status: Ativa | Localização: Guarujá, SP</small>
                  </div>
                  <div class="d-flex flex-column gap-2">
                    <button class="btn btn-outline-primary btn-sm"><i class="bi bi-file-earmark-text"></i> Relatório</button>
                    <button class="btn btn-outline-success btn-sm"><i class="bi bi-pencil-square"></i> Editar</button>
                    <button class="btn btn-outline-danger btn-sm"><i class="bi bi-x-circle"></i> Encerrar</button>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </section>
      </div>

    </div>
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
      <hr class="my-1 border-body-secondary" />
      <p class="text-center mb-0 text-body-secondary">&copy; 2025 ConectaVidas+. Todos os direitos reservados.</p>
    </div>
  </footer>

  <script src="../../../public/js/bootstrap.bundle.min.js"></script>
  <script src="../../../public/js/trocar-dark-light.js"></script>
</body>

</html>