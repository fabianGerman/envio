<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Envio extends Model
{
    use HasFactory;

    protected $filiable = [
        'env_prestador',
        'env_obrasocial',
        'env_afiliado',
        'env_usuario',
        'env_periodo',
        'env_prestacion'
    ];
}
