<?php include __DIR__ . '/../../Components/header-home.php'; ?>

<div class="container">

  <header>
    <div class="container nav">
      <a class="brand" href="#top" style="font-weight:800; font-size:1.2rem; color:black; text-decoration:none;">
        ConectaVidas+
      </a>
      <nav>
        <ul>
          <li><a href="#explorar">Explorar</a></li>
          <li><a href="#sobre">Sobre</a></li>
          <li><a href="#como">Como funciona</a></li>
        </ul>
      </nav>

      <div class="actions">
        <button class="menu-btn" id="menuBtn" aria-label="menu">☰</button>
        <a class="btn secondary" href="/?url=login">Entrar</a>
        <a class="btn" href="/?url=empresa/create">Criar Empresa</a>
        <a class="btn" href="/?url=ong/create">Criar Ong</a>
        <button class="btn" onclick="location.href='#cadastro'">Quero doar</button>
      </div>
    </div>
  </header>

  <main class="container">
    <!-- HERO -->
    <section class="hero" aria-label="Apresentação">
      <div class="hero-left">
        <span class="kicker">Plataforma para doações</span>
        <h1>Conecte projetos sociais a quem quer transformar vidas</h1>
        <p class="lead">Descubra ONGs que precisam de apoio e facilite doações para causas sociais com transparência e praticidade.</p>

        <div class="hero-cta">
          <button class="btn" onclick="location.href='#explorar'">Explorar ONGs</button>
          <a class="btn secondary" href="#sobre">Saiba mais</a>
        </div>

        <div class="search-card" style="max-width:560px">
          <input type="search" id="searchInput" placeholder="Buscar por ONG, causa ou cidade..." />
          <button onclick="doSearch()">Buscar</button>
        </div>
      </div>

      <div class="hero-right">
        <div class="mock-card">
          <img src="https://images.unsplash.com/photo-1534126511673-b6899657816a?w=800&q=60" alt="Exemplo" style="border-radius:10px;margin-bottom:0.6rem">
          <div style="display:flex;justify-content:space-between;align-items:center">
            <div>
              <strong>Centro de Apoio</strong>
              <div style="color:var(--muted);font-size:0.9rem">Apoio às famílias</div>
            </div>
            <div style="text-align:right;color:var(--muted);font-size:0.9rem">R$ 0 doado</div>
          </div>
        </div>
      </div>
    </section>

    <!-- ONGS GRID -->
    <section id="explorar" class="ngos">
      <h2 style="margin:0 0 1rem 0">ONGs em destaque</h2>
      <div class="ngos-grid" id="ngosGrid">
        <!-- Cards serão inseridos via JS -->
      </div>
    </section>

    <!-- HOW IT WORKS -->
    <section id="como" class="how">
      <div>
        <h2>Como funciona</h2>
        <p class="small" style="max-width:46ch;color:var(--muted)">Encontre projetos, verifique informações e doe com segurança. A plataforma facilita o contato entre instituições e doadores.</p>

        <div class="steps" style="margin-top:1rem">
          <div class="step">
            <div class="icon">1</div>
            <div>
              <strong>Encontre</strong>
              <div style="color:var(--muted);font-size:0.95rem">Busque ONGs por causa, local ou nome.</div>
            </div>
          </div>

          <div class="step">
            <div class="icon">2</div>
            <div>
              <strong>Converse</strong>
              <div style="color:var(--muted);font-size:0.95rem">Veja o contato e as necessidades do projeto.</div>
            </div>
          </div>

          <div class="step">
            <div class="icon">3</div>
            <div>
              <strong>Doe</strong>
              <div style="color:var(--muted);font-size:0.95rem">Contribua com segurança e acompanhe os resultados.</div>
            </div>
          </div>
        </div>
      </div>

      <div>
        <h3 style="margin-top:0">Por que usar o ConectaVidas+</h3>
        <p style="color:var(--muted)">Transparência, facilidade e alcance — a plataforma ajuda projetos a ganhar visibilidade e doadores a encontrar causas confiáveis.</p>
        <div style="display:flex;gap:0.6rem;margin-top:1rem">
          <button class="btn">Quero doar</button>
          <button class="btn secondary">Cadastrar ONG</button>
        </div>
      </div>
    </section>

  </main>

  <!-- Footer -->
  <footer>
    <div class="container foot-grid">
      <div>
        <strong>ConectaVidas+</strong>
        <div class="small" style="margin-top:6px">© <span id="year"></span> ConectaVidas+. Todos os direitos reservados.</div>
      </div>

      <div style="display:flex;gap:0.8rem;align-items:center">
        <a href="#sobre" class="small">Sobre</a>
        <a href="#contato" class="small">Contato</a>
        <a href="#privacidade" class="small">Privacidade</a>
      </div>
    </div>
  </footer>
</div>
<?php include __DIR__ . '/../../Components/footer-home.php'; ?>