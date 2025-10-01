<?php

namespace Controllers;

use Repositories\UserRepository;
use Config\Database;

class LoginController
{
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository(Database::getConnection());
    }

    public function showLoginForm($error = null)
    {
        require_once __DIR__ . '/../Views/login/login.php';
    }

    public function authenticate()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['senha'] ?? '';

            $user = $this->userRepository->findByEmail($email);
            if ($user && password_verify($password, $user->getSenha())) {
                if (session_status() === PHP_SESSION_NONE) session_start();
                $_SESSION['user'] = [
                    'id' => $user->getId(),
                    'nome' => $user->getNome(),
                    'email' => $user->getEmail(),
                    'tipo_usuario' => $user->getTipoUsuario(),
                ];

                if ($user->getTipoUsuario() === 'empresa') {
                    header('Location: /?url=empresa');
                } elseif ($user->getTipoUsuario() === 'ong') {
                    header('Location: /?url=ong');
                }
                exit();
            } else {
                $error = "Email ou senha inválidos.";
                $this->showLoginForm($error);
            }
        } else {
            $this->showLoginForm();
        }
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_destroy();
        header('Location: /?url=home');
        exit();
    }
}
