<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Personal OTSI - MDSS</title>
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
                    <span class="text-[10px] font-bold uppercase tracking-[0.18em] text-amber-400 block">Jefatura de Tecnologías y Sistemas Informáticos</span>
                    <h1 class="text-base font-extrabold tracking-tight text-white">Control de Personal y Notificaciones OTSI</h1>
                </div>
            </div>

            <nav class="flex flex-wrap items-center gap-2 text-xs font-bold">
                <a href="{{ route('tickets.index') }}" class="px-4 py-2 rounded-lg bg-white/10 hover:bg-white/20 text-white transition">1. Recepción de Equipos</a>
                <a href="{{ route('tickets.historial') }}" class="px-4 py-2 rounded-lg bg-white/10 hover:bg-white/20 text-white transition">2. Trazabilidad Patrimonial</a>
                <a href="{{ route('usuarios.index') }}" class="px-4 py-2 rounded-lg bg-amber-400 text-[#0b1f3a] shadow-sm">3. Personal OTSI</a>
                <div class="flex items-center gap-2.5 pl-3 ml-1 border-l border-white/20">
                    <span class="text-[11px] font-medium text-blue-100 hidden sm:inline">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-3 py-2 rounded-lg bg-red-600 hover:bg-red-500 text-white cursor-pointer transition">Cerrar Sesión</button>
                    </form>
                </div>
            </nav>
        </div>
    </header>

    <main class="max-w-7xl mx-auto p-6 space-y-6">
        @if (session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-300 text-emerald-800 text-sm font-semibold shadow-sm">✓ {{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="p-4 rounded-xl bg-red-50 border border-red-300 text-red-700 text-sm font-semibold shadow-sm">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="p-4 rounded-xl bg-red-50 border border-red-300 text-red-700 text-xs space-y-1 shadow-sm">
                @foreach ($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <section class="bg-white border border-slate-200 rounded-2xl p-6 shadow-md border-t-4 border-t-[#0b1f3a]">
            <h2 class="text-base font-extrabold text-[#0b1f3a] mb-4">Registrar Ingreso de Nuevo Trabajador OTSI</h2>
            <form method="POST" action="{{ route('usuarios.store') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nombre Completo *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        oninvalid="this.setCustomValidity('Por favor, ingrese el nombre completo del trabajador.')"
                        oninput="this.setCustomValidity('')"
                        placeholder="Ej. Ana Quispe Mamani"
                        class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-sm text-slate-900 focus:bg-white focus:border-[#0b1f3a] focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Correo Institucional *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        oninvalid="this.setCustomValidity(this.validity.valueMissing ? 'Por favor, ingrese el correo institucional.' : 'Ingrese un formato de correo institucional válido.')"
                        oninput="this.setCustomValidity('')"
                        placeholder="aquispe@munisansebastian.gob.pe"
                        class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-sm text-slate-900 focus:bg-white focus:border-[#0b1f3a] focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Cargo / Especialidad *</label>
                    <input type="text" name="cargo" value="{{ old('cargo') }}" required
                        oninvalid="this.setCustomValidity('Por favor, ingrese el cargo o especialidad.')"
                        oninput="this.setCustomValidity('')"
                        placeholder="Soporte Técnico / Redes"
                        class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-sm text-slate-900 focus:bg-white focus:border-[#0b1f3a] focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Rol de Acceso *</label>
                    <select name="rol" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-sm text-slate-900 focus:bg-white focus:border-[#0b1f3a] focus:outline-none">
                        <option value="tecnico" {{ old('rol') === 'tecnico' ? 'selected' : '' }}>Técnico / Operador</option>
                        <option value="jefe" {{ old('rol') === 'jefe' ? 'selected' : '' }}>Jefe / Gerente OTSI</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Contraseña *</label>
                    <div class="flex gap-2">
                        <input type="password" name="password" required minlength="6"
                            oninvalid="this.setCustomValidity(this.validity.valueMissing ? 'Por favor, ingrese una contraseña.' : 'La contraseña debe tener al menos 6 caracteres.')"
                            oninput="this.setCustomValidity('')"
                            placeholder="Mín. 6 caracteres"
                            class="w-full bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-sm text-slate-900 focus:bg-white focus:border-[#0b1f3a] focus:outline-none">
                        <button type="submit" class="bg-[#0b1f3a] hover:bg-[#143563] text-white font-bold px-4 py-2 rounded-lg text-xs whitespace-nowrap border-b-2 border-amber-400 cursor-pointer transition">
                            + Crear
                        </button>
                    </div>
                </div>
            </form>
        </section>

        <section class="bg-white border border-slate-200 rounded-2xl p-6 shadow-md">
            <h2 class="text-base font-extrabold text-[#0b1f3a] mb-4">Personal Registrado y Cantidad de Notificaciones / Tickets por Usuario</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-100 border-b border-slate-200 text-xs font-bold uppercase text-slate-600">
                            <th class="py-3.5 px-4">Trabajador</th>
                            <th class="py-3.5 px-4">Correo Institucional</th>
                            <th class="py-3.5 px-4">Cargo / Rol</th>
                            <th class="py-3.5 px-4 text-center">Notificaciones Registradas</th>
                            <th class="py-3.5 px-4 text-right">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @foreach ($usuarios as $usuario)
                            <tr class="hover:bg-blue-50/50 transition">
                                <td class="py-3.5 px-4 font-bold text-slate-900">{{ $usuario->name }}</td>
                                <td class="py-3.5 px-4 text-slate-600 font-mono text-xs">{{ $usuario->email }}</td>
                                <td class="py-3.5 px-4">
                                    <span class="text-slate-700">{{ $usuario->cargo }}</span>
                                    <span class="ml-2 px-2.5 py-0.5 text-[11px] rounded-full font-bold {{ $usuario->esJefe() ? 'bg-amber-100 text-amber-800 border border-amber-300' : 'bg-blue-100 text-blue-800 border border-blue-200' }}">
                                        {{ strtoupper($usuario->rol) }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-[#0b1f3a] border border-blue-200">
                                        {{ $usuario->tickets_registrados_count }} notificaciones
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    @if ($usuario->id !== auth()->id())
                                        <form method="POST" action="{{ route('usuarios.destroy', $usuario) }}"
                                            onsubmit="return confirm('¿Confirmar eliminación de cuenta para {{ $usuario->name }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-600 hover:bg-red-500 text-white text-xs font-bold cursor-pointer transition">
                                                Eliminar Cuenta
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-slate-400 italic">Sesión actual</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>