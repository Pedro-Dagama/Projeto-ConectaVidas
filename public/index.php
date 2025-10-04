<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

use Controllers\HomeController;
use Controllers\LoginController;
use Controllers\RegisterController;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$url = $_GET['url'] ?? 'home';

switch ($url) {
    case 'home':
        (new HomeController())->index();
        break;
    case 'login':
        (new LoginController())->showLoginForm();
        break;
    case 'login/authenticate':
        (new LoginController())->authenticate();
        break;
    case 'empresa':
        (new HomeController())->empresa();
        break;
    case 'ong':
        (new HomeController())->ong();
        break;
    case 'admin':
        (new HomeController())->admin();
        break;
    case 'logout':
        (new LoginController())->logout();
        break;
    case 'register':
        (new RegisterController())->showRegisterForm();
        break;
    case 'register/create':
        (new RegisterController())->create();
        break;
    default:
        echo "Página não encontrada";
        break;
}
