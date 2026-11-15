<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View|RedirectResponse
    {
        if (! Auth::user()?->esJefe()) {
            return redirect()->route('tickets.index')
                ->with('error', 'Acceso restringido: módulo exclusivo del Jefe/Gerente OTSI.');
        }

        $usuarios = User::withCount('ticketsRegistrados')
            ->orderByDesc('activo')
            ->orderBy('name')
            ->get();

        return view('usuarios.index', compact('usuarios'));
    }

    public function store(Request $request): RedirectResponse
    {
        if (! Auth::user()?->esJefe()) {
            abort(403);
        }

        $datos = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'cargo' => ['required', 'string', 'max:120'],
            'rol' => ['required', 'in:jefe,tecnico'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'name.required' => 'El nombre completo del trabajador es obligatorio.',
            'email.required' => 'El correo institucional es obligatorio.',
            'email.unique' => 'Ese correo institucional ya está registrado.',
            'cargo.required' => 'Especifique el cargo o especialidad.',
            'password.min' => 'La contraseña debe tener mínimo 6 caracteres.',
        ]);

        User::create([
            'name' => $datos['name'],
            'email' => $datos['email'],
            'cargo' => $datos['cargo'],
            'rol' => $datos['rol'],
            'activo' => true,
            'password' => $datos['password'],
        ]);

        return redirect()->route('usuarios.index')
            ->with('success', 'Trabajador incorporado al sistema OTSI correctamente.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if (! Auth::user()?->esJefe()) {
            abort(403);
        }

        if ($user->id === Auth::id()) {
            return redirect()->route('usuarios.index')
                ->with('error', 'No puede eliminar su propia cuenta de Gerente activa.');
        }

        $user->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Acceso eliminado. Los tickets previos registrados por el trabajador se conservan en historial.');
    }
}
