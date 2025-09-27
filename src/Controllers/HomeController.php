<?php

namespace Controllers;

class HomeController
{
    public function index()
    {
        require_once __DIR__ . '/../Views/home/home.php';
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
