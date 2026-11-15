<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Institucional - SISTEC OTSI MDSS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 font-sans antialiased flex items-center justify-center p-4"
      style="background-image: radial-gradient(#cbd5e1 1px, transparent 1px); background-size: 20px 20px;">

    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden border border-slate-200 grid grid-cols-1 md:grid-cols-12">

        <!-- Panel Izquierdo: Identidad Oficial Municipal -->
        <div class="md:col-span-5 bg-gradient-to-br from-[#0b1f3a] via-[#12335e] to-[#081629] text-white p-8 flex flex-col justify-between relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-amber-400 via-yellow-300 to-amber-500"></div>

            <div class="space-y-4 relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-white/10 border border-amber-400/60 flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 text-amber-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 2L4 5.5v6.09c0 5.05 3.41 9.76 8 10.91 4.59-1.15 8-5.86 8-10.91V5.5L12 2z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"/>
                    </svg>
                </div>

                <div>
                    <span class="text-[11px] font-bold uppercase tracking-[0.2em] text-amber-400 block">Cusco — Perú</span>
                    <h2 class="text-xl font-extrabold leading-snug mt-1">Municipalidad Distrital de San Sebastián</h2>
                    <p class="text-xs text-blue-200 mt-2 leading-relaxed">
                        Oficina de Tecnologías y Sistemas Informáticos (OTSI) — Plataforma Oficial de Soporte Técnico y Control Patrimonial.
                    </p>
                </div>
            </div>

            <div class="mt-8 pt-4 border-t border-white/15 text-[11px] text-blue-200/80 space-y-1 relative z-10">
                <p class="font-semibold text-amber-300">SISTEC OTSI v2.0</p>
                <p>Acceso restringido a personal autorizado de la entidad.</p>
            </div>
        </div>

        <!-- Panel Derecho: Formulario de Ingreso -->
        <div class="md:col-span-7 p-8 sm:p-10 flex flex-col justify-center bg-white">
            <div class="mb-6">
                <span class="inline-block px-2.5 py-1 rounded-md bg-blue-50 text-[#0b1f3a] font-bold text-[10px] uppercase tracking-wider border border-blue-200 mb-2">
                    Portal de Autenticación
                </span>
                <h1 class="text-2xl font-extrabold text-slate-900">Iniciar Sesión</h1>
                <p class="text-xs text-slate-500 mt-1">Ingrese sus credenciales institucionales para acceder al sistema.</p>
            </div>

            @if ($errors->any())
                <div class="mb-5 p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs font-medium space-y-1">
                    @foreach ($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Correo Institucional *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        oninvalid="this.setCustomValidity(this.validity.valueMissing ? 'Por favor, ingrese su correo institucional.' : 'Ingrese un formato de correo institucional válido.')"
                        oninput="this.setCustomValidity('')"
                        placeholder="usuario@munisansebastian.gob.pe"
                        class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm text-slate-900 focus:bg-white focus:border-[#0b1f3a] focus:ring-2 focus:ring-blue-900/20 focus:outline-none transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Contraseña *</label>
                    <input type="password" name="password" required
                        oninvalid="this.setCustomValidity('Por favor, ingrese su contraseña institucional.')"
                        oninput="this.setCustomValidity('')"
                        placeholder="••••••••"
                        class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm text-slate-900 focus:bg-white focus:border-[#0b1f3a] focus:ring-2 focus:ring-blue-900/20 focus:outline-none transition">
                </div>

                <button type="submit"
                    class="w-full bg-[#0b1f3a] hover:bg-[#143563] text-white font-bold py-3.5 rounded-xl text-sm tracking-wide shadow-lg shadow-blue-950/20 border-b-2 border-amber-400 transition cursor-pointer">
                    Ingresar al Sistema OTSI →
                </button>
            </form>

            <div class="mt-6 p-3.5 rounded-xl bg-slate-50 border border-slate-200 text-[11px] text-slate-600 space-y-1">
                <p class="font-bold text-slate-800">Cuentas habilitadas:</p>
                <p>• Jefe OTSI: <span class="font-mono text-blue-800 font-semibold">jefe.otsi@munisansebastian.gob.pe</span> / <span class="font-mono font-semibold">otsi2026</span></p>
                <p>• Técnico: <span class="font-mono text-blue-800 font-semibold">lcondori@munisansebastian.gob.pe</span> / <span class="font-mono font-semibold">soporte123</span></p>
            </div>
        </div>
    </div>
</body>
</html>