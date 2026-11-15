<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trazabilidad Patrimonial - OTSI MDSS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen font-sans antialiased">

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
                    <h1 class="text-base font-extrabold tracking-tight text-white">Trazabilidad e Historial Patrimonial OTSI</h1>
                </div>
            </div>

            <nav class="flex flex-wrap items-center gap-2 text-xs font-bold">
                <a href="{{ route('tickets.index') }}" class="px-4 py-2 rounded-lg bg-white/10 hover:bg-white/20 text-white transition">
                    1. Recepción de Equipos
                </a>
                <a href="{{ route('tickets.historial') }}" class="px-4 py-2 rounded-lg bg-amber-400 text-[#0b1f3a] shadow-sm">
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

        <!-- Indicadores Gerenciales KPI -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white border border-slate-200 border-l-4 border-l-[#0b1f3a] p-5 rounded-xl shadow-sm">
                <span class="text-xs font-bold text-slate-500">Total Intervenciones</span>
                <p class="text-3xl font-black text-slate-900 mt-1">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white border border-slate-200 border-l-4 border-l-amber-500 p-5 rounded-xl shadow-sm">
                <span class="text-xs font-bold text-amber-700">En Cola (Recepcionados)</span>
                <p class="text-3xl font-black text-amber-600 mt-1">{{ $stats['recepcionados'] }}</p>
            </div>
            <div class="bg-white border border-slate-200 border-l-4 border-l-blue-600 p-5 rounded-xl shadow-sm">
                <span class="text-xs font-bold text-blue-700">En Taller Técnico</span>
                <p class="text-3xl font-black text-blue-700 mt-1">{{ $stats['en_atencion'] }}</p>
            </div>
            <div class="bg-white border border-slate-200 border-l-4 border-l-emerald-600 p-5 rounded-xl shadow-sm">
                <span class="text-xs font-bold text-emerald-700">Atenciones Completadas</span>
                <p class="text-3xl font-black text-emerald-600 mt-1">{{ $stats['completados'] }}</p>
            </div>
        </div>

        <!-- Buscador por Código Patrimonial (PBI-04) -->
        <section class="bg-white border border-slate-200 rounded-2xl p-6 shadow-md">
            <h2 class="text-sm font-extrabold text-[#0b1f3a] mb-3">Consultar Hoja de Vida por Código Patrimonial SBN (PBI-04)</h2>
            <form action="{{ route('tickets.historial') }}" method="GET" class="flex flex-wrap gap-3">
                <input type="text" name="codigo" value="{{ $codigo }}" maxlength="12" inputmode="numeric"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12)"
                    placeholder="Ingrese los 12 dígitos del Código Patrimonial (Ej. 740899500123)..."
                    class="flex-1 min-w-[260px] bg-slate-50 border border-slate-300 rounded-lg px-4 py-2.5 text-sm font-mono text-slate-900 focus:bg-white focus:border-[#0b1f3a] focus:outline-none">
                <button type="submit" class="px-6 py-2.5 rounded-lg text-xs font-bold bg-[#0b1f3a] hover:bg-[#143563] text-white border-b-2 border-amber-400 cursor-pointer transition">
                    Buscar Historial Técnico
                </button>
                @if ($codigo)
                    <a href="{{ route('tickets.historial') }}" class="px-4 py-2.5 rounded-lg text-xs font-bold bg-slate-200 hover:bg-slate-300 text-slate-700 transition">
                        Mostrar Todos
                    </a>
                @endif
            </form>
        </section>

        <!-- Cronología de Mantenimientos -->
        <section class="space-y-4">
            @forelse ($historial as $item)
                <div class="bg-white border border-slate-200 rounded-2xl p-5 space-y-3 shadow-sm border-l-4 {{ $item->estado === 'Completado' ? 'border-l-emerald-500' : ($item->estado === 'En Atención' ? 'border-l-amber-500' : 'border-l-blue-600') }}">
                    <div class="flex flex-wrap justify-between items-center gap-2 border-b border-slate-100 pb-3">
                        <div class="flex items-center gap-3">
                            <span class="font-mono text-xs font-bold text-[#0b1f3a] bg-blue-50 px-3 py-1 rounded-lg border border-blue-200">
                                SBN: {{ $item->codigo }}
                            </span>
                            <h3 class="font-extrabold text-slate-900 text-sm">{{ $item->titulo }}</h3>
                        </div>
                        <div class="flex items-center gap-3 text-xs">
                            <span class="text-slate-500">Ingreso: <strong class="text-slate-800">{{ $item->created_at->format('d/m/Y H:i') }}</strong></span>
                            @if ($item->fecha_cierre)
                                <span class="text-emerald-700 font-bold">Cierre: {{ \Carbon\Carbon::parse($item->fecha_cierre)->format('d/m/Y H:i') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-x-6 gap-y-1 text-xs text-slate-500">
                        <span>Área: <strong class="text-slate-800">{{ $item->areaMunicipal->nombre ?? 'N/A' }}</strong></span>
                        <span>Equipo: <strong class="text-slate-800">{{ $item->categoria->nombre ?? 'N/A' }}</strong></span>
                        <span>Técnico: <strong class="text-slate-800">{{ $item->tecnico ? $item->tecnico->nombres . ' ' . $item->tecnico->apellidos : 'Sin asignar' }}</strong></span>
                        @if ($item->registradoPor)
                            <span>Recepcionó: <strong class="text-slate-800">{{ $item->registradoPor->name }}</strong></span>
                        @endif
                        <span>Estado: <strong class="{{ $item->estado === 'Completado' ? 'text-emerald-700' : 'text-amber-700' }}">{{ $item->estado }}</strong></span>
                    </div>

                    @if ($item->diagnostico)
                        <div class="bg-slate-50 p-4 rounded-xl text-xs text-slate-700 border border-slate-200 space-y-2">
                            <p><strong class="text-[#0b1f3a]">Diagnóstico Técnico:</strong> {{ $item->diagnostico }}</p>
                            @if ($item->solucion)
                                <p class="whitespace-pre-line"><strong class="text-emerald-700">Trabajos Ejecutados:</strong><br>{{ $item->solucion }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-white border border-slate-200 rounded-2xl p-10 text-center text-slate-500 text-sm shadow-sm">
                    No se encontraron registros históricos para el criterio consultado.
                </div>
            @endforelse
        </section>
    </main>
</body>
</html>