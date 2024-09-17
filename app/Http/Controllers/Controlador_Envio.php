<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Envio;
use App\Models\ObraSocial;
use App\Models\Plan;
use App\Models\Prestador;
use App\Models\Afiliado;
use Illuminate\Support\Facades\Auth;
use PDF;
use Illuminate\Support\Facades\Storage;

class Controlador_Envio extends Controller
{
    public function index(){
        return view('envios.envio');
    }

    public function listar(){

        $usuario = Auth::id();
        $envios = Envio::where('envios.env_usuario',$usuario)
            ->join('afiliados','afiliados.id','=','envios.env_afiliado')
            ->join('prestadors','prestadors.id','=','envios.env_prestador')
            ->join('obra_socials','obra_socials.id','=','envios.env_obrasocial')
            ->join('users','users.id','=','envios.env_usuario')
            ->select(
                'afiliados.af_nombres as AFILIADO',
                'prestadors.prest_nombre as PRESTADOR',
                'obra_socials.os_nombre as OBRASOCIAL',
                'envios.env_periodo as PERIODO',
                'envios.env_prestacion as PRESTACION',
                'envios.env_documentO as DOCUMENTACION'
            )
            ->groupBy(
                'afiliados.af_nombres',
                'prestadors.prest_nombre',
                'obra_socials.os_nombre',
                'envios.env_periodo',
                'envios.env_prestacion',
                'envios.env_documento'
            )
            ->get();
        
        return view('envios.lista',['envios' => $envios]);
    }


    public function prueba(){
        return view('envios.prueba');
    }



    public function registrar(Request $request){
        $obrasocial = $request->input('obrasocial');
        $periodo = $request->input('periodo');
        $prestador = $request->input('prestador');
        $afiliado = $request->input('afiliado');
        $prestacion = $request->input('prestacion');
        $archivo = $request->file('documentacion');
        $archivo_nombre = time().'_'.$archivo->getClientOriginalName();
        $archivo_path = $archivo->storeAs('documentos',$archivo_nombre,'public');



       

        if ($request->hasFile('documentacion')) {
            $image = $request->file('documentacion');
            $path = $image->store('images', 'public');
        }

        $buscar_afiliado = Afiliado::where('af_nombres',$afiliado)->first();
        if($buscar_afiliado == null){
            $afiliado_agregar = new Afiliado();
            $afiliado_agregar->af_nombres = $afiliado;
            $afiliado_agregar->save();
        }

        $buscar_prestador = Prestador::where('prest_nombre',$prestador)->first();
        if($buscar_prestador == null){
            $prestador_agregar = new Prestador();
            $prestador_agregar->prest_nombre = $prestador;
            $prestador_agregar->save();
        }

        $buscar_obrasocial = ObraSocial::where('os_nombre',$obrasocial)->first();
        if($buscar_obrasocial == null){
            $obrasocial_agregar = new ObraSocial();
            $obrasocial_agregar->os_nombre = $obrasocial;
            $obrasocial_agregar->save();
        }


        $buscar_afiliado = Afiliado::where('af_nombres',$afiliado)->first();
        $buscar_prestador = Prestador::where('prest_nombre',$prestador)->first();
        $buscar_obrasocial = ObraSocial::where('os_nombre',$obrasocial)->first();

        $envio_agregar = new Envio();
        $envio_agregar->env_afiliado = $buscar_afiliado->id;
        $envio_agregar->env_obrasocial = $buscar_obrasocial->id;
        $envio_agregar->env_prestador = $buscar_prestador->id;
        $envio_agregar->env_periodo = $periodo;
        $envio_agregar->env_prestacion = $prestacion;
        $envio_agregar->env_documento = $path;
        $envio_agregar->env_usuario = Auth::id();
        $envio_agregar->save();

        return $this->generarPDF($envio_agregar->id);
       // return redirect()->route('envio.index');
    }

    public function generarPDF($id)
    {

        if (!Storage::exists('public/pdfs')) {
            Storage::makeDirectory('public/pdfs');
        }

        // Obtiene el envío guardado por su ID
        $envio = Envio::where('envios.id',$id)
            ->join('afiliados','afiliados.id','=','envios.env_afiliado')
            ->join('prestadors','prestadors.id','=','envios.env_prestador')
            ->join('obra_socials','obra_socials.id','=','envios.env_obrasocial')
            ->join('users','users.id','=','envios.env_usuario')
            ->select(
                'afiliados.af_nombres as AFILIADO',
                'prestadors.prest_nombre as PRESTADOR',
                'obra_socials.os_nombre as OBRASOCIAL',
                'envios.env_periodo as PERIODO',
                'envios.env_prestacion as PRESTACION',
                'envios.env_documentO as DOCUMENTACION'
            )
            ->first();
        //dd($envio,$id);
        // Genera el PDF desde una vista (ej: envio_pdf)
        $pdf = PDF::loadView('envios.archivo', compact('envio'));


        

        // Define el nombre del archivo PDF
    $pdfFileName = 'envio_' . $id . '.pdf';

    // Guarda el PDF en el almacenamiento público
    $pdf->save(storage_path('app/public/pdfs/' . $pdfFileName));

    // Crea la URL pública para acceder al PDF
    $pdfUrl = asset('storage/pdfs/' . $pdfFileName);

    // Actualiza el registro en la base de datos con la URL del PDF (opcional)
    $envio->env_documento = $pdfUrl;
    $envio->save();
        // Opción 1: Mostrar el PDF en el navegador
        return $pdf->stream('envio.pdf');

        // Opción 2: Descargar el PDF
         //return $pdf->download('envio.pdf');
    }

   

}
