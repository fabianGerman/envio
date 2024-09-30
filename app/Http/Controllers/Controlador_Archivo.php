<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Envio;

class Controlador_Archivo extends Controller
{
    public function list(){
        $lista = Envio::listar_envios();

        return view('archivos.listar',compact('lista'));
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
            //dump($prestador,$prestacion,$afiliado,$periodo,$obrasocial,$usuario);
            $lista = Envio::filtros_envio($prestador,$prestacion,$afiliado,$periodo,$obrasocial,$usuario);
            
            return view('archivos.listar',compact('lista'));
        }
        
        
    }
}
