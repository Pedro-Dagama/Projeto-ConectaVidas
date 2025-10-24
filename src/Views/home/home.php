<?php include __DIR__ . '/../../Components/header-home.php'; ?>

  <!-- CONTEÚDO PRINCIPAL -->
  <main class="flex-grow-1 pt-5 mt-5">
    <!-- HERO -->
    <section class="container py-5 text-center text-md-start">
      <div class="row align-items-center g-4">
        <div class="col-md-6">
          <span class="text-success fw-bold fs-5">Plataforma para doações</span>
          <h1 class="fw-bold display-5 mt-2">Conecte projetos sociais a quem quer transformar vidas</h1>
          <p class="lead text-body-secondary mt-3">
            Descubra ONGs que precisam de apoio e facilite doações para causas sociais com transparência e praticidade.
          </p>
          <div class="d-flex flex-wrap gap-2 mt-4">
            <a href="#explorar" class="btn btn-success btn-lg">Explorar ONGs</a>
            <a href="#sobre" class="btn btn-outline-secondary btn-lg">Saiba mais</a>
          </div>

          <form class="d-flex mt-4" style="max-width: 480px;" action="/?url=buscar" method="get" role="search" aria-label="Buscar ONGs">
            <input name="q" type="search" class="form-control form-control-lg me-2" placeholder="Buscar ONG, causa ou cidade..." aria-label="Pesquisar" />
            <button class="btn btn-primary btn-lg" type="submit" aria-label="Buscar">Buscar</button>
          </form>
        </div>

        <div class="col-md-6 text-center">
          <img src="https://images.unsplash.com/photo-1534126511673-b6899657816a?w=800&q=60" class="img-fluid rounded shadow-sm" alt="Ilustração ONG" />
        </div>
      </div>
    </section>

    <!-- ONGS EM DESTAQUE -->
    <section id="explorar" class="container py-5">
      <h2 class="fw-bold text-center mb-4">ONGs em destaque</h2>
      <div class="row g-4 justify-content-center">
        <div class="col-md-4">
          <div class="card shadow-sm border-0 rounded-4">
            <img src="../../../public/img/co-an-ft1.png" class="card-img-top" alt="Educação" />
            <div class="card-body text-center">
              <h5 class="card-title fw-bold">Educar para o Futuro</h5>
              <p class="card-text text-body-secondary">ONG dedicada a projetos educacionais em comunidades carentes.</p>
              <a href="#" class="btn btn-outline-success">Ver mais</a>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card shadow-sm border-0 rounded-4">
            <img src="https://source.unsplash.com/600x400/?animals,rescue" class="card-img-top" alt="Animais" />
            <div class="card-body text-center">
              <h5 class="card-title fw-bold">Amigos de Quatro Patas</h5>
              <p class="card-text text-body-secondary">Cuidando de animais abandonados e promovendo adoção responsável.</p>
              <a href="#" class="btn btn-outline-success">Ver mais</a>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card shadow-sm border-0 rounded-4">
            <img src="https://source.unsplash.com/600x400/?environment,trees" class="card-img-top" alt="Meio Ambiente" />
            <div class="card-body text-center">
              <h5 class="card-title fw-bold">Verde Esperança</h5>
              <p class="card-text text-body-secondary">Projetos voltados à preservação ambiental e reflorestamento urbano.</p>
              <a href="#" class="btn btn-outline-success">Ver mais</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- COMO FUNCIONA -->
    <section id="como" class="container py-5">
      <h2 class="fw-bold text-center mb-4">Como funciona</h2>
      <div class="row text-center">
        <div class="col-md-4">
          <div class="p-3">
            <div class="fs-2 text-success mb-2"><i class="bi bi-search-heart"></i></div>
            <h5 class="fw-bold">Encontre</h5>
            <p class="text-body-secondary">Busque ONGs por causa, local ou nome e descubra projetos autênticos.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="p-3">
            <div class="fs-2 text-primary mb-2"><i class="bi bi-chat-heart"></i></div>
            <h5 class="fw-bold">Curtidas</h5>
            <p class="text-body-secondary">Curta o projeto se você se identificar com a causa. Sua curtida aumenta a visibilidade e ajuda a atrair apoiadores e doações.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="p-3">
            <div class="fs-2 text-warning mb-2"><i class="bi bi-heart-arrow"></i></div>
            <h5 class="fw-bold">Doe</h5>
            <p class="text-body-secondary">Contribua com segurança e acompanhe o impacto de sua doação.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- SOBRE -->
    <section id="sobre" class="container py-5 text-center">
      <h2 class="fw-bold mb-3">Sobre o ConectaVidas+</h2>
      <p class="text-body-secondary fs-5 mx-auto" style="max-width: 800px;">
        O ConectaVidas+ é uma plataforma que aproxima quem quer ajudar de quem precisa de apoio.
        Criamos uma ponte entre empresas, ONGs e doadores individuais, com transparência, propósito e impacto real.
      </p>
    </section>
  </main>

</div>

<?php include __DIR__ . '/../../Components/footer-home.php'; ?>