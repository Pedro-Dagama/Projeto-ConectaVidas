<?php

namespace Controllers;

use Config\Database;
use Models\Usuario;
use Models\Enums\TipoUsuario;
use Models\Enums\StatusUsuario;
use Repositories\UsuarioRepository;

class RegisterController
{
    private UsuarioRepository $usuarioRepository;

    public function __construct()
    {
        $this->usuarioRepository = new UsuarioRepository(Database::getConnection());
    }

    public function showRegisterForm(?string $error = null): void
    {
        require_once __DIR__ . '/../Views/login/register.php';
    }

    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->showRegisterForm();
            return;
        }

        $nome = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['password'] ?? '';
        $confirmSenha = $_POST['confirm_password'] ?? '';
        $tipoUsuario = $_POST['tipousuario'] ?? '';
        $telefone = $_POST['telefone'] ?? null;
        $endereco = $_POST['endereco'] ?? null;

        if ($nome === '' || $email === '' || $senha === '') {
            $this->showRegisterForm("Preencha todos os campos obrigatórios.");
            return;
        }

        if ($senha !== $confirmSenha) {
            $this->showRegisterForm("As senhas não conferem.");
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->showRegisterForm("E-mail em formato inválido.");
            return;
        }

        if ($this->usuarioRepository->emailExists($email)) {
            $this->showRegisterForm("Este e-mail já está cadastrado.");
            return;
        }

        try {
            $tipoEnum = TipoUsuario::from($tipoUsuario);
        } catch (\ValueError $e) {
            $this->showRegisterForm("Tipo de usuário inválido. Escolha entre administrador, empresa ou ong.");
            return;
        }

        $usuario = new Usuario(
            null,
            $nome,
            $email,
            '',
            $telefone,
            $endereco,
            null,
            $tipoEnum,
            StatusUsuario::ATIVO
        );

        try {
            $usuario->setSenha($senha);
        } catch (\InvalidArgumentException $e) {
            $this->showRegisterForm($e->getMessage());
            return;
        }

        try {
            $ok = $this->usuarioRepository->createUser($usuario);
        } catch (\Throwable $e) {
            $this->showRegisterForm("Ocorreu um erro no servidor. Tente novamente mais tarde.");
            return;
        }

        if ($ok) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['success_message'] = "Usuário cadastrado com sucesso! Agora faça login.";
            header('Location: /?url=login');
            exit();
        } else {
            $this->showRegisterForm("Ocorreu um erro ao cadastrar o usuário. Tente novamente.");
        }
    }
}
