<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recepción de Soporte - OTSI MDSS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen font-sans antialiased">

    <!-- Barra de Navegación Institucional -->
    <nav class="bg-slate-900/95 backdrop-blur border-b border-slate-800 px-6 py-4 sticky top-0 z-20">
        <div class="max-w-6xl mx-auto flex flex-wrap justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="bg-blue-600 text-white font-bold px-3 py-1.5 rounded-lg text-sm tracking-wide shadow-md shadow-blue-950">OTSI</div>
                <div>
                    <h1 class="font-bold text-slate-100 text-base leading-tight">Sistema de Soporte Técnico Informático</h1>
                    <p class="text-xs text-slate-400">Municipalidad Distrital de San Sebastián — Cusco</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('tickets.index') }}" class="px-4 py-2 rounded-lg text-xs font-semibold bg-blue-600 text-white shadow-sm">
                    1. Recepción de Equipos
                </a>
                <a href="{{ route('tickets.historial') }}" class="px-4 py-2 rounded-lg text-xs font-medium bg-slate-800 text-slate-300 hover:bg-slate-700 transition">
                    2. Trazabilidad Patrimonial
                </a>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto p-6 space-y-8">

        <!-- Alertas de Validación y Confirmación -->
        @if ($errors->any())
            <div class="bg-red-950/90 border border-red-700 text-red-200 px-5 py-4 rounded-2xl shadow-lg">
                <p class="font-semibold text-sm mb-1.5">No se pudo procesar la solicitud. Verifique los siguientes campos:</p>
                <ul class="list-disc list-inside text-xs space-y-1 text-red-300">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="bg-emerald-950/90 border border-emerald-700 text-emerald-200 px-5 py-4 rounded-2xl text-sm font-medium shadow-lg">
                ✓ {{ session('success') }}
            </div>
        @endif

        <!-- Módulo de Registro de Solicitud (PBI-01 / PBI-05) -->
        <section class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl">
            <div class="flex justify-between items-center border-b border-slate-800 pb-4 mb-5">
                <div>
                    <h2 class="text-lg font-semibold text-white">Registrar Nueva Ficha de Recepción (PBI-01)</h2>
                    <p class="text-xs text-slate-400">Complete los datos del servidor público y el código patrimonial SBN del equipo.</p>
                </div>
                <span class="text-[11px] font-mono bg-slate-950 text-slate-400 px-3 py-1 rounded-full border border-slate-800">Formato OTSI-MDSS</span>
            </div>

            <form action="{{ route('tickets.store') }}" method="POST" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1.5">DNI del Solicitante (8 dígitos) *</label>
                        <input type="text" name="dni" value="{{ old('dni') }}" maxlength="8" inputmode="numeric"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 8)"
                            placeholder="Ej. 76938244"
                            class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm font-mono text-white focus:border-blue-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1.5">Área Municipal Usuaria *</label>
                        <select name="area_id" class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-blue-500 focus:outline-none">
                            <option value="">Seleccione un área...</option>
                            @foreach ($areas as $area)
                                <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>
                                    {{ $area->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1.5">Código Patrimonial SBN (12 dígitos) *</label>
                        <input type="text" name="codigo_patrimonial" value="{{ old('codigo_patrimonial') }}" maxlength="12" inputmode="numeric"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12)"
                            placeholder="Ej. 740899500123"
                            class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm font-mono text-blue-300 focus:border-blue-500 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1.5">Asunto / Título de la Incidencia *</label>
                        <input type="text" name="titulo" value="{{ old('titulo') }}" placeholder="Ej. Falla en conexión de red o SIADEG"
                            class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-blue-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1.5">Categoría / Tipo de Equipo (PBI-05) *</label>
                        <select name="categoria_id" class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-blue-500 focus:outline-none">
                            <option value="">Seleccione categoría...</option>
                            @foreach ($categorias as $cat)
                                <option value="{{ $cat->id }}" {{ old('categoria_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1.5">Nivel de Prioridad *</label>
                        <select name="prioridad" class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-blue-500 focus:outline-none">
                            <option value="Baja" {{ old('prioridad') === 'Baja' ? 'selected' : '' }}>Baja (Mantenimiento preventivo)</option>
                            <option value="Media" {{ old('prioridad', 'Media') === 'Media' ? 'selected' : '' }}>Media (Atención preferente)</option>
                            <option value="Alta" {{ old('prioridad') === 'Alta' ? 'selected' : '' }}>Alta (Urgente / Oficina detenida)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1.5">Descripción Detallada de la Falla *</label>
                    <textarea name="descripcion" rows="2" placeholder="Describa los síntomas reportados por el usuario, mensajes de error o accesorios entregados..."
                        class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-blue-500 focus:outline-none">{{ old('descripcion') }}</textarea>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="reset" class="px-4 py-2.5 rounded-lg text-xs font-medium bg-slate-800 hover:bg-slate-700 text-slate-300 transition">
                        Limpiar Formulario
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-lg text-xs font-semibold bg-blue-600 hover:bg-blue-500 text-white shadow-lg shadow-blue-950/60 transition">
                        ✓ Registrar Ticket de Soporte
                    </button>
                </div>
            </form>
        </section>

        <!-- Bandeja de Control de Tickets -->
        <section class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-white">Bandeja de Equipos en Custodia OTSI</h2>
                <span class="text-xs text-slate-400">Total registros: <strong class="text-white">{{ $tickets->count() }}</strong></span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="border-b border-slate-800 text-slate-400 text-[11px] uppercase tracking-wider">
                            <th class="py-3 px-3">Orden</th>
                            <th class="py-3 px-3">Cód. Patrimonial</th>
                            <th class="py-3 px-3">Área Usuaria</th>
                            <th class="py-3 px-3">Incidencia / Equipo</th>
                            <th class="py-3 px-3">Prioridad</th>
                            <th class="py-3 px-3">Estado</th>
                            <th class="py-3 px-3">Técnico Asignado</th>
                            <th class="py-3 px-3 text-right">Gestión Taller</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/70">
                        @forelse ($tickets as $ticket)
                            <tr class="hover:bg-slate-800/40 transition">
                                <td class="py-3.5 px-3 font-mono text-xs text-slate-400">#{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td class="py-3.5 px-3 font-mono text-blue-400 font-semibold">{{ $ticket->codigo }}</td>
                                <td class="py-3.5 px-3 text-slate-300 text-xs">{{ $ticket->areaMunicipal->nombre ?? 'N/A' }}</td>
                                <td class="py-3.5 px-3">
                                    <p class="text-white font-medium text-xs">{{ $ticket->titulo }}</p>
                                    <span class="text-[11px] text-slate-400">{{ $ticket->categoria->nombre ?? '' }}</span>
                                </td>
                                <td class="py-3.5 px-3">
                                    <span class="px-2 py-0.5 rounded text-[11px] font-semibold
                                        {{ $ticket->prioridad === 'Alta' ? 'bg-red-950 text-red-300 border border-red-800' : ($ticket->prioridad === 'Media' ? 'bg-amber-950 text-amber-300 border border-amber-800' : 'bg-slate-800 text-slate-300') }}">
                                        {{ $ticket->prioridad }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-3">
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-semibold
                                        {{ $ticket->estado === 'Completado' ? 'bg-emerald-950 text-emerald-300 border border-emerald-800' : ($ticket->estado === 'En Atención' ? 'bg-blue-950 text-blue-300 border border-blue-800' : 'bg-slate-800 text-slate-300') }}">
                                        {{ $ticket->estado }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-3 text-slate-300 text-xs">
                                    {{ $ticket->tecnico ? $ticket->tecnico->nombres . ' ' . $ticket->tecnico->apellidos : 'Por asignar' }}
                                </td>
                                <td class="py-3.5 px-3 text-right">
                                    <a href="{{ route('tickets.edit', $ticket->id) }}"
                                        class="inline-block px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-indigo-600 hover:bg-indigo-500 text-white transition shadow-sm">
                                        Atender / Diagnosticar
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-8 text-center text-slate-500 text-xs">No existen fichas de soporte registradas actualmente.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>