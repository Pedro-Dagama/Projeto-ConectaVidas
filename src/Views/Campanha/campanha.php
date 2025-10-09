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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
    
</head>
<body>
<header>
    
    <div class="d-none d-md-flex container-fluid justify-content-between align-items-center py-2 px-4 border-bottom bg-warning fixed-top shadow-sm">
        
        <div class="logo">
            <a href="#" class="text-decoration-none text-body">
                <span class="fw-bold fs-1">ConectaVidas+</span>
            </a>
        </div>
        
        <div class="d-flex align-items-center gap-4">
            
            <form class="flex-grow-1" role="search">
                <input type="search" class="form-control fs-5" placeholder="Buscar campanhas..." aria-label="Search" />
            </form>
            
            <div class="dropdown menu-user p-2" data-bs-theme="light">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-body" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="me-2 fs-5">Login ONG</span>
                    <img src="#" alt="avatar" width="40" height="40" class="rounded-circle" />
                </a>
                
                <ul class="dropdown-menu dropdown-menu-end fs-5">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-plus-square-fill me-2"></i> Criar Campanha</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-list-check me-2"></i> Lista de Campanhas</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-graph-up-arrow me-2"></i> Histórico de Doações</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person-fill me-2"></i> Perfil da ONG</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-right me-2"></i> Sair</a></li>
                </ul>
            </div>
            
        </div>
    </div>

    <div class="d-flex d-md-none flex-column bg-body fixed-top border-bottom shadow-sm">
        <div class="d-flex justify-content-between align-items-center px-3 pt-2 pb-1">
            <a href="#" class="text-decoration-none logo text-body">
                <span class="fw-bold fs-3">ConectaVidas+</span>
            </a>
            <button class="theme-toggle btn btn-outline-secondary fs-4" title="Alternar Tema">
                <i class="bi bi-moon-fill"></i>
            </button>
            <a href="#" class="text-body"><i class="bi bi-chat fs-4"></i></a>
        </div>
        <div class="px-3 pb-2">
            <form role="search">
                <input type="search" class="form-control" placeholder="Buscar campanhas..." aria-label="Search" />
            </form>
        </div>
    </div>

    <nav class="navbar border-top fixed-bottom d-flex d-md-none justify-content-around py-2 shadow-sm bg-body">
        <a href="#" class="text-body text-center" title="Dashboard"><i class="bi bi-house-door fs-3"></i></a>
        <a href="#" class="text-body text-center" title="Criar Campanha"><i class="bi bi-plus-square fs-3"></i></a>
        <a href="#" class="text-body text-center" title="Minhas Campanhas"><i class="bi bi-list-check fs-3"></i></a>
        <a href="#" class="text-body text-center" title="Perfil ONG"><i class="bi bi-person-circle fs-3"></i></a>
    </nav>
</header>

<main class="container my-4" style="padding-top: 100px">
  <h1 class="text-center mb-4 display-5 fw-bold"><i class="bi bi-megaphone me-2"></i> Gerenciar Campanhas</h1>

    <div class="row">

      <!-- Coluna esquerda: Criar campanha -->
      <div class="col-12 col-md-6">
        <div class="card shadow-sm mb-4">
          <div class="card-header bg-warning text-white fw-bold">
            <i class="bi bi-plus-circle me-1"></i>Criar Nova Campanha
          </div>
          
          <div class="card-body">
          <form action="#" method="post" enctype="multipart/form-data">
            
            <div class="mb-3">
              <input type="text" name="titulo" class="form-control" placeholder="Título da campanha" required>
            </div>
        
            <div class="mb-3">
              <select name="categoria" class="form-select" required>
                <option value="" selected disabled>Selecione a Categoria</option>
                <option value="saude">Educação</option>
                <option value="educacao">Saúde</option>
                <option value="alimentacao">Meio Ambiente</option>
                <option value="animais">Animais</option>
                <option value="outros">Outros</option>
              </select>
            </div>
        
            <div class="mb-3">
              <textarea name="descricao" class="form-control" placeholder="Descrição" required></textarea>
            </div>
        
            <div class="mb-3">
              <input type="number" name="meta" class="form-control" placeholder="Meta R$" required min="1">
            </div>
        
            <div class="mb-3">
              <label for="prazo" class="form-label visually-hidden">Prazo Final</label>
              <input type="date" name="prazo" id="prazo" class="form-control" required>
            </div>
        
            <div class="mb-3">
              <label for="foto" class="form-label">Foto de Capa da Campanha</label>
              <input type="file" name="foto" id="foto" class="form-control" accept="image/*" required>
            </div>
        
          <button type="submit" class="btn btn-success w-100"><i class="bi bi-send-fill me-1"></i>Criar Campanha</button>
          </form>
          </div>
        </div>
      </div>
    
    <!-- Coluna direita: Lista de campanhas -->
      <div class="col-12 col-md-6">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white fw-bold">
            <i class="bi bi-list-check me-1"></i>Campanhas Existentes
          </div>
          
          <div class="card-body">
            <div class="card mb-3">
              <div class="card-body">
                <h3 class="h6 mb-2 text-dark">Título da Campanha</h3>
                <p class="mb-1 text-muted"><i class="bi bi-bullseye me-1"></i> Meta: <strong>R$ 10.000</strong></p>
                <p class="mb-3 text-danger"><i class="bi bi-clock-fill me-1"></i> Prazo: 20/12/2025</p>
                <p class="mb-1 fw-bold text-success">
                <i class="bi bi-wallet-fill me-1"></i> Arrecadado: R$ 4.000 / R$ 10.000</p>
      
                <div class="progress mb-3" role="progressbar" aria-label="Progresso" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar bg-success" style="width: 40%">40%</div>
              </div>
            
              <button class="btn btn-sm btn-warning me-2"><i class="bi bi-pencil-square"></i> Editar</button>
              <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Excluir</button>
            </div>
          </div>
  
              <div class="card mb-3">
                <div class="card-body">
                  <h3 class="h6 mb-2 text-dark">Título da Campanha</h3>
                  <p class="mb-1 text-muted"><i class="bi bi-bullseye me-1"></i> Meta: <strong>R$ 10.000</strong></p>
                  <p class="mb-3 text-danger"><i class="bi bi-clock-fill me-1"></i> Prazo: 20/12/2025</p>
                  <p class="mb-1 fw-bold text-success">
                  <i class="bi bi-wallet-fill me-1"></i> Arrecadado: R$ 4.000 / R$ 10.000</p>
        
                  <div class="progress mb-3" role="progressbar" aria-label="Progresso" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
                  <div class="progress-bar bg-success" style="width: 40%">40%</div>
                </div>
        
                <button class="btn btn-sm btn-warning me-2"><i class="bi bi-pencil-square"></i> Editar</button>
                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Excluir</button>
              </div>
          </div>
        
        </div>
      </div>
 
</main>

<footer class="text-center py-3 mt-4 bg-light">
</footer>

<script src="../../../public/js/bootstrap.bundle.min.js"></script>
<script src="../../../public/js/trocar-dark-light.js"></script>

</body>
</html>
