<?php
require_once __DIR__ . '/../src/Config/conn-db.php';

spl_autoload_register(function ($class) {
    $path = __DIR__ . '/../src/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});

use Controllers\HomeController;

$home = new HomeController();
$home->index();
