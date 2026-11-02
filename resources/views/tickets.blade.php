<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tickets</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4 text-gray-800 text-center">Registro de Ticket</h2>
        <form action="#" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Título / Nombre</label>
                <input type="text" name="titulo" class="mt-1 block w-full rounded-md border-gray-300 border p-2 shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Ingrese título" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Descripción / Detalle</label>
                <textarea name="descripcion" rows="4" class="mt-1 block w-full rounded-md border-gray-300 border p-2 shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Ingrese detalle del soporte" required></textarea>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-150">Guardar Registro</button>
            </div>
        </form>
    </div>
</body>
</html>