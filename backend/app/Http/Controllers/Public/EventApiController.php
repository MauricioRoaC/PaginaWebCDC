<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::where('is_public', true);

        // Opcional: filtro por rango de fechas ?from=2025-12-01&to=2025-12-31
        if ($request->has('from')) {
            $query->where('start_at', '>=', $request->query('from'));
        }
        if ($request->has('to')) {
            $query->where('start_at', '<=', $request->query('to'));
        }

        $events = $query->orderBy('start_at')->get();

        // Formato compatible con FullCalendar
        return response()->json($events->map(function ($e) {
            return [
                'id'          => $e->id,
                'title'       => $e->title,
                'start'       => $e->start_at->toIso8601String(),
                'end'         => $e->end_at ? $e->end_at->toIso8601String() : null,
                'allDay'      => $e->all_day,
                'description' => $e->description,
                'location'    => $e->location,
            ];
        }));
    }
}

