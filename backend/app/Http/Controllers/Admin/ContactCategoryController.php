<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContactCategoryController extends Controller
{
    public function index()
    {
        $categories = ContactCategory::orderBy('name')->get();

        return view('admin.contact_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.contact_categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $data['slug'] = Str::slug($data['name']);

        ContactCategory::create($data);

        return redirect()->route('admin.contact-categories.index')
            ->with('success', 'Categoría creada correctamente.');
    }

    public function edit(ContactCategory $contactCategory)
    {
        return view('admin.contact_categories.edit', compact('contactCategory'));
    }

    public function update(Request $request, ContactCategory $contactCategory)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $data['slug'] = Str::slug($data['name']);

        $contactCategory->update($data);

        return redirect()->route('admin.contact-categories.index')
            ->with('success', 'Categoría actualizada.');
    }

    public function destroy(ContactCategory $contactCategory)
    {
        $contactCategory->delete();

        return redirect()->route('admin.contact-categories.index')
            ->with('success', 'Categoría eliminada.');
    }
}
