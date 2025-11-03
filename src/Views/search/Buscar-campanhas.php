<?php include __DIR__ . '/../../Components/header-empresa-campanhas.php'; ?> 
<!-- CONTEÚDO PRINCIPAL -->
<main class="flex-grow-1 pt-5 pb-5 mt-4">
  <div class="container py-3">
    <section class="row g-4 justify-content-center">

      <!-- IMPACTO SOCIAL -->
      <div class="col-12 col-md-3 col-sm-10">
        <div class="card shadow-sm h-100 text-center border-0 bg-body rounded-4">
          <div class="card-header bg-transparent fw-bold fs-4 text-primary border-0">
            <i class="bi bi-graph-up-arrow me-2"></i>Impacto Social
          </div>
          <div class="card-body p-4">
            <div class="d-flex flex-column gap-3 fs-5">
              <div><i class="bi bi-flag text-success me-1"></i><strong>120+</strong> <small class="text-muted">Campanhas</small></div>
              <div><i class="bi bi-cash-coin text-primary me-1"></i><strong>R$ 500k</strong> <small class="text-muted">Arrecadados</small></div>
              <div><i class="bi bi-people text-warning me-1"></i><strong>3.000+</strong> <small class="text-muted">Doadores</small></div>
            </div>
          </div>
        </div>
      </div>

      <!-- CAMPANHAS -->
      <div class="col-12 col-md-6 col-lg-6 col-sm-12 mx-auto">
        <div class="row g-4 justify-content-center" id="campanhas-container">

          <!-- CARD DE CAMPANHA -->
          <div class="col-12 col-sm-11 col-md-10">
            <div class="card shadow-sm rounded-4 border-0 overflow-hidden bg-body">
              <!-- Cabeçalho -->
              <div class="d-flex align-items-center justify-content-between p-3">
                <div class="d-flex align-items-center">
                  <img src="https://github.com/mdo.png" class="rounded-circle me-2" width="45" height="45" alt="Avatar ONG" />
                  <div>
                    <h6 class="mb-0 fw-bold fs-5">ONG Esperança Viva</h6>
                    <small class="text-muted">Santos • 2h atrás</small>
                  </div>
                </div>
                <i class="bi bi-three-dots fs-4 text-body-secondary"></i>
              </div>

              <!-- Imagem -->
              <img src="../../../public/img/co-an-ft5.png" class="card-img-top" alt="Imagem da campanha" />

              <!-- Interações -->
              <div class="d-flex justify-content-between align-items-center px-3 pt-2">
                <div class="d-flex gap-3">
                  <i class="bi bi-heart fs-4"></i>
                 <!--<i class="bi bi-send fs-4"></i>  -->            
                  
                </div>
                <i class="bi bi-bookmark fs-4"></i>
              </div>

              <!-- Conteúdo -->
              <div class="card-body p-4">
                <p class="fw-bold mb-1 fs-5">Ajudando Animais de Rua 🐾</p>
                <p class="text-muted fs-6 mb-3">Cada doação ajuda a alimentar e cuidar de cães e gatos abandonados. 💚</p>

                <div class="mb-3">
                  <small class="fs-6"><strong>Arrecadado:</strong> R$ 6.000 / R$ 10.000</small>
                  <div class="progress mt-2" style="height: 8px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 60%;" aria-valuenow="60"></div>
                  </div>
                  <small class="text-muted fs-6 d-block mt-1">Término: 15/11/2025</small>
                </div>

                <a href="#" class="btn btn-success w-100 rounded-pill shadow-sm fw-semibold fs-6">
                  <i class="bi bi-heart-fill me-2"></i>Doar 🧡
                </a>
              </div>
            </div>
          </div>

          <!-- OUTRO CARD -->
          <div class="col-12 col-sm-11 col-md-10">
            <div class="card shadow-sm rounded-4 border-0 overflow-hidden bg-body">
              <div class="d-flex align-items-center justify-content-between p-3">
                <div class="d-flex align-items-center">
                  <img src="https://github.com/mdo.png" class="rounded-circle me-2" width="45" height="45" alt="Avatar ONG" />
                  <div>
                    <h6 class="mb-0 fw-bold fs-5">ONG Mãos Solidárias</h6>
                    <small class="text-muted">Guarujá • 1d atrás</small>
                  </div>
                </div>
                <i class="bi bi-three-dots fs-4 text-body-secondary"></i>
              </div>
              <img src="../../../public/img/co-an-ft5.png" class="card-img-top" alt="Imagem da campanha" />
              <div class="d-flex justify-content-between align-items-center px-3 pt-2">
                <div class="d-flex gap-3">
                  <i class="bi bi-heart fs-4"></i>
                <!--<i class="bi bi-chat fs-4"></i>  --> 
                 <!--<i class="bi bi-send fs-4"></i>  --> 
                </div>
                <i class="bi bi-bookmark fs-4"></i>
              </div>
              <div class="card-body p-4">
                <p class="fw-bold mb-1 fs-5">Doe Amor no Inverno 🧣</p>
                <p class="text-muted fs-6 mb-3">Ajude pessoas em situação de rua a se aquecer neste inverno. ❄️</p>

                <div class="mb-3">
                  <small class="fs-6"><strong>Arrecadado:</strong> R$ 4.500 / R$ 8.000</small>
                  <div class="progress mt-2" style="height: 8px;">
                    <div class="progress-bar bg-success" style="width: 56%;" role="progressbar"></div>
                  </div>
                  <small class="text-muted fs-6 d-block mt-1">Término: 10/12/2025</small>
                </div>

                <a href="#" class="btn btn-success w-100 rounded-pill shadow-sm fw-semibold fs-6">
                  <i class="bi bi-heart-fill me-2"></i>Doar 🧡
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- MAIORES DOADORES -->
      <div class="col-12 col-md-3 col-sm-10">
        <div class="card shadow-sm h-100 border-0 bg-body rounded-4">
          <div class="card-header bg-transparent text-center border-0 fw-bold fs-4 text-primary">
            <i class="bi bi-award me-2"></i>Maiores Doadores
          </div>
          <ul class="list-group list-group-flush text-center">
            <li class="list-group-item bg-body">TechSolutions — <strong>R$ 1.500</strong></li>
            <li class="list-group-item bg-body">Santander — <strong>R$ 1.200</strong></li>
            <li class="list-group-item bg-body">Bradesco — <strong>R$ 800</strong></li>
          </ul>
          <div class="card-footer bg-transparent text-center border-0 pb-3">
            <button class="btn btn-outline-primary btn-sm rounded-pill px-4">
              Ver todos
            </button>
          </div>
        </div>
      </div>

    </section>
  </div>
</main>
  
<?php include __DIR__ . '/../../Components/footer.php'; ?>  
</body>
</html>
