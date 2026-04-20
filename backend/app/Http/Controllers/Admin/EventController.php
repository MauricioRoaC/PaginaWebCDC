<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('start_at', 'desc')->paginate(15);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

   public function store(Request $request)
{
    $data = $this->validateData($request);

    $data['created_by'] = Auth::id();

    // 🔥 guardar en variable
    $event = Event::create($data);

    // 🔥 log correcto
    logActivity('create', 'events', 'Creó evento: ' . $event->title);

    return redirect()
        ->route('admin.events.index')
        ->with('success', 'Evento creado correctamente.');
}

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
{
    $data = $this->validateData($request);

    $event->update($data);

    // 🔥 LOG
    logActivity('update', 'events', 'Actualizó evento: ' . $event->title);

    return redirect()
        ->route('admin.events.index')
        ->with('success', 'Evento actualizado correctamente.');
}

    public function destroy(Event $event)
{
    // guardar antes de eliminar
    $title = $event->title;

    $event->delete();

    // LOG correcto
    logActivity('delete', 'events', 'Eliminó evento: ' . $title);

    return redirect()
        ->route('admin.events.index')
        ->with('success', 'Evento eliminado correctamente.');
}
    private function validateData(Request $request): array
    {
        return $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_at'    => 'required|date',
            'end_at'      => 'nullable|date|after_or_equal:start_at',
            'all_day'     => 'nullable|boolean',
            'location'    => 'nullable|string|max:255',
            'is_public'   => 'nullable|boolean',
        ]);
    }
}

