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
    // 🔹 index para el panel administrativo (tabla de noticias)
public function index(Request $request)
{
    $query = News::query();

    // 🔍 BUSCADOR

    if ($request->search) {

        $query->where(function ($q) use ($request) {

            $q->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
        });

    }

    $news = $query
        ->latest()
        ->paginate(10)
        ->withQueryString();

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
            'images.*'    => 'nullable|image|max:1500', // Limitado a 1.5MB para proteger el almacenamiento
            'status'      => 'required|in:draft,published,scheduled',

            'main_image_index' => 'nullable|integer',
        ]);

        if ($request->file('images') && count($request->file('images')) > 10) {
            return back()->withErrors(['images' => 'Máximo 10 fotos.'])->withInput();
        }

        // Generación del Slug único
        $slugBase = Str::slug($data['title']);
        $slug     = $slugBase;
        $counter  = 1;

        while (News::where('slug', $slug)->exists()) {
            $slug = $slugBase . '-' . $counter;
            $counter++;
        }

        // Crear la noticia
        $news = News::create([
            'title'        => $data['title'],
            'slug'         => $slug,
            'description'  => $data['description'],
            'body'         => $data['body'] ?? null,
            'status'       => $data['status'],
            'is_published' => $data['status'] === 'published',
            'published_at' => $data['status'] === 'published' ? now() : null,
            'user_id'      => Auth::id(),
        ]);

        if (function_exists('logActivity')) {
            logActivity('create', 'news', 'Creó noticia: ' . $news->title);
        }

        // 📁 Almacenamiento nativo de imágenes
        if ($request->hasFile('images')) {
           foreach ($request->file('images') as $index => $image) {

    $path = $image->store('news', 'public');

    $isMain =
        $index ==
        $request->main_image_index;

    $news->images()->create([

        'path'    => $path,

        'is_main' => $isMain,

    ]);

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
            'images.*'    => 'nullable|image|max:1500',
            'status'      => 'required|in:draft,published,scheduled',

            'main_image_index' => 'nullable|integer',
        ]);

        if ($request->file('images') && count($request->file('images')) > 10) {
            return back()->withErrors(['images' => 'Máximo 10 fotos.'])->withInput();
        }

        $news->update([
            'title'        => $data['title'],
            'description'  => $data['description'],
            'body'         => $data['body'] ?? null,
            'status'       => $data['status'],
            'is_published' => $data['status'] === 'published',
            'published_at' => $data['status'] === 'published' ? ($news->published_at ?? now()) : null,
        ]);

        if (function_exists('logActivity')) {
            logActivity('update', 'news', 'Actualizó noticia: ' . $news->title);
        }

        // Actualización de imágenes
        if ($request->hasFile('images')) {
            // Eliminar las imágenes anteriores tanto del disco como de la BD
            foreach ($news->images as $img) {
                Storage::disk('public')->delete($img->path);
                $img->delete();
            }

           foreach ($request->file('images') as $index => $image) {

    $path = $image->store('news', 'public');

    $isMain =
        $index ==
        $request->main_image_index;

    $news->images()->create([

        'path'    => $path,

        'is_main' => $isMain,

    ]);

}
        }

        return redirect()->route('admin.news.index')
            ->with('success', 'Noticia actualizada correctamente.');
    }

    public function destroy(News $news)
    {
        $title = $news->title;

        // Eliminar archivos físicos del storage
        foreach ($news->images as $img) {
            Storage::disk('public')->delete($img->path);
        }

        $news->delete();

        if (function_exists('logActivity')) {
            logActivity('delete', 'news', 'Eliminó noticia: ' . $title);
        }

        return redirect()->route('admin.news.index')
            ->with('success', 'Noticia eliminada correctamente.');
    }
}