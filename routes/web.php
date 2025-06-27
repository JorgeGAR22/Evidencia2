<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;

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

// Rutas de autenticación generadas por Laravel UI
Auth::routes();

// =========================================================
// RUTAS PÚBLICAS (Para usuarios NO autenticados)
// =========================================================

Route::get('/', [HomeController::class, 'index'])->name('home_public');
Route::post('/search-order', [HomeController::class, 'searchOrder'])->name('public.search');


// =========================================================
// RUTAS PROTEGIDAS (Para usuarios AUTENTICADOS)
// =========================================================

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // Rutas para la gestión de USUARIOS
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index'); // Lista de usuarios
        Route::get('/create', [UserController::class, 'create'])->name('create'); // Formulario de creación
        Route::post('/', [UserController::class, 'store'])->name('store'); // Guardar nuevo usuario
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit'); // Formulario de edición
        Route::put('/{user}', [UserController::class, 'update'])->name('update'); // Actualizar usuario
        Route::put('/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('toggleActive'); // Activar/Desactivar usuario
    });

    // Rutas para la gestión de ÓRDENES (excepto archived, que se manejará aparte)
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index'); // Lista de órdenes activas
        Route::get('/create', [OrderController::class, 'create'])->name('create'); // Formulario de creación
        Route::post('/', [OrderController::class, 'store'])->name('store'); // Guardar nueva orden
        Route::get('/{order}', [OrderController::class, 'show'])->name('show'); // Ver detalles de una orden
        Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('edit'); // Formulario de edición
        Route::put('/{order}', [OrderController::class, 'update'])->name('update'); // Actualizar orden (incluye fotos)
        Route::delete('/{order}', [OrderController::class, 'destroy'])->name('destroy'); // Eliminar lógicamente (archivar)

        // Ruta para restaurar orden (fuera del prefix porque el ID ya está completo)
        Route::put('/{id}/restore', [OrderController::class, 'restore'])->name('restore');
    });

    // RUTA PARA ÓRDENES ARCHIVADAS (Movida fuera del prefix 'orders' group, pero dentro de 'auth')
    Route::get('/orders/archived', [OrderController::class, 'archived'])->name('orders.archived');
});

// Sobreescribir la ruta por defecto del dashboard de Laravel UI si fuera necesario
Route::redirect('/home', '/dashboard');
