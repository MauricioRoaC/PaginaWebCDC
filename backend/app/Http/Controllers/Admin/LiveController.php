<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Live;
use Illuminate\Http\Request;

class LiveController extends Controller
{
    public function store(Request $request)
{
    $data = $request->validate([
        'title' => 'required|string|max:255',
        'embed_url' => 'required|string',
    ]);

    $content = trim($data['embed_url']);

    // 🔍 Detectar tipo automáticamente
    if (str_starts_with($content, '<iframe')) {
        $type = 'iframe'; // Facebook u otros embebidos
    } elseif (str_contains($content, 'tiktok.com')) {
        $type = 'tiktok';
    } else {
        $type = 'link';
    }

    //  Solo 1 live activo 
    Live::where('is_active', true)->update(['is_active' => false]);

    $live = Live::create([
        'title' => $data['title'],
        'embed_url' => $content,
        'is_active' => true,
    ]);

    // log
    logActivity('create', 'lives', 'Agregó live: ' . $live->title);

    return back()->with('success', 'Live creado correctamente');
}
public function index()
{
    $lives = \App\Models\Live::latest()->get();
    return view('admin.lives.index', compact('lives'));
}
public function toggle(Live $live)
{
    $live->is_active = !$live->is_active;
    $live->save();

    logActivity('update', 'lives', 'Cambió estado del live: ' . $live->title);

    return back()->with('success', 'Estado del live actualizado');
}
public function destroy(Live $live)
{
    logActivity('delete', 'lives', 'Eliminó live: ' . $live->title);

    $live->delete();

    return back()->with('success', 'Live eliminado');
}
}