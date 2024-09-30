<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    public static function listar_envios(){
        $usuario = User::where('id',Auth::id())
            ->first();

        if($usuario->rol_usuario == 1){
            $lista =  Envio::join('afiliados','afiliados.id','=','envios.env_afiliado')
                ->join('prestadors','prestadors.id','=','envios.env_prestador')
                ->join('obra_socials','obra_socials.id','=','envios.env_obrasocial')
                ->join('users','users.id','=','envios.env_usuario')
                ->select(
                    'envios.created_at as FECHACREACION',
                    'envios.id',
                    'afiliados.af_nombres as AFILIADO',
                    'prestadors.prest_nombre as PRESTADOR',
                    'obra_socials.os_nombre as OBRASOCIAL',
                    'envios.env_periodo as PERIODO',
                    'envios.env_prestacion as PRESTACION',
                    'envios.env_documento as DOCUMENTACION'
                )
                ->paginate(5);
        }else{
            if($usuario->rol_usuario == 2){
                $lista =  Envio::where('users.area_usuario',$usuario->area_usuario)
                    ->join('afiliados','afiliados.id','=','envios.env_afiliado')
                    ->join('prestadors','prestadors.id','=','envios.env_prestador')
                    ->join('obra_socials','obra_socials.id','=','envios.env_obrasocial')
                    ->join('users','users.id','=','envios.env_usuario')
                    ->select(
                        'envios.created_at as FECHACREACION',
                        'envios.id',
                        'afiliados.af_nombres as AFILIADO',
                        'prestadors.prest_nombre as PRESTADOR',
                        'obra_socials.os_nombre as OBRASOCIAL',
                        'envios.env_periodo as PERIODO',
                        'envios.env_prestacion as PRESTACION',
                        'envios.env_documento as DOCUMENTACION'
                    )
                    ->paginate(5);
            }else{
                $lista =  Envio::where('users.id',$usuario->id)
                    ->join('afiliados','afiliados.id','=','envios.env_afiliado')
                    ->join('prestadors','prestadors.id','=','envios.env_prestador')
                    ->join('obra_socials','obra_socials.id','=','envios.env_obrasocial')
                    ->join('users','users.id','=','envios.env_usuario')
                    ->select(
                        'envios.created_at as FECHACREACION',
                        'envios.id',
                        'afiliados.af_nombres as AFILIADO',
                        'prestadors.prest_nombre as PRESTADOR',
                        'obra_socials.os_nombre as OBRASOCIAL',
                        'envios.env_periodo as PERIODO',
                        'envios.env_prestacion as PRESTACION',
                        'envios.env_documento as DOCUMENTACION'
                    )
                    ->paginate(5);
            }
        }
        return $lista;
    }

    public static function agregar_envio($prestador,$usuario,$afiliado,$obrasocial,$periodo,$prestacion){
        return Envio::insert([
            'env_prestador' => $prestador,
            'env_usuario' => $usuario,
            'env_afiliado' => $afiliado,
            'env_obrasocial' => $obrasocial,
            'env_periodo' => $periodo,
            'env_prestacion' => $prestacion
        ]);
    }

    public static function modificar_envio($id,$prestador,$usuario,$afiliado,$obrasocial,$periodo,$prestacion){
        return Envio::where('id',$id)
            ->update([
                'env_prestador' => $prestador,
                'env_usuario' => $usuario,
                'env_afiliado' => $afiliado,
                'env_obrasocial' => $obrasocial,
                'env_periodo' => $periodo,
                'env_prestacion' => $prestacion
            ]);
    }

    public static function eliminar_envio($id){
        return Envio::where('id',$id)
            ->delete();
    }


    public static function buscar_envio($param){
        $usuario = User::where('id',Auth::id())
        ->first();

        if($usuario->rol_usuario == 1){
            $lista =  Envio::join('afiliados','afiliados.id','=','envios.env_afiliado')
                ->join('prestadors','prestadors.id','=','envios.env_prestador')
                ->join('obra_socials','obra_socials.id','=','envios.env_obrasocial')
                ->join('users','users.id','=','envios.env_usuario')
                ->select(
                    'envios.created_at as FECHACREACION',
                    'envios.id',
                    'afiliados.af_nombres as AFILIADO',
                    'prestadors.prest_nombre as PRESTADOR',
                    'obra_socials.os_nombre as OBRASOCIAL',
                    'envios.env_periodo as PERIODO',
                    'envios.env_prestacion as PRESTACION',
                    'envios.env_documento as DOCUMENTACION'
                )
                ->paginate(5);
        }else{
            if($usuario->rol_usuario == 2){
                $lista =  Envio::where('users.area_usuario',$usuario->area_usuario)
                    ->join('afiliados','afiliados.id','=','envios.env_afiliado')
                    ->join('prestadors','prestadors.id','=','envios.env_prestador')
                    ->join('obra_socials','obra_socials.id','=','envios.env_obrasocial')
                    ->join('users','users.id','=','envios.env_usuario')
                    ->select(
                        'envios.created_at as FECHACREACION',
                        'envios.id',
                        'afiliados.af_nombres as AFILIADO',
                        'prestadors.prest_nombre as PRESTADOR',
                        'obra_socials.os_nombre as OBRASOCIAL',
                        'envios.env_periodo as PERIODO',
                        'envios.env_prestacion as PRESTACION',
                        'envios.env_documento as DOCUMENTACION'
                    )
                    ->paginate(5);
            }else{
                $lista =  Envio::where('users.id',$usuario->id)
                    ->join('afiliados','afiliados.id','=','envios.env_afiliado')
                    ->join('prestadors','prestadors.id','=','envios.env_prestador')
                    ->join('obra_socials','obra_socials.id','=','envios.env_obrasocial')
                    ->join('users','users.id','=','envios.env_usuario')
                    ->select(
                        'envios.created_at as FECHACREACION',
                        'envios.id',
                        'afiliados.af_nombres as AFILIADO',
                        'prestadors.prest_nombre as PRESTADOR',
                        'obra_socials.os_nombre as OBRASOCIAL',
                        'envios.env_periodo as PERIODO',
                        'envios.env_prestacion as PRESTACION',
                        'envios.env_documento as DOCUMENTACION'
                    )
                    ->paginate(5);
            }
        }

        return $lista;
    }

    public static function filtros_envio($prestador,$prestacion,$afiliado,$periodo,$obrasocial,$usuario){

        $buscar_prestador = Prestador::where('prest_matricula', intval($prestador))->first();
        $buscar_afiliado = Afiliado::where('af_nombres', $afiliado)->first();
        $buscar_obrasocial = ObraSocial::where('os_siglas', $obrasocial)->first();
        $buscar_usuario = User::where('name',$usuario)->first();
        $lista = Envio::join('afiliados', 'afiliados.id', '=', 'envios.env_afiliado')
            ->join('prestadors', 'prestadors.id', '=', 'envios.env_prestador')
            ->join('obra_socials', 'obra_socials.id', '=', 'envios.env_obrasocial')
            ->join('users', 'users.id', '=', 'envios.env_usuario')
            ->select(
                'envios.created_at as FECHACREACION',
                'envios.id',
                'afiliados.af_nombres as AFILIADO',
                'prestadors.prest_nombre as PRESTADOR',
                'obra_socials.os_nombre as OBRASOCIAL',
                'envios.env_periodo as PERIODO',
                'envios.env_prestacion as PRESTACION',
                'envios.env_documento as DOCUMENTACION'
            );
        if($prestador != null){
            $lista->where('envios.env_prestador',$buscar_prestador->id);
        }
        if($prestacion != null){
            $lista->where('envios.env_prestacion',$prestacion);
        }
        if($afiliado != null){
            $lista->where('envios.env_afiliado',$buscar_afiliado->id);
        }
        if($periodo != null){
            $lista->where('envios.env_periodo',$periodo);
        }
        if($obrasocial != null){
            $lista->where('envios.env_obrasocial',$buscar_obrasocial->id);
        }
        if($usuario != null){
            $lista->where('envios.env_usuario',$buscar_usuario);
        }
        return $lista->paginate(5);
    }

}
