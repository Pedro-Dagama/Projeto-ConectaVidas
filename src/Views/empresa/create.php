<?php include __DIR__ . '/../../Components/header-cadastro-empresa.php'; ?>

<?php if (!empty($error)): ?>
    <div class="container mt-3">
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    </div>
<?php endif; ?>

<main>
    <!-- Lado esquerdo com imagem -->
    <div class="imagem-cadastro" style="background: url('/img/co-ft1.png')"></div>

    <!-- Lado direito com formulário -->
    <div class="formulario-cadastro">
        <div class="w-100" style="max-width: 600px">
            <form action="/?url=empresa/store" method="POST">
                <!-- Informações Básicas -->
                <h1 class="mb-4 mt-4 fs-5 text-center">Cadastro de Empresa</h1>
                <!-- DADOS ESSENCIAIS -->
                <fieldset class="border p-3 mb-4 rounded">
                    <legend class="fw-bold">Informações Básicas</legend>

                    <div class="mb-3">
                        <label for="razao_social" class="form-label">Razão Social</label>
                        <input
                            type="text"
                            name="razao_social"
                            id="razao_social"
                            class="form-control"
                            placeholder="Digite o nome da empresa"
                            value="<?= htmlspecialchars($_POST['razao_social'] ?? '') ?>"
                            required />
                    </div>

                    <div class="mb-3">
                        <label for="nome_fantasia" class="form-label">Nome Fantasia</label>
                        <input
                            type="text"
                            name="nome_fantasia"
                            id="nome_fantasia"
                            class="form-control"
                            placeholder="Digite o nome fantasia"
                            value="<?= htmlspecialchars($_POST['nome_fantasia'] ?? '') ?>" />
                    </div>

                    <!--                     <div class="mb-3">
                        <label for="porte" class="form-label">Porte da Empresa</label>
                        <select name="porte" id="porte" class="form-select" >
                            <option value="" disabled selected>-- Selecione --</option>
                            <option value="mei">
                                MEI - Microempreendedor Individual
                            </option>
                            <option value="me">ME - Microempresa</option>
                            <option value="epp">EPP - Empresa de Pequeno Porte</option>
                            <option value="media">Média Empresa</option>
                            <option value="grande">Grande Empresa</option>
                        </select>
                    </div> -->

                    <div class="mb-3">
                        <label for="cnpj" class="form-label">CNPJ</label>
                        <input
                            type="text"
                            name="cnpj"
                            id="cnpj"
                            class="form-control"
                            placeholder="Digite o CNPJ da empresa"
                            value="<?= htmlspecialchars($_POST['cnpj'] ?? '') ?>"
                            required />
                    </div>

                    <div class="mb-3">
                        <label for="responsavel_email" class="form-label">E-mail Corporativo</label>
                        <input
                            type="email"
                            name="responsavel_email"
                            id="responsavel_email"
                            class="form-control"
                            placeholder="Digite o e-mail da empresa"
                            value="<?= htmlspecialchars($_POST['responsavel_email'] ?? '') ?>"
                            required />
                    </div>

                    <div class="mb-3">
                        <label for="telefone" class="form-label">Telefone / WhatsApp</label>
                        <input
                            type="tel"
                            name="telefone"
                            id="telefone"
                            class="form-control"
                            placeholder="(00) 00000-0000"
                            value="<?= htmlspecialchars($_POST['telefone'] ?? '') ?>"
                            required />
                    </div>
                </fieldset>

                <!-- Dados do usuário responsável -->
                <fieldset class="border p-3 mb-4 rounded">
                    <legend class="fw-bold">Acesso ao Sistema</legend>

                    <div class="mb-3">
                        <label for="responsavel_nome" class="form-label">Usuário</label>
                        <input
                            type="text"
                            name="responsavel_nome"
                            id="responsavel_nome"
                            class="form-control"
                            placeholder="Crie um nome de usuário"
                            value="<?= htmlspecialchars($_POST['responsavel_nome'] ?? '') ?>"
                            required />
                    </div>

                    <div class="mb-3">
                        <label for="responsavel_senha" class="form-label">Senha</label>
                        <input
                            type="password"
                            name="responsavel_senha"
                            id="responsavel_senha"
                            class="form-control"
                            placeholder="Crie uma senha segura"
                            required />
                    </div>

                    <div class="mb-3">
                        <label for="responsavel_confirmar_senha" class="form-label">Confirmar Senha</label>
                        <input
                            type="password"
                            name="responsavel_confirmar_senha"
                            id="responsavel_confirmar_senha"
                            class="form-control"
                            placeholder="Repita a senha"
                            required />
                    </div>
                </fieldset>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-4 py-2">
                        Cadastrar Empresa
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
<script src="/js/bootstrap.bundle.min.js"></script>
</body>

</html>