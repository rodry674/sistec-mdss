<?php

namespace App\Http\Controllers;

use App\Models\AreaMunicipal;
use App\Models\Categoria;
use App\Models\Tecnico;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class TicketController extends Controller
{
    // INTERFAZ 1: Recepción y Bandeja Activa (PBI-01 / PBI-05)
    public function index()
    {
        $areas = Schema::hasTable('area_municipals') ? AreaMunicipal::all() : collect();
        $categorias = Schema::hasTable('categorias') ? Categoria::all() : collect();
        $tickets = Schema::hasTable('tickets')
            ? Ticket::with(['areaMunicipal', 'categoria', 'tecnico'])->latest()->get()
            : collect();

        return view('tickets', compact('tickets', 'areas', 'categorias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dni' => 'required|digits:8',
            'area_id' => 'required|exists:area_municipals,id',
            'codigo_patrimonial' => 'required|digits:12',
            'titulo' => 'required|string|min:5|max:150',
            'categoria_id' => 'required|exists:categorias,id',
            'prioridad' => 'required|in:Baja,Media,Alta',
            'descripcion' => 'required|string|min:10',
        ], [
            'dni.required' => 'El DNI del servidor público es obligatorio.',
            'dni.digits' => 'El DNI debe contener exactamente 8 dígitos numéricos.',
            'area_id.required' => 'Debe seleccionar el Área Municipal solicitante.',
            'codigo_patrimonial.required' => 'El Código Patrimonial SBN es obligatorio.',
            'codigo_patrimonial.digits' => 'El Código Patrimonial debe tener exactamente 12 dígitos numéricos.',
            'titulo.required' => 'El asunto o título del incidente es obligatorio.',
            'titulo.min' => 'El asunto debe tener al menos 5 caracteres.',
            'categoria_id.required' => 'Debe seleccionar la Categoría / Tipo de Equipo.',
            'descripcion.required' => 'La descripción detallada de la falla es obligatoria.',
            'descripcion.min' => 'La descripción debe detallar al menos 10 caracteres.',
        ]);

        Ticket::create([
            'codigo' => $validated['codigo_patrimonial'],
            'solicitante' => $validated['dni'],
            'area_id' => $validated['area_id'],
            'categoria_id' => $validated['categoria_id'],
            'titulo' => $validated['titulo'],
            'prioridad' => $validated['prioridad'],
            'descripcion' => $validated['descripcion'],
            'estado' => 'Recepcionado',
        ]);

        return redirect()->route('tickets.index')
            ->with('success', 'Ficha de recepción registrada con éxito para el bien patrimonial '.$validated['codigo_patrimonial'].'.');
    }

    // INTERFAZ 2: Diagnóstico Técnico y Cierre de Orden (PBI-02 / PBI-03)
    public function edit(Ticket $ticket)
    {
        $tecnicos = Tecnico::where('activo', true)->get();

        return view('atender', compact('ticket', 'tecnicos'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'tecnico_id' => 'required|exists:tecnicos,id',
            'estado' => 'required|in:Recepcionado,En Atención,Completado',
            'diagnostico' => 'required|string|min:5',
            'solucion' => 'nullable|string',
        ], [
            'tecnico_id.required' => 'Debe asignar un técnico especialista de la OTSI.',
            'diagnostico.required' => 'El diagnóstico técnico inicial es obligatorio.',
            'diagnostico.min' => 'El diagnóstico debe tener al menos 5 caracteres.',
        ]);

        $ticket->update([
            'tecnico_id' => $validated['tecnico_id'],
            'estado' => $validated['estado'],
            'diagnostico' => $validated['diagnostico'],
            'solucion' => $validated['solucion'],
            'fecha_cierre' => $validated['estado'] === 'Completado' ? now() : null,
        ]);

        return redirect()->route('tickets.index')
            ->with('success', 'Orden técnica #'.str_pad($ticket->id, 4, '0', STR_PAD_LEFT).' actualizada al estado: '.$validated['estado'].'.');
    }

    // INTERFAZ 3: Trazabilidad Patrimonial e Indicadores KPI (PBI-04)
    public function historial(Request $request)
    {
        $codigo = $request->input('codigo');
        $query = Ticket::with(['areaMunicipal', 'categoria', 'tecnico'])->latest();

        if ($codigo) {
            $query->where('codigo', 'like', "%{$codigo}%");
        }

        $historial = $query->get();
        $stats = [
            'total' => Ticket::count(),
            'recepcionados' => Ticket::where('estado', 'Recepcionado')->count(),
            'en_atencion' => Ticket::where('estado', 'En Atención')->count(),
            'completados' => Ticket::where('estado', 'Completado')->count(),
        ];

        return view('historial', compact('historial', 'stats', 'codigo'));
    }
}
