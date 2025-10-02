<?php

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gerenciar Campanhas</title>
    <link rel="stylesheet" href="../../../public/css/bootstrap.min.css" />  
    <link rel="stylesheet" href="../../../public/css/global.css" />
    <link rel="stylesheet" href="../../../public/css/after-login.css" />
    
</head>
<body>
  <header class="main-header bg-orange shadow-sm">
    <div class="logo p-3">
      <span class="fw-bold fs-4">ConectaVidas+</span>
    </div>
  </header>
  

  <main class="container my-4">
    <h1 class="text-center mb-4">Gerenciar Campanhas</h1>

    <div class="row">


      <!-- Coluna esquerda: Criar campanha -->
      <div class="col-12 col-md-6">
        <div class="card shadow-sm mb-4">
          <div class="card-header bg-warning text-white fw-bold">
            Criar Nova Campanha
          </div>
          
          <div class="card-body">
            <form action="#" method="post">
              <div class="mb-3">
                <input type="text" name="titulo" class="form-control" placeholder="Título da campanha">
              </div>
              <div class="mb-3">
                <textarea name="descricao" class="form-control" placeholder="Descrição"></textarea>
              </div>
              <div class="mb-3">
                <input type="number" name="meta" class="form-control" placeholder="Meta R$">
              </div>
              <div class="mb-3">
                <input type="date" name="prazo" class="form-control">
              </div>
              <button type="submit" class="btn btn-success w-100">Criar Campanha</button>
            </form>
          </div>
        </div>
      </div>
    
    <!-- Coluna direita: Lista de campanhas -->
      <div class="col-12 col-md-6">
        <div class="card shadow-sm">
          <div class="card-header bg-success text-white fw-bold">
            Campanhas Existentes
          </div>
          <div class="card-body">
            <!-- Exemplo de campanha -->
            <div class="card mb-3">
              <div class="card-body">
                <h3 class="h6 mb-2">Título da Campanha</h3>
                <p class="mb-1"><strong>Meta:</strong> R$ 10.000</p>
                <p class="mb-3"><strong>Prazo:</strong> 20/12/2025</p>
                <button class="btn btn-sm btn-warning me-2">Editar</button>
                <button class="btn btn-sm btn-danger">Excluir</button>
              </div>
            </div>

            <div class="card mb-3">
              <div class="card-body">
                <h3 class="h6 mb-2">Outra Campanha</h3>
                <p class="mb-1"><strong>Meta:</strong> R$ 5.000</p>
                <p class="mb-3"><strong>Prazo:</strong> 10/11/2025</p>
                <button class="btn btn-sm btn-warning me-2">Editar</button>
                <button class="btn btn-sm btn-danger">Excluir</button>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div> 
  </main>

</body>
</html>
