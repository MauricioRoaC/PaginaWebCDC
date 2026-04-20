<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    // Formulario: "ingresa tu correo"
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    // Procesa el correo y envía link
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()
                ->withErrors(['email' => 'El correo no está registrado en el sistema'])
                ->withInput();
        }

        // Generar token
        $token = Str::random(64);

        // Eliminar tokens anteriores para ese correo
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Insertar nuevo token
        DB::table('password_reset_tokens')->insert([
            'email'      => $request->email,
            'token'      => $token,
            'created_at' => Carbon::now(),
        ]);

        // Enviar correo simple con el enlace
       $resetLink = route('admin.password.reset', [
    'token' => $token,
    'email' => $request->email,
]);



        Mail::raw(
            "Hola, para restablecer tu contraseña del Panel Administrativo haz clic en el siguiente enlace:\n\n$resetLink\n\nSi no solicitaste este cambio, ignora este correo.",
            function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Restablecer contraseña - Comando Departamental de Cochabamba');
            }
        );

        return back()->with('status', 'Hemos enviado un enlace de recuperación a tu correo.');
    }

    // Formulario de nueva contraseña
    public function showResetForm(Request $request, $token)
    {
        $email = $request->query('email');
        return view('auth.reset-password', compact('token', 'email'));
    }

    // Guardar nueva contraseña
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => ['required'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        // Buscar el token en la tabla
        $tokenData = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (! $tokenData) {
            return back()->withErrors(['email' => 'El enlace no es válido o ha expirado.']);
        }

        // Actualizar la contraseña del usuario
        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->withErrors(['email' => 'El correo no está registrado en el sistema.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Borrar token usado
        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect()->route('login')
            ->with('status', 'Tu contraseña se ha actualizado. Ahora puedes iniciar sesión.');
    }
}
