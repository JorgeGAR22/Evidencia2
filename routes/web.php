<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController; // Asegúrate de que esta línea esté presente
use App\Http\Controllers\NoteController; // ¡Importante: Asegúrate de que esta línea esté presente!

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

// Ruta de inicio: condicional para usuarios logueados o no
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('landingpage');
})->name('welcome');

// Rutas de autenticación generadas por Laravel UI (login, register, logout, password reset)
Auth::routes();

// Ruta del dashboard, protegida por el middleware 'auth'.
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard')->middleware('auth');

// Opcional: Si Laravel UI te redirige a /home y quieres que /home también vaya al dashboard.
Route::get('/home', function() {
    return redirect()->route('dashboard');
})->middleware('auth');

// Rutas para el CRUD de Notas, protegidas por autenticación
Route::resource('notes', NoteController::class)->middleware('auth');