<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

// Ruta raíz '/' responde 200 OK directamente
Route::get('/', [TicketController::class, 'index']);

// Interfaz 1: Recepción de Equipos y Mesa de Soporte (PBI-01 / PBI-05)
Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');

// Interfaz 2: Taller Técnico, Diagnóstico y Cierre (PBI-02 / PBI-03)
Route::get('/tickets/{ticket}/atender', [TicketController::class, 'edit'])->name('tickets.edit');
Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');

// Interfaz 3: Trazabilidad Patrimonial y Estadísticas Gerenciales (PBI-04)
Route::get('/historial', [TicketController::class, 'historial'])->name('tickets.historial');
