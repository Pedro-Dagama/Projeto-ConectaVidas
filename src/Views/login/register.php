<?php include __DIR__ . '/../../Components/header.php'; ?>
<?php if (!empty($error)): ?>
    <div class="alert alert-danger text-center mb-3" role="alert">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>
<div class="d-flex justify-content-center align-items-center vh-100" style="background-color: #f8f9fa;">
    <form action="/?url=register/create" method="POST" class="p-5 border rounded shadow bg-white" style="min-width: 320px; max-width: 450px; width: 100%;">
        <h2 class="mb-4 text-center">Criar Conta</h2>

        <div class="form-floating mb-3">
            <input type="text" id="name" name="name" class="form-control" placeholder="Nome completo" required>
            <label for="name">Nome Completo</label>
        </div>

        <div class="form-floating mb-3">
            <input type="email" id="email" name="email" class="form-control" placeholder="E-mail" required>
            <label for="email">E-mail</label>
        </div>

        <div class="form-floating mb-3">
            <select id="tipousuario" name="tipousuario" class="form-control" required>
                <option value="administrador">Administrador</option>
                <option value="empresa">Empresa</option>
                <option value="ong">ONG</option>
            </select>
            <label for="tipousuario">Tipo de Usuário</label>
        </div>

        <div class="form-floating mb-3">
            <input type="password" id="password" name="password" class="form-control" placeholder="Senha" required>
            <label for="password">Senha</label>
        </div>

        <div class="form-floating mb-3">
            <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirme a Senha" required>
            <label for="confirm_password">Confirme a Senha</label>
        </div>

        <button type="submit" class="btn btn-success w-100 mb-3">Registrar</button>

        <div class="text-center">
            <a href="/?url=login" class="text-decoration-none">Já tem conta? Entrar</a>
        </div>
    </form>
</div>
<?php include __DIR__ . '/../../Components/footer.php'; ?>