<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $filiable = [
        'rol_nombre',
        'rol_descripcion'
    ];

    public static function enumerar_roles(){
        $result = Rol::select(
                'id AS ID',
                'rol_nombre AS ROL'
            )
            ->get();
        return $result;
    }
}
