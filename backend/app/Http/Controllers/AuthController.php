<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validar formulario
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Buscar usuario
        $user = User::firstWhere('email', $credentials['email']);
        // Verificar si existe y está inactivo
        if ($user && !$user->is_active) {

            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Su cuenta ha sido desactivada por el administrador.',
                ]);
        }

        // Intentar autenticación
        if (Auth::attempt($credentials, $request->boolean('remember'))) {

            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Credenciales incorrectas.',
            ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}