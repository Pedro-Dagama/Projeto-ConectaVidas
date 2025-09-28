<?php

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gerenciar Campanhas</title>
</head>
<body style="margin: 20px;">

  <main style="max-width: 900px; margin: 0 auto;">

    <h1 style="text-align: center;">Gerenciar Campanhas</h1>

    <!-- Formulário de criação -->
    <section style="border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
      <h2>Criar Nova Campanha</h2>
      <form action="#" method="post">
        <input type="text" name="titulo" placeholder="Título da campanha" 
            style="display: block; width: 100%; margin-bottom: 10px; padding: 8px; box-sizing: border-box;">
        <textarea name="descricao" placeholder="Descrição" 
            style="display: block; width: 100%; margin-bottom: 10px; padding: 8px; box-sizing: border-box;"></textarea>
        <input type="number" name="meta" placeholder="Meta R$" 
            style="display: block; width: 100%; margin-bottom: 10px; padding: 8px; box-sizing: border-box;">
        <input type="date" name="prazo" 
            style="display: block; width: 100%; margin-bottom: 10px; padding: 8px; box-sizing: border-box;">
        <button type="submit" style="padding: 8px 15px; cursor: pointer;">Criar Campanha</button>
      </form>
    </section>

    <!-- Lista de campanhas existentes -->
    <section style="margin-top: 20px; padding: 15px; border: 1px solid #ccc; border-radius: 8px;">
      <h2>Campanhas Existentes</h2>
        <div style="border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
          <h3 style="margin: 0 0 5px 0;">Titulo</h3>
          <p>Meta: R$ </p>
          <p>Prazo: </p>
          <button style="padding: 5px 10px; margin-right: 5px; cursor: pointer;">Editar</button>
          <button style="padding: 5px 10px; cursor: pointer;">Excluir</button>
        </div>
    </section>

  </main>

</body>
</html>
