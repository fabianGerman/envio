<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controlador_Envio;
use App\Http\Controllers\Controlador_Usuario;
USE App\Http\Controllers\Controlador_Afiliado;
use App\Http\Controllers\Controlador_ObraSocial;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware('auth')->group(function(){

    Route::get('/usuario/listar/',[Controlador_Usuario::class,'list'])->name('usuario.listar');
    Route::get('/usuario/update/{id}',[Controlador_Usuario::class,'update'])->name('usuario.update');
    Route::get('/usuario/delete/{id}',[Controlador_Usuario::class,'delete'])->name('usuario.delete');
    Route::get('/usuario/register',[Controlador_Usuario::class,'register'])->name('usuario.registrar');
    Route::get('/usuario/detalle/{id}',[Controlador_Usuario::class,'mostrar'])->name('usuario.detalle');

    Route::post('/usuario/insert',[Controlador_Usuario::class,'insert'])->name('usuario.insert');
    Route::post('/usuario/edit/{id}',[Controlador_Usuario::class,'edit'])->name('usuario.edit');
    Route::post('/usuario/drop/{id}',[Controlador_Usuario::class,'drop'])->name('usuario.drop');
    Route::post('/usuario/search/',[Controlador_Usuario::class,'search'])->name('usuario.search');
    Route::get('/usuario/back',[Controlador_Usuario::class,'back'])->name('usuario.back');
    
});

Route::middleware('auth')->group(function(){
    
    Route::post('/envio/registrar',[Controlador_Envio::class,'registrar'])->name('envio.registrar');
    Route::get('/envio/index',[Controlador_Envio::class,'index'])->name('envio.index');
    Route::get('/envio/lista',[Controlador_Envio::class,'listar'])->name('envio.lista');
    
    Route::get('/envio/comprobante',[Controlador_Envio::class,'comprobante'])->name('envio.comprobante');
    Route::match(['get','post'],'/envio/buscar',[Controlador_Envio::class,'buscar'])->name('envio.buscar');
});

Route::middleware('auth')->group(function(){

    Route::get('/afiliado/listar',[Controlador_Afiliado::class,'list'])->name('afiliado.listar');
    Route::get('/afiliado/agregar',[Controlador_Afiliado::class,'register'])->name('afiliado.registrar');
    Route::get('/afiliado/modificar/{id}',[Controlador_Afiliado::class,'update'])->name('afiliado.modificar');
    Route::get('/afiliado/eliminar/{id}',[Controlador_Afiliado::class,'delete'])->name('afiliado.eliminar');

    Route::post('/afiliado/insert',[Controlador_Afiliado::class,'insert'])->name('afiliado.insertar');
    Route::post('/afiliado/edit/{id}',[Controlador_Afiliado::class,'edit'])->name('afiliado.actualizar');
    Route::post('/afiliado/delete/{id}',[Controlador_Afiliado::class,'drop'])->name('afiliado.borrar');
    Route::post('/afiliado/search/',[Controlador_Afiliado::class,'search'])->name('afiliado.search');
    
    Route::get('/afiliado/back',[Controlador_Afiliado::class,'back'])->name('afiliado.back');

});

Route::middleware('auth')->group(function(){
    Route::get('/obrasocial/listar',[Controlador_ObraSocial::class,'list'])->name('obrasocial.listar');
    Route::get('/obrasocial/agregar',[Controlador_ObraSocial::class,'register'])->name('obrasocial.registrar');
    Route::get('/obrasocial/modificar/{id}',[Controlador_ObraSocial::class,'update'])->name('obrasocial.modificar');
    Route::get('/obrasocial/eliminar/{id}',[Controlador_ObraSocial::class,'delete'])->name('obrasocial.eliminar');

    Route::post('/obrasocial/insert',[Controlador_ObraSocial::class,'insert'])->name('obrasocial.insertar');
    Route::post('/obrasocial/edit/{id}',[Controlador_ObraSocial::class,'edit'])->name('obrasocial.actualizar');
    Route::post('/obrasocial/delete/{id}',[Controlador_ObraSocial::class,'drop'])->name('obrasocial.borrar');
    Route::post('/obrasocial/search/',[Controlador_ObraSocial::class,'search'])->name('obrasocial.search');

    Route::get('/obrasocial/back',[Controlador_Obrasocial::class,'back'])->name('obrasocial.back');
});