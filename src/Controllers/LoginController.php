<?php

namespace Controllers;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use Models\UserModel;

class LoginController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function showLoginForm($error = null)
    {
        require_once __DIR__ . '/../Views/login/login.php';
    }

    public function authenticate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';

            $user = $this->userModel->getUserByEmail($email);

            if ($user && password_verify($senha, $user['senha'])) {
                // salvar dados do usuário na sessão (sem a senha)
                unset($user['senha']);
                $_SESSION['user'] = $user;
                /* header('Location: /?url=home'); */
                header('Location: /?url=home_logged');
                exit();
            } else {
                $error = 'Email ou senha inválidos.';
                $this->showLoginForm($error);
            }
        } else {
            $error = "Email ou senha inválidos.";
            $this->showLoginForm($error);
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: /?url=login');
        exit();
    }
}
