<?php include __DIR__ . '/../../Components/header-cadastro-empresa.php'; ?>

<?php if (!empty($error)): ?>
    <div class="container mt-3">
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    </div>
<?php endif; ?>

<main>
    <div class="imagem-cadastro" style="background: url('/img/co-ft1.png')"></div>

    <div class="formulario-cadastro">
        <div class="w-100" style="max-width: 600px">
            <!-- Título do Formulário -->
            <h1 class="mb-4 mt-4 fs-5 text-center">Cadastro de Empresa</h1>

            <form action="/?url=empresa/store" method="POST">
                <!-- Informações Básicas -->
                <fieldset class="border p-3 mb-4 rounded">
                    <legend class="fw-bold">Informações Básicas</legend>

                    <div class="mb-3">
                        <label for="razao_social" class="form-label">Razão Social</label>
                        <input type="text" name="razao_social" id="razao_social" class="form-control" placeholder="Digite o nome da empresa" value="<?= htmlspecialchars($_POST['razao_social'] ?? '') ?>" required />
                    </div>

                    <div class="mb-3">
                        <label for="nome_fantasia" class="form-label">Nome Fantasia</label>
                        <input type="text" name="nome_fantasia" id="nome_fantasia" class="form-control" placeholder="Digite o nome fantasia" value="<?= htmlspecialchars($_POST['nome_fantasia'] ?? '') ?>" />
                    </div>

                    <div class="mb-3">
                        <label for="cnpj" class="form-label">CNPJ</label>
                        <input type="text" name="cnpj" id="cnpj" class="form-control" placeholder="Digite o CNPJ da empresa" value="<?= htmlspecialchars($_POST['cnpj'] ?? '') ?>" required />
                    </div>

                    <div class="mb-3">
                        <label for="cep" class="form-label">CEP</label>
                        <input type="text" name="cep" id="cep" class="form-control" placeholder="00000-000" value="<?= htmlspecialchars($_POST['cep'] ?? '') ?>" required />
                    </div>

                    <div class="mb-3 d-flex gap-2">
                        <div class="flex-grow-1">
                            <label for="endereco" class="form-label">Endereço</label>
                            <input type="text" name="endereco" id="endereco" class="form-control" placeholder="Rua / Logradouro" value="<?= htmlspecialchars($_POST['endereco'] ?? '') ?>" readonly required />
                        </div>
                        <div style="width: 100px;">
                            <label for="numero" class="form-label">Número</label>
                            <input type="text" name="numero" id="numero" class="form-control" placeholder="Nº" value="<?= htmlspecialchars($_POST['numero'] ?? '') ?>" required />
                        </div>
                    </div>

                    <div class="mb-3 d-flex gap-2">
                        <div class="flex-grow-1">
                            <label for="cidade" class="form-label">Cidade</label>
                            <input type="text" name="cidade" id="cidade" class="form-control" placeholder="Cidade" value="<?= htmlspecialchars($_POST['cidade'] ?? '') ?>" required />
                        </div>
                        <div style="width: 80px;">
                            <label for="estado" class="form-label">Estado</label>
                            <input type="text" name="estado" id="estado" class="form-control" placeholder="UF" value="<?= htmlspecialchars($_POST['estado'] ?? '') ?>" required />
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail Corporativo</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Digite o e-mail da empresa" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required />
                    </div>

                    <div class="mb-3">
                        <label for="telefone" class="form-label">Telefone / WhatsApp</label>
                        <input type="tel" name="telefone" id="telefone" class="form-control" placeholder="(00) 00000-0000" value="<?= htmlspecialchars($_POST['telefone'] ?? '') ?>" required />
                    </div>
                </fieldset>

                <!-- Acesso ao Sistema -->
                <fieldset class="border p-3 mb-4 rounded">
                    <legend class="fw-bold">Acesso ao Sistema</legend>

                    <div class="mb-3">
                        <label for="nome" class="form-label">Usuário</label>
                        <input type="text" name="nome" id="nome" class="form-control" placeholder="Crie um nome de usuário" value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" required />
                    </div>

                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" name="senha" id="senha" class="form-control" placeholder="Crie uma senha segura" required />
                    </div>

                    <div class="mb-3">
                        <label for="nova_senha" class="form-label">Confirmar Senha</label>
                        <input type="password" name="nova_senha" id="nova_senha" class="form-control" placeholder="Repita a senha" required />
                    </div>
                </fieldset>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-4 py-2">Cadastrar Empresa</button>
                </div>
            </form>
        </div>
    </div>
</main>

<script src="/js/bootstrap.bundle.min.js"></script>
<script src="/js/cep-address.js"></script>
</body>

</html>