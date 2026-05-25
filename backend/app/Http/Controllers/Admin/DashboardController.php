<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\News;
use App\Models\Message;
use App\Models\Visit;
use App\Models\Event;
use App\Models\Document;
use App\Models\Contact;
use App\Models\ActivityLog;
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
        // CONTENIDO PUBLICADO
        // =====================

        $totalEvents    = Event::count();
        $totalDocuments = Document::count();
        $totalContacts  = Contact::count();

        // =====================
        // VISITAS ÚLTIMOS 7 DÍAS
        // =====================

        $visitsLabels = [];
        $visitsData   = [];

        for ($i = 6; $i >= 0; $i--) {

            $date = now()->subDays($i);

            $visitsLabels[] = $date->translatedFormat('D');

            $visitsData[] = Visit::whereDate(
                'created_at',
                $date->toDateString()
            )->count();
        }
        // =====================
        // ACTIVIDAD RECIENTE
        // =====================

        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(8)
            ->get();
        // =====================
        // PRÓXIMOS EVENTOS
        // =====================

        $upcomingEvents = Event::where(
            'start_at',
            '>=',
            now()
        )
            ->orderBy('start_at')
            ->take(5)
            ->get();
        // =====================
        // NOTICIAS MÁS VISTAS
        // =====================

        $topNews = News::orderByDesc('views')
            ->take(5)
            ->get([
                'id',
                'title',
                'views',
                'slug'
            ]);

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

            'totalEvents',
            'totalDocuments',
            'totalContacts',

            'visitsLabels',
            'visitsData',

            'recentActivities',
            'upcomingEvents',
            'topNews',
            'calendarEvents'

        ));
    }
}
