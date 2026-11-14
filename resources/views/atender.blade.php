<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden Técnica #{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }} - OTSI MDSS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen font-sans antialiased">

    <!-- Barra Superior -->
    <nav class="bg-slate-900/95 backdrop-blur border-b border-slate-800 px-6 py-4 sticky top-0 z-20">
        <div class="max-w-5xl mx-auto flex flex-wrap justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <span class="bg-indigo-600 text-white font-bold px-3 py-1.5 rounded-lg text-xs tracking-wider shadow-md shadow-indigo-950">TALLER OTSI</span>
                <div>
                    <h1 class="font-bold text-white text-base leading-tight">Orden de Servicio Técnico #{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}</h1>
                    <p class="text-xs text-slate-400">Diagnóstico, Mantenimiento y Conformidad de Entrega</p>
                </div>
            </div>
            <a href="{{ route('tickets.index') }}" class="px-4 py-2 rounded-lg text-xs font-medium bg-slate-800 hover:bg-slate-700 text-slate-200 transition">
                ← Volver a Recepción
            </a>
        </div>
    </nav>

    <main class="max-w-5xl mx-auto p-6 space-y-6">

        <!-- Indicador Visual de Flujo (3 Etapas) -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-4 shadow-md">
            <div class="grid grid-cols-3 gap-3 text-center text-xs font-semibold">
                <div class="py-2.5 px-2 rounded-xl {{ in_array($ticket->estado, ['Recepcionado', 'En Atención', 'Completado']) ? 'bg-blue-600/20 text-blue-300 border border-blue-700/50' : 'bg-slate-950 text-slate-500' }}">
                    1. Recepcionado en Mesa
                </div>
                <div class="py-2.5 px-2 rounded-xl {{ in_array($ticket->estado, ['En Atención', 'Completado']) ? 'bg-amber-600/20 text-amber-300 border border-amber-700/50' : 'bg-slate-950 text-slate-500' }}">
                    2. Diagnóstico en Taller
                </div>
                <div class="py-2.5 px-2 rounded-xl {{ $ticket->estado === 'Completado' ? 'bg-emerald-600/20 text-emerald-300 border border-emerald-700/50' : 'bg-slate-950 text-slate-500' }}">
                    3. Mantenimiento Completado
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Columna Izquierda: Ficha Patrimonial del Bien -->
            <aside class="bg-slate-900 border border-slate-800 rounded-2xl p-5 space-y-4 h-fit shadow-xl">
                <div class="border-b border-slate-800 pb-3">
                    <span class="text-[11px] uppercase tracking-wider text-slate-400">Código Patrimonial SBN</span>
                    <p class="font-mono text-2xl font-bold text-blue-400 mt-0.5">{{ $ticket->codigo }}</p>
                </div>

                <div class="space-y-3 text-xs">
                    <div>
                        <span class="text-slate-400 block">Servidor Público (DNI)</span>
                        <span class="text-white font-mono font-semibold text-sm">{{ $ticket->solicitante }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block">Área Municipal Usuaria</span>
                        <span class="text-white font-medium">{{ $ticket->areaMunicipal->nombre ?? 'Sin área' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block">Categoría de Equipo</span>
                        <span class="text-white font-medium">{{ $ticket->categoria->nombre ?? 'General' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block">Nivel de Urgencia</span>
                        <span class="inline-block mt-1 px-2.5 py-0.5 rounded font-semibold
                            {{ $ticket->prioridad === 'Alta' ? 'bg-red-950 text-red-300 border border-red-800' : ($ticket->prioridad === 'Media' ? 'bg-amber-950 text-amber-300 border border-amber-800' : 'bg-slate-800 text-slate-300') }}">
                            {{ $ticket->prioridad }}
                        </span>
                    </div>
                    <div class="pt-3 border-t border-slate-800">
                        <span class="text-slate-400 block mb-1">Incidencia Reportada: <strong class="text-white">{{ $ticket->titulo }}</strong></span>
                        <p class="bg-slate-950 p-3 rounded-xl text-slate-300 border border-slate-800 leading-relaxed">
                            {{ $ticket->descripcion }}
                        </p>
                    </div>
                    <div class="text-[11px] text-slate-500 pt-1">
                        Ingreso: {{ $ticket->created_at->format('d/m/Y H:i') }}
                    </div>
                </div>
            </aside>

            <!-- Columna Derecha: Formulario de Intervención Técnica -->
            <form action="{{ route('tickets.update', $ticket->id) }}" method="POST" class="lg:col-span-2 bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-5 shadow-xl">
                @csrf
                @method('PUT')

                @if ($errors->any())
                    <div class="bg-red-950/90 border border-red-700 text-red-200 px-4 py-3 rounded-xl text-xs space-y-1">
                        @foreach ($errors->all() as $error)
                            <p>• {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1.5">Técnico OTSI Responsable *</label>
                        <select name="tecnico_id" required class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none">
                            <option value="">Seleccione un especialista...</option>
                            @foreach ($tecnicos as $tec)
                                <option value="{{ $tec->id }}" {{ old('tecnico_id', $ticket->tecnico_id) == $tec->id ? 'selected' : '' }}>
                                    {{ $tec->nombres }} {{ $tec->apellidos }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1.5">Actualizar Estado de la Orden *</label>
                        <select name="estado" class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none">
                            <option value="Recepcionado" {{ old('estado', $ticket->estado) === 'Recepcionado' ? 'selected' : '' }}>Recepcionado (En cola de revisión)</option>
                            <option value="En Atención" {{ old('estado', $ticket->estado) === 'En Atención' ? 'selected' : '' }}>En Atención (En mesa de trabajo)</option>
                            <option value="Completado" {{ old('estado', $ticket->estado) === 'Completado' ? 'selected' : '' }}>Completado (Listo para entrega)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1.5">Diagnóstico Técnico Inicial (PBI-02) *</label>
                    <textarea name="diagnostico" rows="2" required placeholder="Detalle la causa raíz detectada en hardware, software o red..."
                        class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none">{{ old('diagnostico', $ticket->diagnostico) }}</textarea>
                </div>

                <!-- Checklists Especializados por Tipo de Soporte (PBI-03 / PBI-05) -->
                <div class="bg-slate-950/80 border border-slate-800 rounded-xl p-4 space-y-2.5">
                    <span class="block text-xs font-semibold text-indigo-400">Acciones Estandarizadas OTSI (Clic para agregar al informe):</span>
                    <div class="flex flex-wrap gap-2">
                        @foreach ([
                            'Formateo y reinstalación de SO Windows',
                            'Instalación y config. SIADEG / SIAF',
                            'Limpieza interna y cambio de pasta térmica',
                            'Limpieza de cabezal / cambio de tóner',
                            'Ponchado RJ45 y certificación punto de red',
                            'Optimización de arranque y respaldo de datos'
                        ] as $accion)
                            <button type="button" onclick="agregarAccion('{{ $accion }}')"
                                class="px-3 py-1.5 rounded-lg text-xs bg-slate-900 hover:bg-indigo-600 text-slate-300 hover:text-white border border-slate-700 transition">
                                + {{ $accion }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1.5">Detalle de Solución y Acta de Entrega (PBI-03)</label>
                    <textarea id="solucion" name="solucion" rows="3" placeholder="Registre las acciones ejecutadas, repuestos o recomendaciones..."
                        class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3.5 py-2.5 text-sm text-white focus:border-indigo-500 focus:outline-none">{{ old('solucion', $ticket->solucion) }}</textarea>
                </div>

                <div class="flex justify-end gap-3 pt-3 border-t border-slate-800">
                    <a href="{{ route('tickets.index') }}" class="px-4 py-2.5 rounded-lg text-xs font-medium bg-slate-800 hover:bg-slate-700 text-slate-300 transition">
                        Cancelar
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-lg text-xs font-semibold bg-emerald-600 hover:bg-emerald-500 text-white shadow-lg shadow-emerald-950/60 transition">
                        ✓ Guardar Diagnóstico y Actualizar Orden
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        function agregarAccion(texto) {
            const campo = document.getElementById('solucion');
            if (!campo.value.includes(texto)) {
                campo.value = campo.value ? campo.value + '\n• ' + texto : '• ' + texto;
            }
        }
    </script>
</body>
</html>