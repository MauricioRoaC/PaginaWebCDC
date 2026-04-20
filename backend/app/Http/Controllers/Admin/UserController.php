<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Unit;
use App\Models\ActivityLog;

class UserController extends Controller
{
    // Solo el superadmin puede manejar usuarios
   private function authorizeSuperadmin()
{
    $user = Auth::user(); // obtenemos el usuario autenticado

    if (!$user || $user->role !== 'superadmin') {
        abort(403, 'No tienes permisos para gestionar usuarios.');
    }
}


    public function index()
    {
        $this->authorizeSuperadmin();

        $users = User::orderBy('role')->orderBy('name')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

 public function create()
{
    $this->authorizeSuperadmin();

    $units = Unit::all(); 

    return view('admin.users.create', compact('units'));
}

   public function store(Request $request)
{
    $this->authorizeSuperadmin();

    $data = $request->validate([
        'name'      => 'required|string|max:255',
        'email'     => 'required|email|max:255|unique:users,email',
        'password'  => 'required|string|min:8|confirmed',
        'role'      => 'required|in:superadmin,admin',
        'unit_id'   => 'required|exists:units,id',
        'is_active' => 'nullable|boolean',
    ]);

    $data['password']  = Hash::make($data['password']);
    $data['is_active'] = $request->boolean('is_active');

    $user = User::create($data);

    // 🔥 HELPER (forma limpia)
    logActivity('create', 'users', 'Creó usuario: ' . $user->name);

    return redirect()->route('admin.users.index')
        ->with('success', 'Usuario creado correctamente.');
}

    public function edit(User $user)
    {
        $this->authorizeSuperadmin();

        // opcional: evitar que se edite a sí mismo desde aquí, eso se hará en "Perfil"
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorizeSuperadmin();

        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|max:255|unique:users,email,' . $user->id,
            'password'  => 'nullable|string|min:8|confirmed',
            'role'      => 'required|in:superadmin,admin',
            'unit_id' => 'required|exists:units,id',
            'is_active' => 'nullable|boolean',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['is_active'] = $request->boolean('is_active');

        $user->update($data);
        ActivityLog::create([
    'user_id' => Auth::id(),
    'action' => 'update',
    'module' => 'users',
    'description' => 'Actualizó usuario: ' . $user->name
]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $user)
    {
        $this->authorizeSuperadmin();

        // Evitar que se borre a sí mismo
      if ($user->id === Auth::id()) {

            return back()->with('success', 'No puedes eliminar tu propio usuario.');
        }

        $user->delete();
        ActivityLog::create([
    'user_id' => Auth::id(),
    'action' => 'delete',
    'module' => 'users',
    'description' => 'Eliminó usuario: ' . $user->name
]);
        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
