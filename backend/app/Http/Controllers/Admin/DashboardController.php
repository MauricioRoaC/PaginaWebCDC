<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\News;
use App\Models\Message;
use App\Models\Visit;
use App\Models\Event;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // =====================
        // CONTADORES
        // =====================
        $totalUsers    = User::count();
        $totalNews     = News::count();
        $totalMessages = Message::count();
        $totalVisits   = Visit::count();

        // =====================
        // VISITAS (Ejemplo base)
        // =====================
        $visitsLabels = ['Lun','Mar','Mié','Jue','Vie','Sáb','Dom'];
        $visitsData   = [12, 35, 22, 18, 40, 50, 44];  // Luego lo puedes reemplazar por datos reales

        // =====================
        // EVENTOS DEL CALENDARIO
        // =====================
        // Usamos start_at como fecha del evento
        $events = Event::orderBy('start_at', 'asc')
            // ->where('is_public', true) // si quieres solo los públicos, descomenta esta línea
            ->get(['title', 'start_at']);

        // Adaptamos para el JS del calendario
        $calendarEvents = $events->map(function ($ev) {
            return [
                'date'  => Carbon::parse($ev->start_at)->toDateString(), // "YYYY-MM-DD"
                'title' => $ev->title,
            ];
        });

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalNews',
            'totalMessages',
            'totalVisits',
            'visitsLabels',
            'visitsData',
            'calendarEvents'  // ← importante
        ));
    }
}
