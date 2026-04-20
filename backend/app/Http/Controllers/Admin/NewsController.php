<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    // 🔹 ESTE index es SOLO para el PANEL (vista Blade)
    public function index()
    {
        // aquí no queremos mainImage ni JSON, solo listar para la tabla
        $news = News::latest()->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'body'        => 'nullable|string',
            'images.*'    => 'nullable|image|max:2048', // 2MB por imagen
        ]);

        if ($request->file('images') && count($request->file('images')) > 10) {
            return back()->withErrors(['images' => 'Máximo 10 fotos.'])->withInput();
        }

        $slugBase = Str::slug($data['title']);
        $slug     = $slugBase;
        $counter  = 1;

        while (News::where('slug', $slug)->exists()) {
            $slug = $slugBase . '-' . $counter;
            $counter++;
        }

        $news = News::create([
            'title'        => $data['title'],
            'slug'         => $slug,
            'description'  => $data['description'],
            'body'         => $data['body'] ?? null,
            'is_published' => true,
            'published_at' => now(),
            'user_id'      => Auth::id(),
        ]);

        logActivity('create', 'news', 'Creó noticia: ' . $news->title);

        if ($request->hasFile('images')) {
            $isFirst = true;
            foreach ($request->file('images') as $image) {
                $path = $image->store('news', 'public');

                $news->images()->create([
                    'path'    => $path,
                    'is_main' => $isFirst, // la primera será principal
                ]);

                $isFirst = false;
            }
        }
        
        

        return redirect()->route('admin.news.index')
            ->with('success', 'Noticia creada correctamente.');
    }

    public function edit(News $news)
    {
        $news->load('images');
        return view('admin.news.edit', compact('news'));
    }

   public function update(Request $request, News $news)
{
    $data = $request->validate([
        'title'       => 'required|string|max:255',
        'description' => 'required|string|max:500',
        'body'        => 'nullable|string',
        'images.*'    => 'nullable|image|max:2048',
    ]);

    if ($request->file('images') && count($request->file('images')) > 10) {
        return back()->withErrors(['images' => 'Máximo 10 fotos.'])->withInput();
    }

    // actualizar datos básicos
    $news->update([
        'title'       => $data['title'],
        'description' => $data['description'],
        'body'        => $data['body'] ?? null,
    ]);

    // 🔥 LOG DESPUÉS DEL UPDATE (correcto)
    logActivity('update', 'news', 'Actualizó noticia: ' . $news->title);

    // manejo de imágenes
    if ($request->hasFile('images')) {
        foreach ($news->images as $img) {
            Storage::disk('public')->delete($img->path);
            $img->delete();
        }

        $isFirst = true;
        foreach ($request->file('images') as $image) {
            $path = $image->store('news', 'public');

            $news->images()->create([
                'path'    => $path,
                'is_main' => $isFirst,
            ]);

            $isFirst = false;
        }
    }

    return redirect()->route('admin.news.index')
        ->with('success', 'Noticia actualizada correctamente.');
}

    public function destroy(News $news)
{
    // 🔥 guardar antes de borrar
    $title = $news->title;

    foreach ($news->images as $img) {
        Storage::disk('public')->delete($img->path);
    }

    $news->delete();

    // 🔥 log correcto
    logActivity('delete', 'news', 'Eliminó noticia: ' . $title);

    return redirect()->route('admin.news.index')
        ->with('success', 'Noticia eliminada correctamente.');
}
}



