<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recepción de Soporte Técnico - OTSI MDSS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen font-sans antialiased">

    <!-- Cabecera Institucional Municipal -->
    <header class="bg-[#0b1f3a] text-white shadow-lg border-b-4 border-amber-400 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-6 py-3.5 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-xl bg-white/10 border border-amber-400/70 flex items-center justify-center shadow">
                    <svg class="w-6 h-6 text-amber-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 2L4 5.5v6.09c0 5.05 3.41 9.76 8 10.91 4.59-1.15 8-5.86 8-10.91V5.5L12 2z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"/>
                    </svg>
                </div>
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-[0.18em] text-amber-400 block">Municipalidad Distrital de San Sebastián</span>
                    <h1 class="text-base font-extrabold tracking-tight text-white">SISTEC OTSI — Soporte Técnico e Informático</h1>
                </div>
            </div>

            <nav class="flex flex-wrap items-center gap-2 text-xs font-bold">
                <a href="{{ route('tickets.index') }}" class="px-4 py-2 rounded-lg bg-amber-400 text-[#0b1f3a] shadow-sm">
                    1. Recepción de Equipos
                </a>
                <a href="{{ route('tickets.historial') }}" class="px-4 py-2 rounded-lg bg-white/10 hover:bg-white/20 text-white transition">
                    2. Trazabilidad Patrimonial
                </a>
                @if(auth()->user()->esJefe())
                    <a href="{{ route('usuarios.index') }}" class="px-4 py-2 rounded-lg bg-white/10 hover:bg-white/20 text-white transition">
                        3. Personal OTSI
                    </a>
                @endif
                <div class="flex items-center gap-2.5 pl-3 ml-1 border-l border-white/20">
                    <span class="text-[11px] font-medium text-blue-100 hidden sm:inline">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-3 py-2 rounded-lg bg-red-600 hover:bg-red-500 text-white cursor-pointer transition">
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            </nav>
        </div>
    </header>

    <main class="max-w-7xl mx-auto p-6 space-y-6">

        @if (session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-300 text-emerald-800 text-sm font-semibold flex items-center gap-2 shadow-sm">
                <span class="text-emerald-600 font-bold">✓</span> {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 rounded-xl bg-red-50 border border-red-300 text-red-700 text-xs font-medium space-y-1 shadow-sm">
                @foreach ($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Tarjetas de Resumen Operativo -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl p-4 border border-slate-200 border-l-4 border-l-[#0b1f3a] shadow-sm">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Total Órdenes</span>
                <p class="text-2xl font-black text-slate-900 mt-1">{{ $tickets->count() }}</p>
            </div>
            <div class="bg-white rounded-xl p-4 border border-slate-200 border-l-4 border-l-blue-600 shadow-sm">
                <span class="text-[11px] font-bold uppercase tracking-wider text-blue-700">Recepcionados</span>
                <p class="text-2xl font-black text-blue-700 mt-1">{{ $tickets->where('estado', 'Recepcionado')->count() }}</p>
            </div>
            <div class="bg-white rounded-xl p-4 border border-slate-200 border-l-4 border-l-amber-500 shadow-sm">
                <span class="text-[11px] font-bold uppercase tracking-wider text-amber-700">En Atención</span>
                <p class="text-2xl font-black text-amber-600 mt-1">{{ $tickets->where('estado', 'En Atención')->count() }}</p>
            </div>
            <div class="bg-white rounded-xl p-4 border border-slate-200 border-l-4 border-l-emerald-600 shadow-sm">
                <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-700">Completados</span>
                <p class="text-2xl font-black text-emerald-600 mt-1">{{ $tickets->where('estado', 'Completado')->count() }}</p>
            </div>
        </div>

        <!-- Formulario de Recepción (PBI-01) -->
        <section class="bg-white rounded-2xl border border-slate-200 shadow-md overflow-hidden">
            <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex flex-wrap items-center justify-between gap-2">
                <div>
                    <h2 class="text-base font-extrabold text-[#0b1f3a]">Registrar Nueva Ficha de Recepción (PBI-01)</h2>
                    <p class="text-xs text-slate-500">Complete los datos del servidor público y el código patrimonial SBN del equipo.</p>
                </div>
                <span class="px-3 py-1 rounded-full bg-blue-50 border border-blue-200 text-[#0b1f3a] font-bold text-xs">
                    Formato OTSI-MDSS
                </span>
            </div>

            <form method="POST" action="{{ route('tickets.store') }}" class="p-6 space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">DNI del Solicitante (8 dígitos) *</label>
                        <input type="text" name="dni" value="{{ old('dni') }}" required maxlength="8" inputmode="numeric"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 8); this.setCustomValidity('');"
                            oninvalid="this.setCustomValidity('Por favor, ingrese el DNI del solicitante (8 dígitos).')"
                            placeholder="Ej. 76938244"
                            class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm font-mono text-slate-900 focus:bg-white focus:border-[#0b1f3a] focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Área Municipal Usuaria *</label>
                        <select name="area_id" required
                            oninvalid="this.setCustomValidity('Por favor, seleccione un área municipal.')"
                            onchange="this.setCustomValidity('')"
                            class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm text-slate-900 focus:bg-white focus:border-[#0b1f3a] focus:outline-none">
                            <option value="">Seleccione un área...</option>
                            @foreach ($areas as $area)
                                <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>{{ $area->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Código Patrimonial SBN (12 dígitos) *</label>
                        <input type="text" name="codigo_patrimonial" value="{{ old('codigo_patrimonial') }}" required maxlength="12" inputmode="numeric"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12); this.setCustomValidity('');"
                            oninvalid="this.setCustomValidity('Por favor, ingrese el código patrimonial SBN de 12 dígitos.')"
                            placeholder="Ej. 740899500123"
                            class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm font-mono text-slate-900 focus:bg-white focus:border-[#0b1f3a] focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Asunto / Título de la Incidencia *</label>
                        <input type="text" name="titulo" value="{{ old('titulo') }}" required
                            oninvalid="this.setCustomValidity('Por favor, ingrese el asunto de la incidencia.')"
                            oninput="this.setCustomValidity('')"
                            placeholder="Ej. Falla en conexión de red o SIADEG"
                            class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm text-slate-900 focus:bg-white focus:border-[#0b1f3a] focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Categoría / Tipo de Equipo (PBI-05) *</label>
                        <select name="categoria_id" required
                            oninvalid="this.setCustomValidity('Por favor, seleccione la categoría del equipo.')"
                            onchange="this.setCustomValidity('')"
                            class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm text-slate-900 focus:bg-white focus:border-[#0b1f3a] focus:outline-none">
                            <option value="">Seleccione categoría...</option>
                            @foreach ($categorias as $cat)
                                <option value="{{ $cat->id }}" {{ old('categoria_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nivel de Prioridad *</label>
                        <select name="prioridad" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm text-slate-900 focus:bg-white focus:border-[#0b1f3a] focus:outline-none">
                            <option value="Baja" {{ old('prioridad') === 'Baja' ? 'selected' : '' }}>Baja (Mantenimiento preventivo)</option>
                            <option value="Media" {{ old('prioridad', 'Media') === 'Media' ? 'selected' : '' }}>Media (Atención preferente)</option>
                            <option value="Alta" {{ old('prioridad') === 'Alta' ? 'selected' : '' }}>Alta (Urgente / Oficina detenida)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Descripción Detallada de la Falla *</label>
                    <textarea name="descripcion" rows="2" required
                        oninvalid="this.setCustomValidity('Por favor, describa los síntomas reportados.')"
                        oninput="this.setCustomValidity('')"
                        placeholder="Describa los síntomas reportados por el usuario, mensajes de error o accesorios entregados..."
                        class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm text-slate-900 focus:bg-white focus:border-[#0b1f3a] focus:outline-none">{{ old('descripcion') }}</textarea>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="reset" class="px-4 py-2.5 rounded-lg text-xs font-bold bg-slate-200 hover:bg-slate-300 text-slate-700 cursor-pointer transition">
                        Limpiar Formulario
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-lg text-xs font-bold bg-[#0b1f3a] hover:bg-[#143563] text-white border-b-2 border-amber-400 shadow-md cursor-pointer transition">
                        ✓ Registrar Ticket de Soporte
                    </button>
                </div>
            </form>
        </section>

        <!-- Bandeja de Equipos en Custodia -->
        <section class="bg-white rounded-2xl border border-slate-200 shadow-md overflow-hidden">
            <div class="bg-slate-50 border-b border-slate-200 px-6 py-4 flex items-center justify-between">
                <h2 class="text-base font-extrabold text-[#0b1f3a]">Bandeja de Equipos en Custodia OTSI</h2>
                <span class="px-3 py-1 rounded-full bg-slate-200 text-slate-800 text-xs font-bold">
                    Total registros: {{ $tickets->count() }}
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-100 border-b border-slate-200 text-[11px] font-bold uppercase tracking-wider text-slate-600">
                            <th class="py-3.5 px-4">Orden / SBN</th>
                            <th class="py-3.5 px-4">Área y Problema Reportado</th>
                            <th class="py-3.5 px-4">Prioridad</th>
                            <th class="py-3.5 px-4">Estado</th>
                            <th class="py-3.5 px-4 text-right">Taller Técnico</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse ($tickets as $t)
                            <tr class="hover:bg-blue-50/50 transition">
                                <td class="py-3.5 px-4">
                                    <span class="font-mono font-extrabold text-[#0b1f3a] block">#{{ str_pad($t->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    <span class="font-mono text-[11px] text-slate-600">SBN: {{ $t->codigo }}</span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="font-bold text-slate-900 block text-sm">{{ $t->titulo }}</span>
                                    <span class="text-slate-500 text-[11px]">{{ $t->areaMunicipal->nombre ?? 'Sin área' }} • DNI: {{ $t->solicitante }}</span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="px-2.5 py-1 rounded-md font-bold text-[10px] uppercase
                                        {{ $t->prioridad === 'Alta' ? 'bg-red-100 text-red-800 border border-red-200' : ($t->prioridad === 'Media' ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-slate-100 text-slate-700 border border-slate-200') }}">
                                        {{ $t->prioridad }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="px-3 py-1 rounded-full font-bold text-[11px]
                                        {{ $t->estado === 'Completado' ? 'bg-emerald-100 text-emerald-800' : ($t->estado === 'En Atención' ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800') }}">
                                        {{ $t->estado }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <a href="{{ route('tickets.edit', $t->id) }}"
                                       class="inline-block px-3.5 py-2 rounded-lg bg-[#0b1f3a] hover:bg-[#143563] text-white font-bold text-[11px] shadow-sm transition">
                                        Atender Orden →
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-500">No hay tickets registrados aún.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>