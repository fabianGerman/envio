<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Envio;
use Carbon\Carbon;

class Controlador_Archivo extends Controller
{
    public function list(){
        $lista = Envio::listar_envios();

        return view('archivos.listar',compact('lista'));
    }
    
    public function back(){
        return redirect()->route('archivo.listar');
    }

    
    public function filtro(Request $request){
        // Obtener los filtros del request
    $prestador = $request->input('prestador');
    $prestacion = $request->input('prestacion');
    $afiliado = $request->input('afiliado');
    $periodo = $request->input('periodo');
    $obrasocial = $request->input('obrasocial');
    $usuario = $request->input('usuario');
    $estado = $request->input('estado'); 

    // Redirigir si no se proporciona ningún filtro
    if ($prestador == null && $prestacion == null && $afiliado == null && $periodo == null && $obrasocial == null && $usuario == null) {
        return redirect()->route('archivo.listar');
    }

    // Obtener la lista con los filtros aplicados
    $lista = Envio::filtros_envio($prestador, $prestacion, $afiliado, $periodo, $obrasocial, $usuario, false);

    // Verificar si la lista está vacía
    if ($lista->isEmpty()) {
        // Si no se encuentra ningún registro, devolver mensaje a la vista
        return view('archivos.listar')->with('mensaje', 'No se encontraron resultados con los filtros ingresados.');
    }

    // Aplicar el filtro de estado si es necesario
    if ($estado !== null) {
        foreach ($lista as $key => $value) {
            $e = \Carbon\Carbon::parse($value->FECHACREACION)->diffInHours(now()) < 24;
            if (($estado === 'Activo' && $e) || ($estado === 'Caducado' && !$e)) {
                $value->estado = $estado;
            }
        }
    }

    // Devolver la vista con los resultados
    return view('archivos.listar', compact('lista'));
    }


    public function exportar_listado(Request $request){
        $prestador = $request->input('prestador');
        $prestacion = $request->input('prestacion');
        $afiliado = $request->input('afiliado');
        $periodo = $request->input('periodo');
        $obrasocial = $request->input('obrasocial');
        $usuario = $request->input('usuario');
       
        if ($prestador == null && $prestacion == null && $afiliado == null && $periodo == null && $obrasocial == null && $usuario == null) {
            $lista = Envio::listar_envios2();
        } else {
            $lista = Envio::filtros_envio($prestador, $prestacion, $afiliado, $periodo, $obrasocial, $usuario);
        }

        $fileName = "envio.csv";
        $headers = array(
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = ['USUARIO', 'AFILIADO', 'PRESTADOR', 'OBRA SOCIAL', 'PERIODO', 'Nº PRESTACION', 'FECHA DE CARGA', 'ESTADO', 'URL'];
        
        $callback = function () use ($lista, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns, ';');
            foreach ($lista as $l) {
                $estado = \Carbon\Carbon::parse($l->FECHACREACION)->diffInHours(now()) >= 24 ? 'Caducado' : 'Activo';

                $row = [
                    $l->USUARIO,
                    $l->AFILIADO,
                    $l->PRESTADOR,
                    $l->OBRASOCIAL,
                    $l->PERIODO,
                    $l->PRESTACION,
                    $l->FECHACREACION,
                    $estado,
                    $l->DOCUMENTACION
                ];
                fputcsv($file, $row, ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function generearPDF($id){
        $envio = Envio::where('envios.id',$id)
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
            ->first();
        if(!$envio){
            return response()->json(['error'=>'Envio no Encontrado'],404);
        }        
        $pdf = PDF::loadView('envios.archivo',compact('envio'));
        return $pdf->stream('envio.pdf');
    }
}
