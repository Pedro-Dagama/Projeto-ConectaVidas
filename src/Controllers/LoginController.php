<?php

namespace Controllers;

use Config\Database;
use Repositories\UsuarioRepository;
use Repositories\EmpresaRepository;
use Models\Enums\TipoUsuario;

class LoginController
{
    private UsuarioRepository $usuarioRepository;
    private EmpresaRepository $empresaRepository;

    public function __construct()
    {
        $this->usuarioRepository = new UsuarioRepository(Database::getConnection());
        $this->empresaRepository = new EmpresaRepository(Database::getConnection());
    }

    public function showLoginForm(?string $error = null): void
    {
        require_once __DIR__ . '/../Views/login/login.php';
    }

    public function authenticate(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->showLoginForm();
            return;
        }

        $email = trim((string)($_POST['email'] ?? ''));
        $password = $_POST['password'] ?? ($_POST['senha'] ?? '');

        if ($email === '' || $password === '') {
            $this->showLoginForm("Preencha e-mail e senha.");
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->showLoginForm("E-mail em formato inválido.");
            return;
        }

        $user = $this->usuarioRepository->findByEmail($email);

        if ($user && $user->verificarSenha($password)) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            session_regenerate_id(true);

            $organizacao = null;
            try {
                $organizacao = $this->empresaRepository->getOrganizacaoByUsuario($user->getIdUsuario());
            } catch (\Throwable $e) {
                $organizacao = null;
            }

            $_SESSION['user'] = [
                'id_usuario' => $user->getIdUsuario(),
                'nome' => $user->getNome(),
                'email' => $user->getEmail(),
                'tipo_usuario' => $user->getTipoUsuario()->value,
                'data_cadastro' => $user->getDataCadastro(),
                'id_organizacao' => isset($organizacao['id_organizacao']) ? (int)$organizacao['id_organizacao'] : null
            ];

            $tipo = $user->getTipoUsuario();

            if ($tipo === TipoUsuario::EMPRESA) {
                header('Location: /?url=empresa');
            } elseif ($tipo === TipoUsuario::ONG) {
                header('Location: /?url=ong');
            } elseif ($tipo === TipoUsuario::ADMINISTRADOR) {
                header('Location: /?url=admin');
            } else {
                header('Location: /?url=home');
            }

            exit();
        }

        $this->showLoginForm("E-mail ou senha inválidos.");
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION['user']);
        session_destroy();
        header('Location: /?url=home');
        exit();
    }
}
