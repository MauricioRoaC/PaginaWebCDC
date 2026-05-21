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


   public function index(Request $request)
{
    $this->authorizeSuperadmin();

    $query = User::query();

    // 🔍 BUSCADOR

    if ($request->search) {

        $query->where(function ($q) use ($request) {

            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%');

        });

    }

    // 🔍 FILTRO ROL

    if ($request->role) {

        $query->where('role', $request->role);

    }

    $users = $query
        ->orderBy('role')
        ->orderBy('name')
        ->paginate(10)
        ->withQueryString();

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
    ]);

    $data['password']  = Hash::make($data['password']);
    $data['is_active'] = true;

    $user = User::create($data);

    // 🔥 HELPER (forma limpia)
    logActivity('create', 'users', 'Creó usuario: ' . $user->name);

    return redirect()->route('admin.users.index')
        ->with('success', 'Usuario creado correctamente.');
}

   public function edit(User $user)
{
    $this->authorizeSuperadmin();

    $units = Unit::all();

    return view('admin.users.edit', compact('user', 'units'));
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
            'is_active' => 'nullable',
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

            return back()->with('error', 'No puedes eliminar tu propio usuario.');
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
