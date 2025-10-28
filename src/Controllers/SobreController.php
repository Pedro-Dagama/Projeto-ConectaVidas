<?php
declare(strict_types=1);

namespace Controllers;

class SobreController
{
    public function index(): void
    {
        require_once __DIR__ . '/../Views/sobre/sobre.php';
    }
}
