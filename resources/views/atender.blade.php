<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden Técnica #{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }} - OTSI MDSS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen font-sans antialiased">

    <nav class="bg-[#0b1f3a] text-white shadow-lg border-b-4 border-amber-400 px-6 py-3.5 sticky top-0 z-20">
        <div class="max-w-6xl mx-auto flex flex-wrap justify-between items-center gap-4">
            <div class="flex items-center gap-3.5">
                <span class="bg-amber-400 text-[#0b1f3a] font-extrabold px-3 py-1.5 rounded-lg text-xs tracking-wider shadow">TALLER OTSI</span>
                <div>
                    <h1 class="font-extrabold text-white text-base leading-tight">Orden de Servicio Técnico #{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}</h1>
                    <p class="text-xs text-blue-200">Diagnóstico, Mantenimiento y Conformidad de Entrega</p>
                </div>
            </div>
            <a href="{{ route('tickets.index') }}" class="px-4 py-2 rounded-lg text-xs font-bold bg-white/15 hover:bg-white/25 text-white transition">
                ← Volver a Recepción
            </a>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto p-6 space-y-6">
        <!-- Barra de Progreso del Servicio -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-center text-xs font-bold">
                <div class="py-3 px-3 rounded-xl {{ in_array($ticket->estado, ['Recepcionado', 'En Atención', 'Completado']) ? 'bg-blue-50 text-[#0b1f3a] border border-blue-200' : 'bg-slate-50 text-slate-400' }}">
                    1. Recepcionado en Mesa
                </div>
                <div class="py-3 px-3 rounded-xl {{ in_array($ticket->estado, ['En Atención', 'Completado']) ? 'bg-amber-50 text-amber-800 border border-amber-300' : 'bg-slate-50 text-slate-400' }}">
                    2. Diagnóstico en Taller
                </div>
                <div class="py-3 px-3 rounded-xl {{ $ticket->estado === 'Completado' ? 'bg-emerald-50 text-emerald-800 border border-emerald-300' : 'bg-slate-50 text-slate-400' }}">
                    3. Mantenimiento Completado
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Ficha del Bien Patrimonial -->
            <aside class="bg-white border border-slate-200 rounded-2xl p-6 space-y-4 h-fit shadow-md border-t-4 border-t-[#0b1f3a]">
                <div class="border-b border-slate-200 pb-3">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Código Patrimonial SBN</span>
                    <p class="font-mono text-2xl font-black text-[#0b1f3a] mt-0.5">{{ $ticket->codigo }}</p>
                </div>

                <div class="space-y-3 text-xs">
                    <div>
                        <span class="text-slate-500 block">Servidor Público (DNI)</span>
                        <span class="text-slate-900 font-mono font-bold text-sm">{{ $ticket->solicitante }}</span>
                    </div>
                    <div>
                        <span class="text-slate-500 block">Área Municipal Usuaria</span>
                        <span class="text-slate-900 font-semibold">{{ $ticket->areaMunicipal->nombre ?? 'Sin área' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-500 block">Categoría de Equipo</span>
                        <span class="text-slate-900 font-semibold">{{ $ticket->categoria->nombre ?? 'General' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-500 block">Nivel de Urgencia</span>
                        <span class="inline-block mt-1 px-2.5 py-0.5 rounded font-bold
                            {{ $ticket->prioridad === 'Alta' ? 'bg-red-100 text-red-800' : ($ticket->prioridad === 'Media' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-700') }}">
                            {{ $ticket->prioridad }}
                        </span>
                    </div>
                    <div class="pt-3 border-t border-slate-200">
                        <span class="text-slate-500 block mb-1">Incidencia Reportada: <strong class="text-slate-900">{{ $ticket->titulo }}</strong></span>
                        <p class="bg-slate-50 p-3 rounded-xl text-slate-700 border border-slate-200 leading-relaxed">
                            {{ $ticket->descripcion }}
                        </p>
                    </div>
                    <div class="text-[11px] text-slate-400 pt-1">
                        Ingreso: {{ $ticket->created_at->format('d/m/Y H:i') }}
                    </div>
                </div>
            </aside>

            <!-- Formulario Técnico -->
            <form action="{{ route('tickets.update', $ticket->id) }}" method="POST" class="lg:col-span-2 bg-white border border-slate-200 rounded-2xl p-6 space-y-5 shadow-md border-t-4 border-t-amber-400">
                @csrf
                @method('PUT')

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-xs space-y-1">
                        @foreach ($errors->all() as $error)
                            <p>• {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Técnico OTSI Responsable *</label>
                        <select name="tecnico_id" required
                            oninvalid="this.setCustomValidity('Por favor, seleccione un especialista de la lista.')"
                            onchange="this.setCustomValidity('')"
                            class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm text-slate-900 focus:bg-white focus:border-[#0b1f3a] focus:outline-none">
                            <option value="">Seleccione un especialista...</option>
                            @foreach ($tecnicos as $tec)
                                <option value="{{ $tec->id }}" {{ old('tecnico_id', $ticket->tecnico_id) == $tec->id ? 'selected' : '' }}>
                                    {{ $tec->nombres }} {{ $tec->apellidos }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Actualizar Estado de la Orden *</label>
                        <select name="estado" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm text-slate-900 focus:bg-white focus:border-[#0b1f3a] focus:outline-none">
                            <option value="Recepcionado" {{ old('estado', $ticket->estado) === 'Recepcionado' ? 'selected' : '' }}>Recepcionado (En cola de revisión)</option>
                            <option value="En Atención" {{ old('estado', $ticket->estado) === 'En Atención' ? 'selected' : '' }}>En Atención (En mesa de trabajo)</option>
                            <option value="Completado" {{ old('estado', $ticket->estado) === 'Completado' ? 'selected' : '' }}>Completado (Listo para entrega)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Diagnóstico Técnico Inicial (PBI-02) *</label>
                    <textarea name="diagnostico" rows="2" required
                        oninvalid="this.setCustomValidity('Por favor, detalle el diagnóstico técnico inicial.')"
                        oninput="this.setCustomValidity('')"
                        placeholder="Detalle la causa raíz detectada en hardware, software o red..."
                        class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm text-slate-900 focus:bg-white focus:border-[#0b1f3a] focus:outline-none">{{ old('diagnostico', $ticket->diagnostico) }}</textarea>
                </div>

                <div class="bg-blue-50/70 border border-blue-200 rounded-xl p-4 space-y-2.5">
                    <span class="block text-xs font-bold text-[#0b1f3a]">Acciones Estandarizadas OTSI (Clic para agregar al informe):</span>
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
                                class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-white hover:bg-[#0b1f3a] text-slate-700 hover:text-white border border-slate-300 shadow-2xs transition cursor-pointer">
                                + {{ $accion }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Detalle de Solución y Acta de Entrega (PBI-03)</label>
                    <textarea id="solucion" name="solucion" rows="3" placeholder="Registre las acciones ejecutadas, repuestos o recomendaciones..."
                        class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm text-slate-900 focus:bg-white focus:border-[#0b1f3a] focus:outline-none">{{ old('solucion', $ticket->solucion) }}</textarea>
                </div>

                <div class="flex justify-end gap-3 pt-3 border-t border-slate-200">
                    <a href="{{ route('tickets.index') }}" class="px-4 py-2.5 rounded-lg text-xs font-bold bg-slate-200 hover:bg-slate-300 text-slate-700 transition">
                        Cancelar
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-lg text-xs font-bold bg-emerald-600 hover:bg-emerald-500 text-white shadow-md cursor-pointer transition">
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