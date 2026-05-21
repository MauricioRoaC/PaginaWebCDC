<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{
    private function authorizeSuperadmin()
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'superadmin') {
            abort(403, 'No tienes permisos.');
        }
    }

  public function index(Request $request)
{
    $this->authorizeSuperadmin();

    $query = Unit::query();

    // 🔍 BUSCADOR

    if ($request->search) {

        $query->where('name', 'like', '%' . $request->search . '%');

    }

    $units = $query
        ->orderBy('name')
        ->get();

    return view('admin.units.index', compact('units'));
}

    public function create()
    {
        $this->authorizeSuperadmin();

        return view('admin.units.create');
    }

    public function store(Request $request)
    {
        $this->authorizeSuperadmin();

        $data = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Unit::create($data);

        return redirect()->route('admin.units.index')
            ->with('success', 'Unidad creada correctamente.');
    }

    public function edit(Unit $unit)
    {
        $this->authorizeSuperadmin();

        return view('admin.units.edit', compact('unit'));
    }

    public function update(Request $request, Unit $unit)
    {
        $this->authorizeSuperadmin();

        $data = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $unit->update($data);

        return redirect()->route('admin.units.index')
            ->with('success', 'Unidad actualizada.');
    }

    public function destroy(Unit $unit)
    {
        $this->authorizeSuperadmin();

        $unit->delete();

        return redirect()->route('admin.units.index')
            ->with('success', 'Unidad eliminada.');
    }
}