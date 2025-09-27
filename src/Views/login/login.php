<?php include __DIR__ . '/../../Components/header.php'; ?>
<?php if (!empty($error)): ?>
    <div class="alert alert-danger text-center mt-3" role="alert">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-center align-items-center vh-100">
    <form action="/?url=login/authenticate" method="POST" class="p-5 border rounded shadow" style="min-width: 320px; max-width: 400px; width: 100%;">
        <h2 class="mb-4 text-center">Entrar</h2>

        <div class="form-floating mb-3">
            <input type="email" id="email" name="email" class="form-control" placeholder="E-mail" required>
            <label for="email">E-mail</label>
        </div>

        <div class="form-floating mb-3">
            <input type="password" id="senha" name="senha" class="form-control" placeholder="Senha" required>
            <label for="senha">Senha</label>
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-3">Entrar</button>

        <div class="d-flex justify-content-between">
            <a href="#" class="text-decoration-none">Esqueceu a senha?</a>
            <!-- <a href="#" class="btn btn-outline-secondary btn-sm">Criar conta</a> -->
            <a href="/?url=register" class="btn btn-outline-secondary btn-sm">Criar conta</a>
        </div>
    </form>
</div>
<?php include __DIR__ . '/../../Components/footer.php'; ?>