<?<php>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Ongs</title>
  <link rel="stylesheet" href="..\..\..\public\css\global.css">
  <link rel="stylesheet" href="..\..\..\public\css\login.css">
</head>
<body>
  <main class="login-container">
    <section class="login-box">
      <h1 class="login-title">Ongs</h1>
      <p class="login-subtitle">Entre com sua conta para continuar</p>

      <form class="form-login" action="#" method="post">
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Digite seu e-mail" required>
        </div>

        <div class="form-group">
          <label for="password">Senha</label>
          <input type="password" id="password" name="password" placeholder="Digite sua senha" required>
        </div>

        <button type="submit" class="btn-login">Entrar</button>
        <a href="#" class="forgot-password">Esqueceu a senha?</a>
      </form>

      <div class="divider">
        <span>ou</span>
      </div>

      <button class="btn-create-account">Criar conta nova</button>
    </section>
  </main>
</body>
</html>

</php>