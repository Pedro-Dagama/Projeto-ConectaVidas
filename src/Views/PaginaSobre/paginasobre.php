<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8" />    
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sobre | ConectaVidas+</title>
    <link rel="stylesheet" href="../../../public/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="../../../public/css/global.css" />
    <link rel="stylesheet" href="../../../public/css/home-style.css" />
</head>

<body class="d-flex flex-column min-vh-100 bg-body">
    <!-- Header -->
    <header class="main-header bg-body border-bottom fixed-top shadow-sm">
    <div class="container-fluid d-flex align-items-center justify-content-between py-2 px-4">
        <a class="text-decoration-none fw-bold fs-3 text-body" href="#top">ConectaVidas+</a>

        <!-- NAV DESKTOP -->
        <nav class="d-none d-md-block">
        <ul class="nav gap-3 fs-5">
            <li class="nav-item"><a class="nav-link text-body" href="#explorar">Explorar</a></li>
            <li class="nav-item"><a class="nav-link text-body" href="#sobre">Sobre</a></li>
            <li class="nav-item"><a class="nav-link text-body" href="#como">Como funciona</a></li>
        </ul>
        </nav>

        <!-- AÇÕES -->
        <div class="d-flex align-items-center gap-2">
            <a class="btn btn-outline-primary">Entrar</a>
            <a class="btn btn-primary">Criar Empresa</a>
            <a class="btn btn-primary">Criar Ong</a>
            <button class="btn btn-success">Quero doar</button>

            <!-- MENU MOBILE -->
            <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#mobileMenu" aria-controls="mobileMenu" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </div>

    <!-- MENU MOBILE -->
    <div class="collapse bg-body border-top d-md-none shadow-sm" id="mobileMenu">
        <ul class="nav flex-column p-3 fs-5">
        <li class="nav-item"><a class="nav-link" href="#explorar">Explorar</a></li>
        <li class="nav-item"><a class="nav-link" href="#sobre">Sobre</a></li>
        <li class="nav-item"><a class="nav-link" href="#como">Como funciona</a></li>
        <li><hr></li>
        <li><a class="btn btn-outline-primary w-100 mb-2" href="/?url=login">Entrar</a></li>
        <li><a class="btn btn-primary w-100 mb-2" href="/?url=empresa/create">Criar Empresa</a></li>
        <li><a class="btn btn-primary w-100 mb-2" href="/?url=ong/create">Criar Ong</a></li>
        <li><button class="btn btn-success w-100">Quero doar</button></li>
        </ul>
    </div>
</header>


<main class="mt-5 pt-5">

    <section class="d-flex flex-column justify-content-center align-items-center py-5 bg-body-tertiary" style="min-height: 200px;">
        <div class="text-center">
            <h1 class="fw-bold display-5">Sobre o ConectaVidas+</h1>
            <p class="lead text-body-secondary mt-3" style="white-space: nowrap;">
            Uma plataforma que conecta solidariedade e tecnologia para transformar vidas.
            </p>
        </div>
    </section>

    <!-- CONTEXTO SOCIAL -->
    <section class="py-5">
      <div class="container">
        <div class="row align-items-center g-4">
          <div class="col-md-6">
            <h2 class="fw-bold mb-3">A realidade Social Brasileira</h2>
            <p>O Brasil enfrenta desafios profundos de desigualdade social e econômica, que afetam especialmente populações em situação de vulnerabilidade.
            Milhares de famílias ainda dependem de iniciativas solidárias para garantir acesso à alimentação, saúde, moradia e educação.
            Mulheres, jovens, minorias e comunidades periféricas são os grupos mais afetados, vivendo realidades que exigem respostas colaborativas e soluções inovadoras.
            Nesse cenário, fortalecer redes de solidariedade e promover a inclusão social se tornam ações urgentes e possíveis por meio da tecnologia.</p>
          </div>
          <div class="col-md-6 text-center">
            <img src="../../../public/img/co-ga-ft1.png" 
                class="img-fluid rounded shadow-sm" 
                alt="Comunidades em apoio">
          </div>
        </div>
      </div>
    </section>

    <!-- SOLUÇÃO -->
    <section class="py-5 bg-body-tertiary">
      <div class="container text-center">
        <h2 class="fw-bold mb-4">A solução: ConectaVidas+</h2>
        <p class="mx-auto mb-5" style="max-width: 800px;">
        O ConectaVidas+ é uma plataforma digital que une empresas, ONGs e cidadãos em torno de um mesmo propósito: transformar vidas por meio da solidariedade.
        Mais do que um espaço de doações, é uma ponte segura e transparente entre quem deseja ajudar e quem precisa de apoio.
        O sistema facilita o engajamento de empresas socialmente responsáveis e fortalece a visibilidade das organizações do terceiro setor, criando um ambiente confiável e acessível para todos os envolvidos.
        </p>

        <div class="row g-4">
          <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
              <div class="card-body">
                <i class="bi bi-people-fill fs-1 text-primary"></i>
                <h5 class="fw-bold mt-3">ONGs e OSCs</h5>
                <p>Divulgam campanhas de arrecadação e ampliam a visibilidade de seus projetos, 
                    fortalecendo a confiança e a transparência junto aos doadores.</p>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
              <div class="card-body">
                <i class="bi bi-building fs-1 text-success"></i>
                <h5 class="fw-bold mt-3">Empresas</h5>
                <p>Demonstram responsabilidade social, promovem engajamento comunitário e 
                    reforçam seu valor de marca ao apoiar causas que geram transformação real.</p>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
              <div class="card-body">
                <i class="bi bi-heart-fill fs-1 text-danger"></i>
                <h5 class="fw-bold mt-3">Doadores</h5>
                <p>Contribuem de forma simples, direta e segura, acompanhando o impacto de suas doações 
                    em tempo real e fortalecendo a cultura da solidariedade.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- IMPACTO -->
    <section class="py-5 bg-body-tertiary">
        <div class="container text-center">
        <h2 class="fw-bold mb-4">Impacto Social e Propósito</h2>
        <p class="mx-auto mb-4" style="max-width: 800px;">
        O ConectaVidas+ nasce com o propósito de tornar o bem mais acessível, transparente e eficiente.
        Cada funcionalidade foi pensada para fortalecer o terceiro setor e democratizar o acesso à filantropia digital, garantindo que 100% das doações cheguem às instituições que realmente fazem a diferença.
        Ao conectar pessoas, empresas e organizações sociais, criamos uma rede de apoio colaborativa que impulsiona a transformação social de forma contínua e sustentável.</p>    
        <p class="lead text-body-secondary mb-4" 
        style="display: inline-block; white-space: nowrap;">
        Descubra histórias reais e participe de iniciativas que estão mudando vidas.</p>

        <div class="mt-3">
            <button class="btn btn-success btn-lg">
                Explorar Campanhas
            </button>
        </div>
      </div>
    </section>


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