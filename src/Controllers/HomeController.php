<?php

namespace Controllers;

class HomeController
{
    public function index()
    {
        require_once __DIR__ . '/../Views/home/home.php';
    }

    public function empresa()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user']) || $_SESSION['user']['tipo_usuario'] !== 'empresa') {
            header('Location: /?url=login');
            exit();
        }
        require_once __DIR__ . '/../Views/empresa/empresa.php';
    }

    public function ong()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user']) || $_SESSION['user']['tipo_usuario'] !== 'ong') {
            header('Location: /?url=login');
            exit();
        }
        require_once __DIR__ . '/../Views/ong/ong.php';
    }

    public function logged()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['user'])) {
            header('Location: /?url=login');
            exit();
        }
        require_once __DIR__ . '/../Views/home/home_logged.php';
    }
}
