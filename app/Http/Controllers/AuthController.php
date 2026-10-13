<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function create()
    {
        if (Auth::check()) {
            return redirect()->route($this->routeForUser());
        }

        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'correo' => ['required', 'email', 'max:150'],
            'contrasena' => ['required', 'string', 'max:255'],
        ]);

        $authenticated = Auth::attempt([
            'correo' => $credentials['correo'],
            'password' => $credentials['contrasena'],
            'activo' => 1,
        ]);

        if (!$authenticated) {
            throw ValidationException::withMessages([
                'correo' => 'Credenciales incorrectas o usuario inactivo.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->route($this->routeForUser());
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function routeForUser(): string
    {
        $roleName = DB::table('roles')
            ->where('id_rol', Auth::user()->id_rol)
            ->value('nombre');

        return $roleName === 'MEDICO' ? 'medico.agenda' : 'pacientes.index';
    }
}
