<?php

use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('eventos', InicioController::class)->name('home'); 

Route::controller(PersonaController::class)->group(function(){
    Route::get('personas', 'index');

    Route::get('personas/create', 'create')->name('personas.create');

    Route::get('personas/{id}', 'show')->name('personas.show');
});

Route::controller(LoginController::class)->group(function(){
    Route::view('/login', 'auth/login')->name('login');

    Route::view('/registro', 'auth/registro')->name('registro');

    Route::view('/privada', 'prueba')->middleware('auth')->name('privada');

    Route::post('/validar-registro', 'register')->name('validar-registro');

    Route::post('/inicia-sesion', 'login')->name('inicia-sesion');

    Route::get('/logout', 'logout')->name('logout');
});

//Route::get('registro', [RegistroController::class, 'index'])->name('registro');

//Route::get('login', [LoginController::class, 'index'])->name('login');






// Route::get('users/{id}', function ($id) {
    
// });
// Route::get('users/{id}/{Nombre?}', function ($id, $nombre) {
    
// });

// Route::get('/registro', function () {
//     return view('registro');
// });

//Route::get('/', [WebController::class, 'inicio']);

//Route::get('/registro', [RegistroController::class, 'registro']);

//Route::get('/login', [LoginController::class, 'login']);

