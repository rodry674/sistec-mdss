<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tickets - SISTEC MDSS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-900 min-h-screen flex items-center justify-center p-4 sm:p-6 font-sans antialiased text-slate-100">

    <div class="max-w-2xl w-full bg-slate-800 rounded-2xl shadow-2xl border border-slate-700 overflow-hidden">
        
        <!-- Encabezado del Módulo -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2H5z"></path></svg>
                    SISTEC | Registro de Ticket
                </h2>
                <p class="text-blue-100 text-sm mt-1">Módulo de Atención y Soporte Técnico</p>
            </div>
            <span class="bg-blue-500/30 text-blue-200 text-xs px-3 py-1 rounded-full border border-blue-400/30 font-semibold uppercase tracking-wider">PBI-02 UI</span>
        </div>

        <!-- Formulario Principal -->
        <form action="#" method="POST" class="p-8 space-y-6">
            @csrf

            <!-- Fila 1: Título -->
            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Asunto / Título del Requimiento <span class="text-red-400">*</span></label>
                <input type="text" name="titulo" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all placeholder-slate-500" placeholder="Ej. Falla de conectividad en laboratorio N° 3" required>
            </div>

            <!-- Fila 2: Categoría y Prioridad -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Categoría <span class="text-red-400">*</span></label>
                    <select name="categoria" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                        <option value="hardware">Hardware / Equipos</option>
                        <option value="software">Software / Sistemas</option>
                        <option value="redes">Redes e Internet</option>
                        <option value="otros">Otros Requerimientos</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Nivel de Prioridad <span class="text-red-400">*</span></label>
                    <select name="prioridad" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                        <option value="baja">🟢 Baja (Atención normal)</option>
                        <option value="media" selected>🟡 Media (Atención preferente)</option>
                        <option value="alta">🔴 Alta (Urgencia técnica)</option>
                    </select>
                </div>
            </div>

            <!-- Fila 3: Descripción detallada -->
            <div>
                <label class="block text-sm font-semibold text-slate-300 mb-2">Descripción Detallada de la Falla <span class="text-red-400">*</span></label>
                <textarea name="descripcion" rows="4" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all placeholder-slate-500" placeholder="Describa brevemente lo ocurrido..." required></textarea>
            </div>

            <!-- Botones de Acción -->
            <div class="flex items-center justify-end space-x-4 pt-4 border-t border-slate-700/60">
                <button type="button" class="px-5 py-2.5 rounded-xl border border-slate-600 text-slate-300 hover:bg-slate-700 font-medium transition-all text-sm">Limpiar</button>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-semibold shadow-lg shadow-blue-500/25 transition-all text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Registrar Ticket de Soporte
                </button>
            </div>
        </form>

    </div>

</body>
</html>