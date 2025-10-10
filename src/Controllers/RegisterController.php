<?php

namespace Controllers;

use Config\Database;
use Models\User;
use Repositories\UserRepository;

class RegisterController
{
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository(Database::getConnection());
    }
    public function showRegisterForm($error = null)
    {
        require_once __DIR__ . '/../Views/login/register.php';
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $senha = $_POST['password'] ?? '';
            $confirmSenha = $_POST['confirm_password'] ?? '';

            if ($senha !== $confirmSenha) {
                $error = "As senhas não conferem.";
                $this->showRegisterForm($error);
                return;
            }

            // Verifica se e-mail já existe
            if ($this->userRepository->emailExists($email)) {
                $error = "Este e-mail já está cadastrado.";
                $this->showRegisterForm($error);
                return;
            }

            // Hash da senha usando password_hash
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
            $tipoUsuario = $_POST['tipousuario'] ?? '';
            $tiposPermitidos = ['administrador', 'empresa', 'ong'];

            if (!in_array($tipoUsuario, $tiposPermitidos)) {
                $error = "Tipo de usuário inválido. Escolha entre administrador, empresa ou ong.";
                $this->showRegisterForm($error);
                return;
            }

            $dataAtual = date('Y-m-d H:i:s');

            $user = new User(null, $nome, $email, $senhaHash, $tipoUsuario, $dataAtual, $dataAtual);

            if ($this->userRepository->createUser($user)) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['success_message'] = "Usuário cadastrado com sucesso! Agora faça login.";
                header('Location: /?url=login');
                exit();
            }
        } else {
            $this->showRegisterForm();
        }
    }
}
