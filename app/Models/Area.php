<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $filiable = [
        'area_nombre',
        'area_cuit',
        'area_domicilio',
        'area_telefono',
    ];

    public static function enumerar_areas(){
        $result = Area::select(
            'id as ID',
            'area_nombre AS NOMBRE'
        )
        ->get();
        return $result;
    }
}
