<?php

namespace Models\Enums;

enum TipoUsuario: string
{
    case ADMINISTRADOR = 'administrador';
    case ONG = 'ong';
    case EMPRESA = 'empresa';
}
