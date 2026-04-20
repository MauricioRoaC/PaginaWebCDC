<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Muestra el formulario de perfil
    public function edit()
    {
        $user = Auth::user(); // usuario logueado
        return view('admin.profile.edit', compact('user'));
    }

    // Actualiza los datos del usuario
    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Datos básicos
        $user->name  = $data['name'];
        $user->email = $data['email'];

        // Contraseña (solo si se llenó)
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        // Foto de perfil
        if ($request->hasFile('avatar')) {
            // borrar la anterior si existe
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // guardar nueva
            $path = $request->file('avatar')->store('users', 'public');
            $user->avatar = $path;
        }

        $user->save();

        return redirect()
            ->route('admin.profile.edit')
            ->with('success', 'Perfil actualizado correctamente.');
    }
}




