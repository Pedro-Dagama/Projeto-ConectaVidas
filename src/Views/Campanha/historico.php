<?php
// PHP pode ser usado aqui para carregar dados do histórico do banco de dados
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Doações - ConectaVidas+</title>
    <link rel="stylesheet" href="../../../public/css/bootstrap.min.css" /> 
    <link rel="stylesheet" href="../../../public/css/global.css" />
    <link rel="stylesheet" href="../../../public/css/after-login.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" />
</head>
<body>

<header>
    <div class="d-none d-md-flex container-fluid justify-content-between align-items-center py-2 px-4 border-bottom bg-warning fixed-top shadow-sm">
        <div class="logo">
            <a href="#" class="text-decoration-none text-dark">
                <span class="fw-bold fs-1">ConectaVidas+</span>
            </a>
        </div>
        <div class="d-flex align-items-center gap-4">
            <form class="flex-grow-1" role="search">
                <input type="search" class="form-control fs-5" placeholder="Buscar doadores/campanhas..." aria-label="Search" />
            </form>
            <div class="dropdown menu-user p-2" data-bs-theme="light">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="me-2 fs-5">Login ONG</span>
                    <img src="https://via.placeholder.com/40" alt="Foto de perfil da ONG" width="40" height="40" class="rounded-circle" />
                </a>
                <ul class="dropdown-menu dropdown-menu-end fs-5">
                    <li><a class="dropdown-item" href="criar-campanha.html"><i class="bi bi-plus-square-fill me-2"></i> Criar Campanha</a></li>
                    <li><a class="dropdown-item" href="lista-campanhas.html"><i class="bi bi-list-check me-2"></i> Lista de Campanhas</a></li>
                    <li><a class="dropdown-item active" aria-current="page" href="#"><i class="bi bi-graph-up-arrow me-2"></i> Histórico de Doações</a></li>
                    <li><a class="dropdown-item" href="perfil-ong.html"><i class="bi bi-person-fill me-2"></i> Perfil da ONG</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> Sair</a></li>
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
                <input type="search" class="form-control" placeholder="Buscar" aria-label="Search" />
            </form>
        </div>
    </div>
    
    <nav class="navbar border-top fixed-bottom d-flex d-md-none justify-content-around py-2 shadow-sm bg-body">
        <a href="dashboard.html" class="text-body text-center" title="Dashboard"><i class="bi bi-house-door fs-3"></i></a>
        <a href="criar-campanha.html" class="text-body text-center" title="Criar Campanha"><i class="bi bi-plus-square fs-3"></i></a>
        <a href="lista-campanhas.html" class="text-body text-center" title="Minhas Campanhas"><i class="bi bi-list-check fs-3"></i></a>
        <a href="#" class="text-primary text-center" title="Doações"><i class="bi bi-graph-up-arrow fs-3"></i></a> 
    </nav>
</header>
<main class="container my-4" style="padding-top: 100px">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-5 fw-bold mb-0">
            <i class="bi bi-graph-up-arrow me-2 text-success"></i> Histórico de Doações
        </h1>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card p-3 shadow-sm border-0">
                <small class="text-muted">Total Arrecadado (Mês)</small>
                <h4 class="text-success mb-0">R$ 4.560,00</h4>
            </div>
        </div>
        <div class="col-md-8">
            <form class="d-flex gap-2">
                <input type="date" class="form-control" placeholder="Data Início">
                <input type="date" class="form-control" placeholder="Data Fim">
                <select class="form-select">
                    <option selected disabled>Filtrar por Campanha</option>
                    <option>Campanha A</option>
                    <option>Campanha B</option>
                </select>
                <button class="btn btn-primary" type="submit"><i class="bi bi-funnel"></i></button>
            </form>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover table-striped shadow-sm align-middle">
            <thead class="bg-light">
                <tr>
                    <th scope="col">Data</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Doador</th>
                    <th scope="col">Campanha</th>
                    <th scope="col">Status</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>25/08/2025</td>
                    <td class="fw-bold text-success">R$ 50,00</td>
                    <td>Maria S. (Anônimo)</td>
                    <td>Ajuda aos Animais</td>
                    <td><span class="badge text-bg-success">Confirmado</span></td>
                    <td>
                        <button class="btn btn-sm btn-outline-info" title="Detalhes"><i class="bi bi-info-circle"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>24/08/2025</td>
                    <td class="fw-bold text-success">R$ 200,00</td>
                    <td>João P. Silva</td>
                    <td>Reforma Escolar</td>
                    <td><span class="badge text-bg-success">Confirmado</span></td>
                    <td>
                        <button class="btn btn-sm btn-outline-info" title="Detalhes"><i class="bi bi-info-circle"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>23/08/2025</td>
                    <td class="fw-bold text-warning">R$ 10,00</td>
                    <td>Anônimo</td>
                    <td>Meio Ambiente Limpo</td>
                    <td><span class="badge text-bg-warning">Pendente</span></td>
                    <td>
                        <button class="btn btn-sm btn-outline-info" title="Detalhes"><i class="bi bi-info-circle"></i></button>
                    </td>
                </tr>
                </tbody>
        </table>
    </div>
    
    <nav class="d-flex justify-content-center mt-4">
        <ul class="pagination">
            <li class="page-item disabled"><a class="page-link" href="#">Anterior</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Próxima</a></li>
        </ul>
    </nav>
    
</main>
<footer class="text-center py-3 mt-4 bg-light">
    </footer>

<script src="../../../public/js/bootstrap.bundle.min.js"></script>
<script src="../../../public/js/trocar-dark-light.js"></script>
</body>
</html>