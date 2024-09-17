<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controlador_Envio;
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
    return view('login');
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
    Route::post('/envio/registrar',[Controlador_Envio::class,'registrar'])->name('envio.registrar');
    Route::get('/envio/index',[Controlador_Envio::class,'index'])->name('envio.index');
    Route::get('/envio/lista',[Controlador_Envio::class,'listar'])->name('envio.lista');
    Route::get('/envio/prueba',[Controlador_Envio::class,'prueba'])->name('envio.prueba');
});

