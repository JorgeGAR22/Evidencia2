<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Necesario para Auth::routes()
use App\Http\Controllers\HomeController; // Importa tu HomeController
use App\Http\Controllers\UserController; // Importa tu UserController
use App\Http\Controllers\OrderController; // Importa tu OrderController

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

// Rutas de autenticación generadas por Laravel UI (login, register, logout, password reset)
Auth::routes();

// =========================================================
// RUTAS PÚBLICAS (Para usuarios NO autenticados)
// =========================================================

// Página de inicio pública con formulario de búsqueda de órdenes
Route::get('/', [HomeController::class, 'index'])->name('home_public');
Route::post('/search-order', [HomeController::class, 'searchOrder'])->name('public.search');


// =========================================================
// RUTAS PROTEGIDAS (Para usuarios AUTENTICADOS)
// =========================================================

// Dashboard para usuarios autenticados
// Esta es la ruta principal del dashboard de AdminLTE.
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

// La ruta '/home' es a donde Laravel UI redirige por defecto después del login.
// Hacemos que también apunte al método 'dashboard' de HomeController.
Route::get('/home', [HomeController::class, 'dashboard'])->name('home');


// Grupo de rutas que requieren autenticación
Route::middleware(['auth'])->group(function () {
    // Rutas para la gestión de USUARIOS
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::put('/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('toggleActive');
    });

    // Rutas para la gestión de ÓRDENES (excepto archived, que se manejará aparte)
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/create', [OrderController::class, 'create'])->name('create');
        Route::post('/', [OrderController::class, 'store'])->name('store');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('edit');
        Route::put('/{order}', [OrderController::class, 'update'])->name('update');
        Route::delete('/{order}', [OrderController::class, 'destroy'])->name('destroy');

        // Ruta para restaurar orden (se usa 'id' porque withTrashed en el modelo no recibe un objeto Order directamente para la ruta)
        Route::put('/{id}/restore', [OrderController::class, 'restore'])->name('restore');
    });

    // RUTA PARA ÓRDENES ARCHIVADAS (Movida fuera del prefix 'orders' group, pero dentro de 'auth')
    Route::get('/orders/archived', [OrderController::class, 'archived'])->name('orders.archived');

    // =========================================================
    // RUTAS PARA EL CONTENIDO DE LA ACTIVIDAD 11
    // =========================================================
    Route::get('/home-actividad11', function () {
        return view('actividad11.home');
    })->name('home-actividad11');

    Route::get('/photos-actividad11', function () {
        return view('actividad11.photos');
    })->name('photos-actividad11');

    Route::get('/contact-actividad11', function () {
        return view('actividad11.contact');
    })->name('contact-actividad11');
});
