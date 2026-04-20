<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.documents.index', compact('documents'));
    }

    public function create()
    {
        return view('admin.documents.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'number'      => 'nullable|string|max:100',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'required|in:rendicion,poa,pei',
            'file_url'    => 'required|url',
            'is_public'   => 'nullable|boolean',
        ]);

        $data['is_public'] = $request->boolean('is_public', true);
        $data['created_by'] = auth()->id();

        Document::create($data);

        return redirect()
            ->route('admin.documents.index')
            ->with('success', 'Documento publicado correctamente.');
    }

    public function edit(Document $document)
    {
        return view('admin.documents.edit', compact('document'));
    }

    public function update(Request $request, Document $document)
    {
        $data = $request->validate([
            'number'      => 'nullable|string|max:100',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'required|in:rendicion,poa,pei',
            'file_url'    => 'required|url',
            'is_public'   => 'nullable|boolean',
        ]);

        $data['is_public'] = $request->boolean('is_public', true);

        $document->update($data);

        return redirect()
            ->route('admin.documents.index')
            ->with('success', 'Documento actualizado correctamente.');
    }

    public function destroy(Document $document)
    {
        $document->delete();

        return redirect()
            ->route('admin.documents.index')
            ->with('success', 'Documento eliminado correctamente.');
    }
}

