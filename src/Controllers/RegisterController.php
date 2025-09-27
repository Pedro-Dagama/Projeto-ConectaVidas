<?php

namespace Controllers;

class RegisterController
{
    public function showRegisterForm()
    {
        require_once __DIR__ . '/../Views/login/register.php';
    }
}
