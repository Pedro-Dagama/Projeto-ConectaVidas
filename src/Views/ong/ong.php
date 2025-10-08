<?php include __DIR__ . '/../../Components/header.php'; ?>

<div class="container mt-5">
    <?php $tipoUsuario = $_SESSION['user']['tipo_usuario'] ?? '' ?>
    <h1><?= htmlspecialchars($tipoUsuario) ?></h1>
    <p>Você está logado no sistema ConectaVidas.(ong)</p>
    <a href="/?url=logout" class="btn btn-danger mt-3">Sair</a>
</div>

<?php include __DIR__ . '/../../Components/footer.php'; ?>