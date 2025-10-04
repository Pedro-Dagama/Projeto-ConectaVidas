<?php>
<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ConectaVidas+</title>
    <link rel="stylesheet" href="../../../public/css/global.css" />
    <link rel="stylesheet" href="../../../public/css/after-login.css" />
    <link rel="stylesheet" href="../../../public/css/bootstrap.min.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
    />
  </head>
  <body class="d-flex flex-column min-vh-100">
    <!-- Header -->
    <header class="main-header ">
      <div
        class="container-fluid d-flex flex-wrap justify-content-between align-items-center py-2"
      >
        <!-- Logo -->
        <div class="logo mb-2 mb-md-0">
          <span class="fw-bold fs-1">ConectaVidas+</span>
        </div>

        <!-- Search + Menu -->
        <div
          class="d-flex flex-wrap align-items-center gap-5 justify-content-center"
        >
          <!-- Barra de pesquisa -->
          <form class="flex-grow-1 flex-md-grow-0" role="search">
            <input
              type="search"
              class="form-control fs-4"
              placeholder="Buscar..."
              aria-label="Search"
            />
          </form>

          <!-- Menu Dropdown -->
          <div class="dropdown">
            <a
              href="#"
              class="btn btn-outline-secondary dropdown-toggle fw-bold fs-4"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              Categorias
            </a>
            <ul class="dropdown-menu fs-5">
              <li><a class="dropdown-item" href="#">Educação</a></li>
              <li><a class="dropdown-item" href="#">Saúde</a></li>
              <li><a class="dropdown-item" href="#">Meio Ambiente</a></li>
              <li><a class="dropdown-item" href="#">Animais</a></li>
              <li><a class="dropdown-item" href="#">Outros</a></li>
            </ul>
          </div>

          <!-- Avatar -->
          <div class="dropdown menu-user p-2">
            <a
              href="#"
              class="d-flex align-items-center text-decoration-none dropdown-toggle"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
            <!--nome da empresa/ong-->
              <span class="me-2 d-none d-sm-inline text-dark fw-bold fs-3"
                >Empresa</span
              >
              <img
                src="https://github.com/mdo.png"
                alt="avatar"
                width="40"
                height="40"
                class="rounded-circle"
              />
            </a>
            <ul class="dropdown-menu dropdown-menu-end fs-5">
              <li><a class="dropdown-item" href="#">Novo projeto</a></li>
              <li><a class="dropdown-item" href="#">Configurações</a></li>
              <li><a class="dropdown-item" href="#">Perfil</a></li>
              <li><hr class="dropdown-divider" /></li>
              <li><a class="dropdown-item" href="#">Sair</a></li>
            </ul>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow-1">
      <div class="py-3 mx-3">
        <section class="row g-3 justify-content-center">

          <!-- Coluna 1 - Impacto Social  -->
          <div class="col-12 col-md-3  col-sm-8">
            <div class="card shadow-sm h-100 text-center">
              <div class="text-dark fw-bold py-2 fs-3">Impacto Social</div>
              <div class="card-body p-2">
                <div class="d-flex flex-column gap-2 fs-5">
                  <div>
                    <i class="bi bi-flag text-success"></i>
                    <span class="fw-bold">120+</span>
                    <small class="text-muted">Campanhas</small>
                  </div>
                  <div>
                    <i class="bi bi-cash-coin text-primary"></i>
                    <span class="fw-bold">R$ 500k</span>
                    <small class="text-muted">Arrecadados</small>
                  </div>
                  <div>
                    <i class="bi bi-people text-warning"></i>
                    <span class="fw-bold">3.000+</span>
                    <small class="text-muted">Doadores</small>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Coluna 2 - Campanhas  -->
          <div class="col-12 col-md-6 col-lg-6 col-sm-12 mx-auto">
            <div
              class="row g-3 justify-content-center"
              id="campanhas-container"
            >
              <!--  Card de Campanha -->
              <div class="col-12 col-sm-8 col-md-10 col-lg-7">
                <div class="card shadow-sm h-100">
                  <img
                    src="../../../public/img/campanhaTeste.jpeg"
                    class="card-img-top img-fluid"
                    alt="Imagem da campanha"
                  />

                  <div class="card-body p-3 d-flex flex-column">
                    <h6 class="card-title fw-bold fs-1 mb-1">Nome da ONG</h6>
                    <p class="card-text small mb-2 fs-4">
                      Breve descrição da campanha.
                    </p>

                    <div class="mb-2">
                      <small class="fs-4"
                        ><strong>Arrecadado:</strong> R$ 6.000 / R$
                        10.000</small
                      >
                      <div class="progress" style="height: 6px">
                        <div
                          class="progress-bar bg-success"
                          role="progressbar"
                          style="width: 60%"
                          aria-valuenow="60"
                          aria-valuemin="0"
                          aria-valuemax="100"
                        ></div>
                      </div>
                      <small class="text-muted fs-5">Término: 15/11/2025</small>
                    </div>

                    <div
                      class="d-flex justify-content-center gap-2 flex-wrap mb-2"
                    >
                      <a href="#" class="btn btn-outline-success btn-sm"
                        ><i class="bi bi-whatsapp"></i
                      ></a>
                      <a href="#" class="btn btn-outline-primary btn-sm"
                        ><i class="bi bi-facebook"></i
                      ></a>
                      <a href="#" class="btn btn-outline-info btn-sm"
                        ><i class="bi bi-twitter-x"></i
                      ></a>
                    </div>

                    <a
                      href="#"
                      class="btn btn-success btn-lg rounded-pill shadow-sm mt-auto d-block mx-auto px-4 py-2 fs-5"
                      style="transition: transform 0.2s, box-shadow 0.2s"
                    >
                      Doar 🧡
                    </a>
                  </div>
                </div>
              </div>
              <!-- Fim do card -->
                <br>
              <!--  Card de Campanha -->
               <div class="col-12 col-sm-8 col-md-10 col-lg-7">
                <div class="card shadow-sm h-100">
                  <img
                    src="../../../public/img/campanhaTeste.jpeg"
                    class="card-img-top img-fluid"
                    alt="Imagem da campanha"
                  />

                  <div class="card-body p-3 d-flex flex-column">
                    <h6 class="card-title fw-bold fs-1 mb-1">Nome da ONG</h6>
                    <p class="card-text small mb-2 fs-4">
                      Breve descrição da campanha.
                    </p>

                    <div class="mb-2">
                      <small class="fs-4"
                        ><strong>Arrecadado:</strong> R$ 6.000 / R$
                        10.000</small
                      >
                      <div class="progress" style="height: 6px">
                        <div
                          class="progress-bar bg-success"
                          role="progressbar"
                          style="width: 60%"
                          aria-valuenow="60"
                          aria-valuemin="0"
                          aria-valuemax="100"
                        ></div>
                      </div>
                      <small class="text-muted fs-5">Término: 15/11/2025</small>
                    </div>

                    <div
                      class="d-flex justify-content-center gap-2 flex-wrap mb-2"
                    >
                      <a href="#" class="btn btn-outline-success btn-sm"
                        ><i class="bi bi-whatsapp"></i
                      ></a>
                      <a href="#" class="btn btn-outline-primary btn-sm"
                        ><i class="bi bi-facebook"></i
                      ></a>
                      <a href="#" class="btn btn-outline-info btn-sm"
                        ><i class="bi bi-twitter-x"></i
                      ></a>
                    </div>

                    <a
                      href="#"
                      class="btn btn-success btn-lg rounded-pill shadow-sm mt-auto d-block mx-auto px-4 py-2 fs-5"
                      style="transition: transform 0.2s, box-shadow 0.2s"
                    >
                      Doar 🧡
                    </a>
                  </div>
                </div>
                 <!-- Fim do card -->
              </div>
            </div>
          </div>

          <!-- Coluna 3 - Doadores  -->
          <div class="col-12 col-md-3 col-sm-8">
            <div class="card shadow-sm h-100">
              <div class="text-dark fw-bold py-2 fs-3 text-center">
                Maiores Doadores
              </div>
              <ul class="list-group list-group-flush small text-center fs-5">
                <li class="list-group-item">Ana Souza - R$ 1.500</li>
                <li class="list-group-item">João Lima - R$ 1.200</li>
                <li class="list-group-item">Maria Santos - R$ 800</li>
              </ul>
              <div class="card-footer text-center p-2">
                <button class="btn btn-sm btn-outline-secondary">
                  Ver todos
                </button>
              </div>
            </div>
          </div>
        </section>
      </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-light mt-auto py-4">
      <div class="container text-center text-md-start">
        <div class="row">
          <div class="col-md-4 mb-3">
            <h5 class="fw-bold">ConectaVidas+</h5>
            <p class="small">
              Conectando pessoas, empresas e ONGs para transformar vidas.
            </p>
          </div>
          <div class="col-md-4 mb-3">
            <h6 class="fw-bold">Links úteis</h6>
            <ul class="list-unstyled">
              <li>
                <a href="#" class="text-light text-decoration-none">Sobre</a>
              </li>
              <li>
                <a href="#" class="text-light text-decoration-none"
                  >Campanhas</a
                >
              </li>
              <li>
                <a href="#" class="text-light text-decoration-none">Contato</a>
              </li>
            </ul>
          </div>
          <div class="col-md-4 mb-3 text-center">
            <h6 class="fw-bold">Siga-nos</h6>
            <div class="d-flex justify-content-center gap-3">
              <a href="#" class="text-light"
                ><i class="bi bi-facebook fs-4"></i
              ></a>
              <a href="#" class="text-light"
                ><i class="bi bi-instagram fs-4"></i
              ></a>
              <a href="#" class="text-light"
                ><i class="bi bi-twitter-x fs-4"></i
              ></a>
              <a href="#" class="text-light"
                ><i class="bi bi-whatsapp fs-4"></i
              ></a>
            </div>
          </div>
        </div>
        <hr class="border-light" />
        <p class="text-center small mb-0">
          &copy; 2025 ConectaVidas+. Todos os direitos reservados.
        </p>
      </div>
    </footer>

    <script src="../../../public/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
</php>