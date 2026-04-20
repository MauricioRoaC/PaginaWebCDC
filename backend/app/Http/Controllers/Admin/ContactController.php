<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\ContactCategory;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::with('category')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.contacts.index', compact('contacts'));
    }

    public function create()
    {
        $categories = ContactCategory::orderBy('name')->get();

        return view('admin.contacts.create', [
            'contact' => new Contact(),
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('contacts', 'public');
        }

        $data['is_visible'] = $request->boolean('is_visible');

        Contact::create($data);

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contacto creado correctamente.');
    }

    public function edit(Contact $contact)
    {
        $categories = ContactCategory::orderBy('name')->get();

        return view('admin.contacts.edit', compact('contact', 'categories'));
    }

    public function update(Request $request, Contact $contact)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('contacts', 'public');
        }

        $data['is_visible'] = $request->boolean('is_visible');

        $contact->update($data);

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contacto actualizado correctamente.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contacto eliminado.');
    }

    public function toggleVisible(Contact $contact)
    {
        $contact->is_visible = ! $contact->is_visible;
        $contact->save();

        return back()->with('success', 'Visibilidad actualizada.');
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'contact_category_id' => 'nullable|exists:contact_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'nullable|string|max:255',
            'map_url' => 'nullable|string|max:2048',
            'lat' => 'nullable|numeric|between:-90,90',
            'lng' => 'nullable|numeric|between:-180,180',
            'is_visible' => 'nullable|boolean',
            'logo' => 'image|mimes:jpg,jpeg,png|max:5120',
        ]);
    }
}
