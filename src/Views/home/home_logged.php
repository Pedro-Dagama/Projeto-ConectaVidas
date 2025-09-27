<?php include __DIR__ . '/../../Components/header.php'; ?>

<div class="container mt-5">
    <?php
    $nome = htmlspecialchars($_SESSION['user']['nome']);
    echo "<h1>Bem-vindo, $nome!</h1>";
    ?>
    <p>Você está logado no sistema ConectaVidas.</p>
    <a href="/?url=logout" class="btn btn-danger mt-3">Sair</a>
</div>

<?php include __DIR__ . '/../../Components/footer.php'; ?>