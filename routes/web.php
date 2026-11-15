<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Acceso institucional (Público)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas del sistema OTSI - MDSS
Route::middleware('auth')->group(function () {
    // Ruta raíz '/' responde 200 OK directamente tras iniciar sesión
    Route::get('/', [TicketController::class, 'index']);

    // Interfaz 1: Recepción de Equipos y Mesa de Soporte (PBI-01 / PBI-05)
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');

    // Interfaz 2: Taller Técnico, Diagnóstico y Cierre (PBI-02 / PBI-03)
    Route::get('/tickets/{ticket}/atender', [TicketController::class, 'edit'])->name('tickets.edit');
    Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');

    // Interfaz 3: Trazabilidad Patrimonial y Estadísticas Gerenciales (PBI-04)
    Route::get('/historial', [TicketController::class, 'historial'])->name('tickets.historial');

    // Interfaz 4: Gestión de Personal y Métricas Gerenciales (Solo Jefe OTSI)
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
    Route::delete('/usuarios/{user}', [UserController::class, 'destroy'])->name('usuarios.destroy');
});
