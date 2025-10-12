<?php

namespace Models;

use Models\Enums\TipoUsuario;
use Models\Enums\StatusUsuario;

class Usuario
{
    private ?int $id_usuario;
    private string $nome;
    private string $email;
    private string $senha;
    private ?string $telefone;
    private ?string $endereco;
    private ?string $data_cadastro;
    private TipoUsuario $tipo_usuario;
    private StatusUsuario $status;

    public function __construct(
        ?int $id_usuario = null,
        string $nome = '',
        string $email = '',
        string $senha = '',
        ?string $telefone = null,
        ?string $endereco = null,
        ?string $data_cadastro = null,
        ?TipoUsuario $tipo_usuario = null,
        ?StatusUsuario $status = null
    ) {
        $this->id_usuario = $id_usuario;
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
        $this->telefone = $telefone;
        $this->endereco = $endereco;
        $this->data_cadastro = $data_cadastro ?? date('Y-m-d H:i:s');
        $this->tipo_usuario = $tipo_usuario ?? TipoUsuario::EMPRESA;
        $this->status = $status ?? StatusUsuario::ATIVO;
    }

    public function getIdUsuario(): ?int
    {
        return $this->id_usuario;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getSenha(): string
    {
        return $this->senha;
    }

    public function getTelefone(): ?string
    {
        return $this->telefone;
    }

    public function getEndereco(): ?string
    {
        return $this->endereco;
    }

    public function getDataCadastro(): ?string
    {
        return $this->data_cadastro;
    }

    public function getTipoUsuario(): TipoUsuario
    {
        return $this->tipo_usuario;
    }

    public function getStatus(): StatusUsuario
    {
        return $this->status;
    }

    public function setIdUsuario(?int $id_usuario): void
    {
        $this->id_usuario = $id_usuario;
    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function setEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('E-mail inválido.');
        }
        $this->email = $email;
    }

    public function setSenha(string $senhaPlainOrHash, bool $isHash = false): void
    {
        if ($isHash) {
            $this->senha = $senhaPlainOrHash;
            return;
        }

        if (strlen($senhaPlainOrHash) < 4) {
            throw new \InvalidArgumentException('A senha deve conter pelo menos 6 caracteres.');
        }

        $this->senha = password_hash($senhaPlainOrHash, PASSWORD_DEFAULT);
    }

    public function setSenhaHash(string $hash): void
    {
        $this->senha = $hash;
    }

    public function setTelefone(?string $telefone): void
    {
        $this->telefone = $telefone;
    }

    public function setEndereco(?string $endereco): void
    {
        $this->endereco = $endereco;
    }

    public function setDataCadastro(?string $data_cadastro): void
    {
        $this->data_cadastro = $data_cadastro;
    }

    public function setTipoUsuario(TipoUsuario $tipo_usuario): void
    {
        $this->tipo_usuario = $tipo_usuario;
    }

    public function setStatus(StatusUsuario $status): void
    {
        $this->status = $status;
    }

    public function verificarSenha(string $senhaPlain): bool
    {
        return password_verify($senhaPlain, $this->senha);
    }

    public function ativar(): void
    {
        $this->status = StatusUsuario::ATIVO;
    }

    public function inativar(): void
    {
        $this->status = StatusUsuario::INATIVO;
    }

    public function suspender(): void
    {
        $this->status = StatusUsuario::SUSPENSO;
    }

    public function toArray(): array
    {
        return [
            'id_usuario' => $this->id_usuario,
            'nome' => $this->nome,
            'email' => $this->email,
            'senha' => $this->senha,
            'telefone' => $this->telefone,
            'endereco' => $this->endereco,
            'data_cadastro' => $this->data_cadastro,
            'tipo_usuario' => $this->tipo_usuario->value,
            'status' => $this->status->value,
        ];
    }
}
