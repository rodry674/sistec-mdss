<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trazabilidad Patrimonial - OTSI MDSS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen font-sans antialiased">

    <nav class="bg-slate-900/95 backdrop-blur border-b border-slate-800 px-6 py-4 sticky top-0 z-20">
        <div class="max-w-6xl mx-auto flex flex-wrap justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="bg-blue-600 text-white font-bold px-3 py-1.5 rounded-lg text-sm tracking-wide shadow-md shadow-blue-950">OTSI</div>
                <div>
                    <h1 class="font-bold text-slate-100 text-base leading-tight">Trazabilidad e Historial Patrimonial</h1>
                    <p class="text-xs text-slate-400">Municipalidad Distrital de San Sebastián — Cusco</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('tickets.index') }}" class="px-4 py-2 rounded-lg text-xs font-medium bg-slate-800 text-slate-300 hover:bg-slate-700 transition">
                    1. Recepción de Equipos
                </a>
                <a href="{{ route('tickets.historial') }}" class="px-4 py-2 rounded-lg text-xs font-semibold bg-blue-600 text-white shadow-sm">
                    2. Trazabilidad Patrimonial
                </a>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto p-6 space-y-6">

        <!-- Indicadores Gerenciales KPI -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-slate-900 border border-slate-800 p-5 rounded-2xl shadow-md">
                <span class="text-xs text-slate-400">Total Intervenciones</span>
                <p class="text-3xl font-bold text-white mt-1">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-slate-900 border border-slate-800 p-5 rounded-2xl shadow-md">
                <span class="text-xs text-slate-400">En Cola (Recepcionados)</span>
                <p class="text-3xl font-bold text-amber-400 mt-1">{{ $stats['recepcionados'] }}</p>
            </div>
            <div class="bg-slate-900 border border-slate-800 p-5 rounded-2xl shadow-md">
                <span class="text-xs text-slate-400">En Taller Técnico</span>
                <p class="text-3xl font-bold text-blue-400 mt-1">{{ $stats['en_atencion'] }}</p>
            </div>
            <div class="bg-slate-900 border border-slate-800 p-5 rounded-2xl shadow-md">
                <span class="text-xs text-slate-400">Atenciones Completadas</span>
                <p class="text-3xl font-bold text-emerald-400 mt-1">{{ $stats['completados'] }}</p>
            </div>
        </div>

        <!-- Buscador por Código Patrimonial (PBI-04) -->
        <section class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-xl">
            <h2 class="text-sm font-semibold text-white mb-3">Consultar Hoja de Vida por Código Patrimonial SBN (PBI-04)</h2>
            <form action="{{ route('tickets.historial') }}" method="GET" class="flex flex-wrap gap-3">
                <input type="text" name="codigo" value="{{ $codigo }}" maxlength="12" inputmode="numeric"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12)"
                    placeholder="Ingrese los 12 dígitos del Código Patrimonial (Ej. 740899500123)..."
                    class="flex-1 min-w-[260px] bg-slate-950 border border-slate-700 rounded-lg px-4 py-2.5 text-sm font-mono text-white focus:border-blue-500 focus:outline-none">
                <button type="submit" class="px-6 py-2.5 rounded-lg text-xs font-semibold bg-blue-600 hover:bg-blue-500 text-white transition">
                    Buscar Historial Técnico
                </button>
                @if ($codigo)
                    <a href="{{ route('tickets.historial') }}" class="px-4 py-2.5 rounded-lg text-xs font-medium bg-slate-800 hover:bg-slate-700 text-slate-300 transition">
                        Mostrar Todos
                    </a>
                @endif
            </form>
        </section>

        <!-- Cronología de Mantenimientos -->
        <section class="space-y-4">
            @forelse ($historial as $item)
                <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 space-y-3 shadow-md">
                    <div class="flex flex-wrap justify-between items-center gap-2 border-b border-slate-800/80 pb-3">
                        <div class="flex items-center gap-3">
                            <span class="font-mono text-xs font-bold text-blue-400 bg-blue-950/70 px-3 py-1 rounded-lg border border-blue-800">
                                SBN: {{ $item->codigo }}
                            </span>
                            <h3 class="font-semibold text-white text-sm">{{ $item->titulo }}</h3>
                        </div>
                        <div class="flex items-center gap-3 text-xs">
                            <span class="text-slate-400">Ingreso: {{ $item->created_at->format('d/m/Y H:i') }}</span>
                            @if ($item->fecha_cierre)
                                <span class="text-emerald-400 font-medium">• Cierre: {{ \Carbon\Carbon::parse($item->fecha_cierre)->format('d/m/Y H:i') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-x-6 gap-y-1 text-xs text-slate-400">
                        <span>Área: <strong class="text-slate-200">{{ $item->areaMunicipal->nombre ?? 'N/A' }}</strong></span>
                        <span>Equipo: <strong class="text-slate-200">{{ $item->categoria->nombre ?? 'N/A' }}</strong></span>
                        <span>Técnico: <strong class="text-slate-200">{{ $item->tecnico ? $item->tecnico->nombres . ' ' . $item->tecnico->apellidos : 'Sin asignar' }}</strong></span>
                        <span>Estado: <strong class="{{ $item->estado === 'Completado' ? 'text-emerald-400' : 'text-amber-400' }}">{{ $item->estado }}</strong></span>
                    </div>

                    @if ($item->diagnostico)
                        <div class="bg-slate-950 p-4 rounded-xl text-xs text-slate-300 border border-slate-800 space-y-2">
                            <p><strong class="text-slate-400">Diagnóstico Técnico:</strong> {{ $item->diagnostico }}</p>
                            @if ($item->solucion)
                                <p class="whitespace-pre-line"><strong class="text-emerald-400">Trabajos Ejecutados:</strong><br>{{ $item->solucion }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-slate-900 border border-slate-800 rounded-2xl p-10 text-center text-slate-500 text-sm">
                    No se encontraron registros históricos para el criterio consultado.
                </div>
            @endforelse
        </section>
    </main>
</body>
</html>