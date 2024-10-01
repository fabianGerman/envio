<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Envio;

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
        $prestador = $request->input('prestador');
        $prestacion = $request->input('prestacion');
        $afiliado = $request->input('afiliado');
        $periodo = $request->input('periodo');
        $obrasocial = $request->input('obrasocial');
        $usuario = $request->input('usuario');

        if($prestador == null && $prestacion == null && $afiliado == null && $periodo == null && $obrasocial == null && $usuario == null){
            
            return redirect()->route('archivo.listar');
        }else{
            
            $lista = Envio::filtros_envio($prestador,$prestacion,$afiliado,$periodo,$obrasocial,$usuario);
            
            return view('archivos.listar',compact('lista'));
        }
    }

    public function exportar_listado(Request $request){
        $prestador = $request->input('prestador');
        $prestacion = $request->input('prestacion');
        $afiliado = $request->input('afiliado');
        $periodo = $request->input('periodo');
        $obrasocial = $request->input('obrasocial');
        $usuario = $request->input('usuario');
       
        if ($prestador == null && $prestacion == null && $afiliado == null && $periodo == null && $obrasocial == null && $usuario == null) {
            $lista = Envio::listar_envios();
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

        $columns = ['USUARIO', 'AFILIADO', 'PRESTADOR', 'OBRA SOCIAL', 'PERIODO', 'Nº PRESTACION', 'FECHA DE CARGA', 'URL'];
        
        $callback = function () use ($lista, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns, ';');
            foreach ($lista as $l) {
                $row = [
                    $l->USUARIO,
                    $l->AFILIADO,
                    $l->PRESTADOR,
                    $l->OBRASOCIAL,
                    $l->PERIODO,
                    $l->PRESTACION,
                    $l->FECHACREACION,
                    $l->DOCUMENTACION
                ];
                fputcsv($file, $row, ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
