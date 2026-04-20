<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    private function authorizeSuperadmin()
    {
        if (Auth::user()->role !== 'superadmin') {
            abort(403);
        }
    }

    public function index(Request $request)
    {
        $this->authorizeSuperadmin();

        $query = ActivityLog::with('user')->latest();

        // 🔍 Filtro por módulo
        if ($request->module) {
            $query->where('module', $request->module);
        }

        // 🔍 Buscador por usuario
        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $logs = $query->paginate(10);

        return view('admin.activity_logs.index', compact('logs'));
    }
}
