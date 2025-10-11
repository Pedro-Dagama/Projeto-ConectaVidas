<?php

namespace Controllers;

use Models\Enums\TipoUsuario;

class HomeController
{
    public function index(): void
    {
        require_once __DIR__ . '/../Views/home/home.php';
    }

    public function empresa(): void
    {
        $this->ensureLogged();
        $this->ensureRole(TipoUsuario::EMPRESA->value);
        require_once __DIR__ . '/../Views/empresa/empresa.php';
    }

    public function ong(): void
    {
        $this->ensureLogged();
        $this->ensureRole(TipoUsuario::ONG->value);
        require_once __DIR__ . '/../Views/ong/ong.php';
    }

    public function admin(): void
    {
        $this->ensureLogged();
        $this->ensureRole(TipoUsuario::ADMINISTRADOR->value);
        require_once __DIR__ . '/../Views/admin/admin.php';
    }

    public function logged(): void
    {
        $this->ensureLogged();
        require_once __DIR__ . '/../Views/home/home_logged.php';
    }

    private function startSessionIfNeeded(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function ensureLogged(): void
    {
        $this->startSessionIfNeeded();

        if (empty($_SESSION['user']) || !is_array($_SESSION['user'])) {
            header('Location: /?url=login');
            exit();
        }
    }

    private function ensureRole(string $requiredRole): void
    {
        $role = $_SESSION['user']['tipo_usuario'] ?? null;

        if ($role !== $requiredRole) {
            header('Location: /?url=login');
            exit();
        }
    }
}
