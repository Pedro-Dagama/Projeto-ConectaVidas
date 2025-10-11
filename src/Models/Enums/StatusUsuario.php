<?php

namespace Models\Enums;

enum StatusUsuario: string
{
    case ATIVO = 'ativo';
    case INATIVO = 'inativo';
    case SUSPENSO = 'suspenso';
}

