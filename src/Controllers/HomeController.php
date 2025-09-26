<?php

namespace Controllers;

class HomeController
{
    public function index()
    {
        require_once __DIR__ . '/../Views/home/home.php';
    }
}
