<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('tickets.index');
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credenciales = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Ingrese su correo institucional.',
            'email.email' => 'El formato del correo no es válido.',
            'password.required' => 'Ingrese su contraseña de acceso.',
        ]);

        if (Auth::attempt(['email' => $credenciales['email'], 'password' => $credenciales['password'], 'activo' => true])) {
            $request->session()->regenerate();

            return redirect()->intended(route('tickets.index'));
        }

        return back()
            ->withErrors(['email' => 'Credenciales incorrectas o cuenta retirada del sistema OTSI.'])
            ->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
