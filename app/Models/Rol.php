<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Rol extends Model
{
    use HasFactory;

    protected $filiable = [
        'rol_nombre',
        'rol_descripcion'
    ];

    public static function enumerar_roles(){
        if(Auth::user()->rol_usuario == 1){
            $result = Rol::select(
                    'id AS ID',
                    'rol_nombre AS ROL'
                )
                ->get();
        }else{
            $result = Rol::whereNotIn('id',[1,2])
                ->select('id AS ID',
                        'rol_nombre AS ROL'
                    )
                ->get();
        }
        return $result;
    }

    public static function listar_roles(){
        $result = Rol::select(
                'id as ID',
                'rol_nombre as NOMBRE',
                'rol_descripcion as DESCRIPCION'
            )
            ->paginate(5);
        return $result;
    }

    public static function agregar_rol($nombre,$descripcion){
        return Rol::insert([
            'rol_nombre' => $nombre,
            'rol_descripcion' => $descripcion
        ]);
    }

    public static function modificar_rol($id,$nombre,$descripcion){
        return Rol::where('id',$id)
            ->update([
                'rol_nombre' => $nombre,
                'rol_descripcion' => $descripcion
            ]);
    }

    public static function eliminar_rol($id){
        return Rol::where('id',$id)
            ->delete();
    }

    public static function buscar_rol($param){
        return Rol::where('rol_nombre',$param)
            ->select(
                'id as ID',
                'rol_nombre as NOMBRE',
                'rol_descripcion as DESCRIPCION'
            )
            ->paginate(5);
    }
}
