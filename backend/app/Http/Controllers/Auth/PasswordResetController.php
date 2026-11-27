<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
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
                ->with('status', 'Si el correo está registrado, recibirás un enlace de recuperación.');
        }

        // Generar token
        $token = Str::random(64);

        // Eliminar tokens anteriores para ese correo
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Insertar nuevo token
        DB::table('password_reset_tokens')->insert([
            'email'      => $request->email,
            'token'      => hash('sha256', $token),
            'created_at' => Carbon::now(),
        ]);

        // Enviar correo simple con el enlace
       $resetLink = route('admin.password.reset', [
    'token' => $token,
    'email' => $request->email,
]);



        try {
            Http::withHeaders(['api-key' => config('services.brevo.key')])
                ->acceptJson()->timeout(15)
                ->post('https://api.brevo.com/v3/smtp/email', [
                    'sender' => ['name' => config('mail.from.name'), 'email' => config('mail.from.address')],
                    'to' => [['email' => $user->email]],
                    'subject' => 'Restablecer contraseña - Comando Departamental de Cochabamba',
                    'textContent' => "Para restablecer tu contraseña, abre este enlace (válido durante 60 minutos):\n\n$resetLink\n\nSi no solicitaste este cambio, ignora este correo.",
                ])->throw();
        } catch (\Throwable $exception) {
            DB::table('password_reset_tokens')->where('email', $user->email)
                ->where('token', hash('sha256', $token))->delete();
            return back()->withErrors(['email' => 'No se pudo enviar el correo. Intenta nuevamente más tarde.']);
        }

        return back()->with('status', 'Si el correo está registrado, recibirás un enlace de recuperación.');
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
            'token'    => ['required', 'string', 'size:64'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'confirmed', 'min:8'],
        ]);

        // Buscar el token en la tabla
        $tokenData = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', hash('sha256', $request->token))
            ->where('created_at', '>=', now()->subMinutes(60))
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
