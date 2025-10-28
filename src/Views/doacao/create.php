<?php include __DIR__ . '/../../Components/header-doacao-create.php'; ?>

<?php
// src/Views/doacao/doacao.php
// Exige que $campanha esteja definido (array)
if (session_status() === PHP_SESSION_NONE) session_start();

$campanha = $campanha ?? null;

// Função auxiliar curta
function fmt_money($value)
{
  return number_format((float)$value, 2, ',', '.');
}

?>


<!-- HEADER -->
<header class="main-header">

  <!-- Desktop Header -->
  <div class="d-none d-md-flex container-fluid align-items-center py-2 px-4 border-bottom bg-body fixed-top shadow-sm">
    <!-- Logo -->
    <div class="d-flex align-items-center me-4">
      <a href="/?url=home" class="text-decoration-none text-body" aria-label="ConectaVidas+ home">
        <span class="fw-bold fs-1">ConectaVidas+</span>
      </a>
    </div>

    <!-- Menu direito: alternar tema e menu usuário -->
    <div class="d-flex align-items-center gap-4 ms-auto">
      <!-- Botão alternar tema -->
      <button class="theme-toggle btn btn-outline-secondary fs-5" title="Alternar Tema" aria-label="Alternar tema claro/escuro">
        <i class="bi bi-moon-fill"></i>
      </button>

      <!-- Menu do usuário (mostra nome do usuário se disponível) -->
      <div class="dropdown menu-user p-2" data-bs-theme="light">
        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-body"
          data-bs-toggle="dropdown" aria-expanded="false" aria-label="Menu do usuário">
          <span class="me-2 fw-bold fs-5"><?= htmlspecialchars($_SESSION['user']['nome'] ?? 'Empresa') ?></span>
          <img src="<?= htmlspecialchars($_SESSION['user']['logo'] ?? 'https://github.com/mdo.png') ?>" alt="avatar" width="40" height="40" class="rounded-circle" />
        </a>
        <ul class="dropdown-menu dropdown-menu-end fs-5">
          <li><a class="dropdown-item" href="/?url=empresa">Meu painel</a></li>
          <li><a class="dropdown-item" href="/?url=empresa/doacoes">Minhas doações</a></li>
          <li><a class="dropdown-item" href="/?url=perfil">Perfil</a></li>
          <li>
            <hr class="dropdown-divider" />
          </li>
          <li><a class="dropdown-item" href="/?url=logout">Sair</a></li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Mobile Navbar -->
  <nav class="navbar navbar-expand-lg bg-body border-bottom fixed-top shadow-sm d-md-none">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold fs-3" href="/?url=home">ConectaVidas+</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMobile"
        aria-controls="navbarMobile" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarMobile">
        <ul class="navbar-nav ms-auto">
          <!-- Botão tema -->
          <li class="nav-item">
            <button class="theme-toggle btn btn-outline-secondary w-100 my-2" title="Alternar Tema" aria-label="Alternar tema claro/escuro">
              <i class="bi bi-moon-fill"></i> Tema
            </button>
          </li>

          <!-- Dropdown menu usuário -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle fw-bold" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown"
              aria-expanded="false" aria-label="Menu do usuário">
              <?= htmlspecialchars($_SESSION['user']['nome'] ?? 'Empresa') ?>
            </a>
            <ul class="dropdown-menu" aria-labelledby="userDropdown">
              <li><a class="dropdown-item" href="/?url=empresa">Meu painel</a></li>
              <li><a class="dropdown-item" href="/?url=empresa/doacoes">Minhas doações</a></li>
              <li><a class="dropdown-item" href="/?url=perfil">Perfil</a></li>
              <li>
                <hr class="dropdown-divider" />
              </li>
              <li><a class="dropdown-item" href="/?url=logout">Sair</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>

<!-- Título da Página -->
<section class="text-center mt-5 pt-5">
  <h1 class="fw-bold display-5 mt-4">Doações</h1>
  <p class="text-muted fs-5">
    Explore campanhas solidárias e contribua para transformar vidas.
  </p>
</section>

<!-- CONTEÚDO PRINCIPAL -->
<main class="container-fluid mt-5 pt-5">
  <div class="row g-4 px-3 px-md-5">

    <!-- COLUNA ESQUERDA: Campanha -->
    <div class="col-12 col-md-7">
      <div class="card shadow-sm mb-4">
        <?php if (!empty($campanha) && !empty($campanha['imagem'])): ?>
          <img src="<?= htmlspecialchars($campanha['imagem']) ?>" class="card-img-top" alt="<?= htmlspecialchars($campanha['titulo']) ?>" />
        <?php else: ?>
          <img src="https://picsum.photos/800/400" class="card-img-top" alt="Imagem da campanha" />
        <?php endif; ?>

        <div class="card-body">
          <!-- Cabeçalho da campanha -->
          <div class="d-flex align-items-center mb-3">
            <img src="<?= htmlspecialchars($campanha['ong_logo'] ?? 'https://github.com/mdo.png') ?>" class="rounded-circle me-2" width="50" height="50" alt="<?= htmlspecialchars($campanha['ong_nome'] ?? 'ONG') ?>" />
            <div>
              <h5 class="card-title mb-0 fw-bold"><?= htmlspecialchars($campanha['titulo'] ?? 'Campanha sem título') ?></h5>
              <small class="text-muted"><?= htmlspecialchars($campanha['ong_nome'] ?? 'ONG sem nome') ?></small><br />
              <small class="text-secondary"><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($campanha['localizacao'] ?? '-') ?></small>
            </div>
          </div>

          <!-- Descrição detalhada -->
          <p class="card-text fs-5">
            <?= nl2br(htmlspecialchars($campanha['descricao'] ?? 'Descrição não disponível.')) ?>
          </p>

          <!-- Impacto Esperado (se existir campo) -->
          <?php if (!empty($campanha['impacto_esperado'])): ?>
            <div class="bg-body-secondary rounded-3 p-3 mb-3">
              <h6 class="fw-bold mb-1"><i class="bi bi-bar-chart-fill text-success"></i> Impacto Esperado</h6>
              <p class="mb-0"><?= nl2br(htmlspecialchars($campanha['impacto_esperado'])) ?></p>
            </div>
          <?php endif; ?>

          <!-- Objetivo / Prazo -->
          <div class="bg-body-tertiary rounded-3 p-3 mb-3">
            <h6 class="fw-bold mb-1"><i class="bi bi-flag-fill text-primary"></i> Objetivo</h6>
            <p class="mb-0">
              <?php if (!empty($campanha['data_encerramento'])): ?>
                Arrecadar até <strong><?= htmlspecialchars(date('d/m/Y', strtotime($campanha['data_encerramento']))) ?></strong>.
              <?php else: ?>
                Periodo de arrecadação não informado.
              <?php endif; ?>
            </p>
          </div>

          <!-- Progresso -->
          <?php
          $meta = !empty($campanha['meta']) ? (float)$campanha['meta'] : 0.0;
          $arrec = !empty($campanha['valor_arrecadado']) ? (float)$campanha['valor_arrecadado'] : 0.0;
          $percent = ($meta > 0) ? min(100, ($arrec / $meta) * 100) : 0;
          ?>
          <div class="mb-3">
            <div class="d-flex justify-content-between fw-semibold">
              <span>Meta: R$ <?= fmt_money($meta) ?></span>
              <span>Arrecadado: R$ <?= fmt_money($arrec) ?></span>
            </div>
            <div class="progress" style="height: 1.2rem" aria-label="Progresso da campanha">
              <div class="progress-bar bg-success" role="progressbar"
                style="width: <?= (int)$percent ?>%"
                aria-valuenow="<?= (int)$percent ?>" aria-valuemin="0" aria-valuemax="100">
                <?= (int)$percent ?>%
              </div>
            </div>
          </div>

          <!-- Ações: Curtir / Compartilhar (funcionalidade posterior) -->
          <div class="d-flex justify-content-around fs-4 mt-3">
            <div class="text-center">
              <button class="btn d-flex flex-column align-items-center" aria-label="Curtir a campanha">
                <i class="bi bi-heart fs-4"></i>
                <span class="mt-1 fw-semibold"><?= htmlspecialchars($campanha['numero_curtidas'] ?? '0') ?></span>
              </button>
            </div>
            <div class="text-center">
              <button class="btn d-flex flex-column align-items-center" aria-label="Compartilhar a campanha">
                <i class="bi bi-share fs-3"></i>
                <span class="mt-1 fw-semibold">Compartilhar</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- COLUNA DIREITA: Pagamento e Doadores -->
    <div class="col-12 col-md-5">
      <!-- Formulário de Doação -->
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-body-secondary fw-bold">Apoiar esta Campanha</div>
        <div class="card-body">
          <?php
          // mensagens de erro / sucesso
          if (!empty($_SESSION['form_errors'])) {
            echo '<div class="alert alert-danger" role="alert" aria-live="polite">';
            foreach ($_SESSION['form_errors'] as $err) {
              echo '<div>' . htmlspecialchars($err) . '</div>';
            }
            echo '</div>';
            unset($_SESSION['form_errors']);
          }
          if (!empty($_SESSION['success_message'])) {
            echo '<div class="alert alert-success" role="status">' . htmlspecialchars($_SESSION['success_message']) . '</div>';
            unset($_SESSION['success_message']);
          }
          ?>

          <form id="formDoacao" action="/?url=doacao/store" method="post" novalidate>
            <input type="hidden" name="campanha_id" value="<?= (int)($campanha['id_campanha'] ?? ($_GET['campanha_id'] ?? 0)) ?>">

            <div class="mb-3">
              <label for="valorDoacao" class="form-label fw-semibold">Valor da Doação (R$)</label>
              <input name="valor" id="valorDoacao" type="number" class="form-control" placeholder="Ex: 50.00" required min="1" step="0.01" aria-label="Valor da doação" />
            </div>

            <div class="mb-3">
              <label for="metodoPagamento" class="form-label fw-semibold">Método de Pagamento</label>
              <select name="forma_pagamento" class="form-select" id="metodoPagamento" required aria-label="Selecione o método de pagamento">
                <option value="">Selecione...</option>
                <option value="pix">PIX</option>
                <option value="cartao">Cartão de Crédito</option>
                <option value="boleto">Boleto Bancário</option>
                <option value="transferencia">Transferência</option>
              </select>
            </div>

            <div id="camposPagamento" aria-live="polite">
              <!-- campos adicionais para cartão / boleto podem ser injetados por doacao.js -->
            </div>

            <button type="submit" class="btn btn-success w-100 fw-bold mt-3">Confirmar Doação</button>
          </form>
        </div>
      </div>

      <!-- Últimos Doadores -->
      <div class="card shadow-sm">
        <div class="card-header bg-body-secondary fw-bold">Últimos Doadores</div>
        <ul class="list-group list-group-flush" id="ultimosDoadoresList">
          <?php
          // Se $campanha['ultimos_doadores'] estiver disponível como array, lista dinamicamente
          if (!empty($campanha['ultimos_doadores']) && is_array($campanha['ultimos_doadores'])):
            foreach ($campanha['ultimos_doadores'] as $d):
          ?>
              <li class="list-group-item">
                <strong><?= htmlspecialchars($d['nome']) ?></strong> — R$ <?= fmt_money($d['valor']) ?>
              </li>
            <?php
            endforeach;
          else:
            ?>
            <li class="list-group-item"><strong>Empresa Sol Nascente</strong> — R$ 500,00</li>
            <li class="list-group-item"><strong>Maria Santos</strong> — R$ 150,00</li>
            <li class="list-group-item"><strong>TechCorp</strong> — R$ 1.000,00</li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </div>
</main>

<script>
  // pequena proteção UX: desabilitar botão após submit para evitar double submit
  (function() {
    const form = document.getElementById('formDoacao');
    if (!form) return;
    form.addEventListener('submit', function(e) {
      const btn = form.querySelector('button[type="submit"]');
      if (btn) {
        btn.disabled = true;
        btn.innerText = 'Processando...';
      }
    });
  })();
</script>


<?php include __DIR__ . '/../../Components/footer-doacao-create.php'; ?>