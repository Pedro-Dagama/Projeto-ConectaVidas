<?php include __DIR__ . '/../../Components/header-doacao-create.php'; ?>

<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$campanha = $campanha ?? null;

function fmt_money($value) {
  return number_format((float)$value, 2, ',', '.');
}
?>

<!-- TÍTULO -->
<section class="text-center mt-5 pt-5">
  <h1 class="fw-bold display-6 text-primary mt-4">Apoie uma Causa</h1>
  <p class="text-muted fs-5 mb-0">Contribua para transformar vidas com sua doação.</p>
</section>

<!-- CONTEÚDO PRINCIPAL -->
<main class="container mt-5 pt-4">
  <div class="row g-5 align-items-start">

    <!-- COLUNA ESQUERDA: CAMPANHA -->
    <div class="col-12 col-lg-7">
      <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <?php if (!empty($campanha['imagem'])): ?>
          <img src="<?= htmlspecialchars($campanha['imagem']) ?>" class="card-img-top" alt="<?= htmlspecialchars($campanha['titulo']) ?>">
        <?php else: ?>
          <img src="https://picsum.photos/800/400" class="card-img-top" alt="Imagem da campanha">
        <?php endif; ?>

        <div class="card-body p-4">
          <!-- Cabeçalho -->
          <div class="d-flex align-items-center mb-4">
            <img src="<?= htmlspecialchars($campanha['ong_logo'] ?? 'https://github.com/mdo.png') ?>" class="rounded-circle me-3" width="60" height="60" alt="Logo da ONG">
            <div>
              <h4 class="mb-1 fw-bold"><?= htmlspecialchars($campanha['titulo'] ?? 'Campanha sem título') ?></h4>
              <small class="text-muted"><?= htmlspecialchars($campanha['ong_nome'] ?? 'ONG não informada') ?></small><br>
              <small class="text-secondary"><i class="bi bi-geo-alt-fill"></i> <?= htmlspecialchars($campanha['localizacao'] ?? 'Localização não informada') ?></small>
            </div>
          </div>

          <!-- Descrição -->
          <p class="fs-5 lh-base mb-4">
            <?= nl2br(htmlspecialchars($campanha['descricao'] ?? 'Sem descrição disponível.')) ?>
          </p>

          <!-- Impacto -->
          <?php if (!empty($campanha['impacto_esperado'])): ?>
            <div class="bg-light rounded-4 p-3 mb-4 border-start border-4 border-success">
              <h6 class="fw-bold mb-2 text-success"><i class="bi bi-bar-chart-fill"></i> Impacto Esperado</h6>
              <p class="mb-0"><?= nl2br(htmlspecialchars($campanha['impacto_esperado'])) ?></p>
            </div>
          <?php endif; ?>

          <!-- Objetivo -->
          <div class="bg-body-tertiary rounded-4 p-3 mb-4">
            <h6 class="fw-bold mb-2 text-primary"><i class="bi bi-flag-fill"></i> Objetivo</h6>
            <p class="mb-0">
              <?= !empty($campanha['data_encerramento'])
                ? 'Arrecadar até <strong>' . date('d/m/Y', strtotime($campanha['data_encerramento'])) . '</strong>.'
                : 'Período de arrecadação não informado.' ?>
            </p>
          </div>

          <!-- Progresso -->
          <?php
          $meta = (float)($campanha['meta'] ?? 0);
          $arrec = (float)($campanha['valor_arrecadado'] ?? 0);
          $percent = $meta > 0 ? min(100, ($arrec / $meta) * 100) : 0;
          ?>
          <div class="mb-4">
            <div class="d-flex justify-content-between fw-semibold mb-1">
              <span>Meta: R$ <?= fmt_money($meta) ?></span>
              <span>Arrecadado: R$ <?= fmt_money($arrec) ?></span>
            </div>
            <div class="progress rounded-pill" style="height: 1rem;">
              <div class="progress-bar bg-success" role="progressbar"
                style="width: <?= (int)$percent ?>%"
                aria-valuenow="<?= (int)$percent ?>" aria-valuemin="0" aria-valuemax="100">
                <?= (int)$percent ?>%
              </div>
            </div>
          </div>

          <!-- Botões Sociais -->
          <div class="d-flex justify-content-around text-center mt-3">
            <button class="btn btn-light d-flex flex-column align-items-center rounded-4 shadow-sm px-4 py-2">
              <i class="bi bi-heart-fill text-danger fs-4"></i>
              <small class="fw-semibold"><?= htmlspecialchars($campanha['numero_curtidas'] ?? '0') ?></small>
            </button>
            <button class="btn btn-light d-flex flex-column align-items-center rounded-4 shadow-sm px-4 py-2">
              <i class="bi bi-share-fill text-primary fs-4"></i>
              <small class="fw-semibold">Compartilhar</small>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- COLUNA DIREITA: DOAÇÃO -->
    <div class="col-12 col-lg-5">
      <!-- Formulário -->
      <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-primary text-white fw-bold text-center rounded-top-4">Apoiar Esta Campanha</div>
        <div class="card-body p-4">

          <?php if (!empty($_SESSION['form_errors'])): ?>
            <div class="alert alert-danger">
              <?php foreach ($_SESSION['form_errors'] as $err): ?>
                <div><?= htmlspecialchars($err) ?></div>
              <?php endforeach; unset($_SESSION['form_errors']); ?>
            </div>
          <?php endif; ?>

          <?php if (!empty($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
              <?= htmlspecialchars($_SESSION['success_message']) ?>
            </div>
            <?php unset($_SESSION['success_message']); ?>
          <?php endif; ?>

          <form id="formDoacao" action="/?url=doacao/store" method="post" novalidate>
            <input type="hidden" name="campanha_id" value="<?= (int)($campanha['id_campanha'] ?? ($_GET['campanha_id'] ?? 0)) ?>">

            <div class="form-floating mb-3">
              <input type="number" step="0.01" min="1" id="valorDoacao" name="valor" class="form-control rounded-3" placeholder="50.00" required>
              <label for="valorDoacao">Valor da Doação (R$)</label>
            </div>

            <div class="form-floating mb-4">
              <select name="forma_pagamento" id="metodoPagamento" class="form-select rounded-3" required>
                <option value="">Selecione o método</option>
                <option value="pix">PIX</option>
                <option value="cartao">Cartão de Crédito</option>
                <option value="boleto">Boleto</option>
                <option value="transferencia">Transferência</option>
              </select>
              <label for="metodoPagamento">Método de Pagamento</label>
            </div>

            <button type="submit" class="btn btn-success w-100 fw-bold py-2 rounded-3 shadow-sm">
              <i class="bi bi-currency-dollar me-1"></i> Confirmar Doação
            </button>
          </form>
        </div>
      </div>

      <!-- Últimos Doadores -->
      <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-body-secondary fw-bold text-center rounded-top-4">
          Últimos Doadores
        </div>
        <ul class="list-group list-group-flush">
          <?php if (!empty($campanha['ultimos_doadores'])): ?>
            <?php foreach ($campanha['ultimos_doadores'] as $d): ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span><strong><?= htmlspecialchars($d['nome']) ?></strong></span>
                <span class="text-success fw-semibold">R$ <?= fmt_money($d['valor']) ?></span>
              </li>
            <?php endforeach; ?>
          <?php else: ?>
            <li class="list-group-item text-center text-muted">Ainda não há doadores.</li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </div>
</main>

<script>
  // Evita duplo envio
  document.getElementById('formDoacao')?.addEventListener('submit', (e) => {
    const btn = e.target.querySelector('button[type="submit"]');
    if (btn) {
      btn.disabled = true;
      btn.textContent = 'Processando...';
    }
  });
</script>

<?php include __DIR__ . '/../../Components/footer-doacao-create.php'; ?>
