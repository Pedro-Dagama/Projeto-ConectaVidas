<?php include __DIR__ . '/../../Components/header-cadastro-ong.php'; ?>

<?php if (!empty($error)): ?>
    <div class="container mt-3">
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    </div>
<?php endif; ?>

<main>
    <!-- Lado esquerdo com imagem -->
    <div class="imagem-cadastro" style="background: url('/img/co-ft3.png')"></div>

    <!-- Lado direito com formulário -->
    <div class="formulario-cadastro" style="">
        <div class="w-100" style="max-width: 600px">
            <form action="/?url=ong/store" method="POST">
                <h1 class="mb-4 mt-4 fs-5 text-center">Cadastro de ONG</h1>

                <!-- DADOS ESSENCIAIS -->
                <fieldset class="border p-3 mb-4 rounded">
                    <legend class="fw-bold">Informações Básicas</legend>

                    <div class="mb-3">
                        <label for="nomeOng" class="form-label">Nome da ONG</label>
                        <input
                            type="text"
                            name="razao_social"
                            id="nomeOng"
                            class="form-control"
                            placeholder="Digite o nome da ONG"
                            required
                            value="<?= htmlspecialchars($_POST['razao_social'] ?? '') ?>" />
                    </div>

                    <div class="mb-3">
                        <label for="causa" class="form-label">Causa / Atuação</label>
                        <select name="area_atuacao" id="causa" class="form-select" required>
                            <option value="" disabled <?= empty($_POST['area_atuacao']) ? 'selected' : '' ?>>-- Selecione --</option>
                            <option value="animais" <?= (($_POST['area_atuacao'] ?? '') === 'animais') ? 'selected' : '' ?>>Proteção Animal</option>
                            <option value="criancas" <?= (($_POST['area_atuacao'] ?? '') === 'criancas') ? 'selected' : '' ?>>Crianças e Adolescentes</option>
                            <option value="idosos" <?= (($_POST['area_atuacao'] ?? '') === 'idosos') ? 'selected' : '' ?>>Apoio a Idosos</option>
                            <option value="meioambiente" <?= (($_POST['area_atuacao'] ?? '') === 'meioambiente') ? 'selected' : '' ?>>Meio Ambiente</option>
                            <option value="educacao" <?= (($_POST['area_atuacao'] ?? '') === 'educacao') ? 'selected' : '' ?>>Educação</option>
                            <option value="saude" <?= (($_POST['area_atuacao'] ?? '') === 'saude') ? 'selected' : '' ?>>Saúde</option>
                            <option value="assistencia" <?= (($_POST['area_atuacao'] ?? '') === 'assistencia') ? 'selected' : '' ?>>Assistência Social</option>
                            <option value="outros" <?= (($_POST['area_atuacao'] ?? '') === 'outros') ? 'selected' : '' ?>>Outros</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="responsavel" class="form-label">Responsável</label>
                        <input
                            type="text"
                            name="responsavel_nome"
                            id="responsavel"
                            class="form-control"
                            placeholder="Nome completo do responsável"
                            required
                            value="<?= htmlspecialchars($_POST['responsavel_nome'] ?? '') ?>" />
                    </div>

                    <div class="mb-3">
                        <label for="cnpj" class="form-label">CNPJ</label>
                        <input
                            type="text"
                            name="cnpj"
                            id="cnpj"
                            class="form-control"
                            placeholder="Digite o CNPJ da ONG"
                            required
                            value="<?= htmlspecialchars($_POST['cnpj'] ?? '') ?>" />
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail (do responsável)</label>
                        <input
                            type="email"
                            name="responsavel_email"
                            id="email"
                            class="form-control"
                            placeholder="Digite o e-mail do responsável"
                            required
                            value="<?= htmlspecialchars($_POST['responsavel_email'] ?? '') ?>" />
                        <small class="form-text text-muted">Usaremos este e-mail para login. (O campo 'e-mail institucional' não está sendo armazenado separadamente por enquanto.)</small>
                    </div>

                    <div class="mb-3">
                        <label for="telefone" class="form-label">Telefone / WhatsApp</label>
                        <input
                            type="tel"
                            name="telefone"
                            id="telefone"
                            class="form-control"
                            placeholder="(00) 00000-0000"
                            required
                            value="<?= htmlspecialchars($_POST['telefone'] ?? '') ?>" />
                    </div>
                </fieldset>

                <!-- LOGIN -->
                <fieldset class="border p-3 mb-4 rounded">
                    <legend class="fw-bold">Acesso ao Sistema</legend>

                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input
                            type="password"
                            name="responsavel_senha"
                            id="senha"
                            class="form-control"
                            placeholder="Crie uma senha segura"
                            required />
                    </div>

                    <div class="mb-3">
                        <label for="confirmarSenha" class="form-label">Confirmar Senha</label>
                        <input
                            type="password"
                            name="responsavel_confirmar_senha"
                            id="confirmarSenha"
                            class="form-control"
                            placeholder="Repita a senha"
                            required />
                    </div>
                </fieldset>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-4 py-2">
                        Cadastrar ONG
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<script src="/js/bootstrap.bundle.min.js"></script>
</body>

</html>
