<?php

namespace Models;

class User
{
    private $id_usuario;
    private $nome;
    private $email;
    private $senha;
    private $tipo_usuario;
    private $criado_em;
    private $atualizado_em;

    public function __construct($id_usuario, $nome, $email, $senha, $tipo_usuario, $criado_em, $atualizado_em)
    {
        $this->id_usuario = $id_usuario;
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
        $this->tipo_usuario = $tipo_usuario;
        $this->criado_em = $criado_em;
        $this->atualizado_em = $atualizado_em;
    }

    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

    public function setIdUsuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    public function getTipoUsuario()
    {
        return $this->tipo_usuario;
    }

    public function setTipoUsuario($tipo_usuario)
    {
        $this->tipo_usuario = $tipo_usuario;
    }

    public function getCriadoEm()
    {
        return $this->criado_em;
    }

    public function setCriadoEm($criado_em)
    {
        $this->criado_em = $criado_em;
    }

    public function getAtualizadoEm()
    {
        return $this->atualizado_em;
    }

    public function setAtualizadoEm($atualizado_em)
    {
        $this->atualizado_em = $atualizado_em;
    }
}
