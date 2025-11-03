<?php include __DIR__ . '/../../Components/header-home.php'; ?>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!empty($_SESSION['success_message'])): ?>
    <div class="alert alert-success text-center mt-3 mx-auto px-3" style="max-width: 600px;" role="alert">
        <?= htmlspecialchars($_SESSION['success_message']) ?>
    </div>
<?php
    unset($_SESSION['success_message']);
endif;
?>

<main class="container-fluid d-flex flex-column justify-content-center align-items-center min-vh-100 py-4 px-3 bg-light">
    <div class="card shadow-lg border-0 rounded-4 p-4 w-100" style="max-width: 420px;">
        <div class="text-center mb-4">
            <i class="bi bi-person-circle text-primary" style="font-size: 3rem;"></i>
            <h2 class="fw-bold mt-2 text-primary">Bem-vindo(a)</h2>
            <p class="text-muted mb-0 small">Acesse sua conta para continuar</p>
        </div>

        <form action="/?url=login/authenticate" method="POST" novalidate>
            <div class="form-floating mb-3">
                <input type="email" id="email" name="email" class="form-control rounded-3" placeholder="E-mail" required>
                <label for="email">E-mail</label>
            </div>

            <div class="form-floating mb-4">
                <input type="password" id="senha" name="senha" class="form-control rounded-3" placeholder="Senha" required>
                <label for="senha">Senha</label>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold rounded-3 mb-3 shadow-sm">
                <i class="bi bi-box-arrow-in-right me-2"></i>Entrar
            </button>

            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2 text-center">
                <a href="/?url=register" class="btn btn-outline-secondary btn-sm rounded-3 w-100 w-sm-auto">
                   Esqueceu a senha?
                </a>
                <a href="/?url=register" class="btn btn-outline-secondary btn-sm rounded-3 w-100 w-sm-auto">
                    Criar conta
                </a>
            </div>
        </form>
    </div>
</main>

<?php include __DIR__ . '/../../Components/footer.php'; ?>
