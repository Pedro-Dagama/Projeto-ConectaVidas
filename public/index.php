<?php

declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

use Controllers\HomeController;
use Controllers\LoginController;
use Controllers\RegisterController;
use Controllers\EmpresaController;
use Controllers\OngController;
use Controllers\SobreController;
use Controllers\CampanhaController;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$urlRaw = $_GET['url'] ?? 'home';
$url = trim((string)$urlRaw, " \t\n\r\0\x0B/");

$routes = [
    'home' => [HomeController::class, 'index'],
    'sobre' => [SobreController::class, 'index'],
    'login' => [LoginController::class, 'showLoginForm'],
    'login/authenticate' => [LoginController::class, 'authenticate'],
    'logout' => [LoginController::class, 'logout'],
    #'empresa' => [HomeController::class, 'empresa'],
    'empresa' => [EmpresaController::class, 'dashboard'],
    'empresa/create' => [EmpresaController::class, 'showCreateForm'],
    'empresa/store' => [EmpresaController::class, 'store'],
    #'ong' => [HomeController::class, 'ong'],
    'ong' => [OngController::class, 'dashboard'],
    'ong/create' => [OngController::class, 'showCreateForm'],
    'ong/store' => [OngController::class, 'store'],
    'admin' => [HomeController::class, 'admin'],
    'logged' => [HomeController::class, 'logged'],
    'register' => [RegisterController::class, 'showRegisterForm'],
    // Campanha
    'campanha' => [CampanhaController::class, 'index'],
    'campanha/store' => [CampanhaController::class, 'store'],
    'campanha/view' => [CampanhaController::class, 'view'],
    'campanha/edit' => [CampanhaController::class, 'edit'],
    'campanha/update' => [CampanhaController::class, 'update'],
    'campanha/close' => [CampanhaController::class, 'close'],
    // Doação (para empresas)
    #'doacao' => [\Controllers\DoacaoController::class, 'index'],            // lista campanhas disponíveis (para empresas)
    'doacao/checkout' => [\Controllers\DoacaoController::class, 'checkout'], // formulário para doar (campaign id via GET)
    #'doacao/store' => [\Controllers\DoacaoController::class, 'store'],      // processa doação (POST)
    'doacao/thankyou' => [\Controllers\DoacaoController::class, 'thankyou'], // página final
    // Doação
    'doacao/create' => [\Controllers\DoacaoController::class, 'create'],   // mostra formulário de doação para uma campanha
    'doacao/store'  => [\Controllers\DoacaoController::class, 'store'],    // recebe POST e cria doação (+ pagamento)
    // em public/index.php (no array $routes)
    'doacao/historico' => [\Controllers\DoacaoController::class, 'historico'],



];

if (!array_key_exists($url, $routes)) {
    http_response_code(404);
    echo "Página não encontrada.";
    exit();
}

list($controllerClass, $method) = $routes[$url];

if (!class_exists($controllerClass)) {
    http_response_code(500);
    echo "Classe do controlador não encontrada.";
    exit();
}

$controller = new $controllerClass();

if (!method_exists($controller, $method)) {
    http_response_code(500);
    echo "Método do controlador não encontrado.";
    exit();
}

try {
    $controller->$method();
} catch (\Throwable $e) {
    http_response_code(500);
    echo "Ocorreu um erro interno. Tente novamente mais tarde.";
    exit();
}
