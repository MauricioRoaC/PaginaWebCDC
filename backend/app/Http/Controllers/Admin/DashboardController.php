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
        $totalNews     = News::where('is_published', true)->count();
        $activeUsers = User::where('is_active', true)->count();
        $inactiveUsers = $totalUsers - $activeUsers;
        $draftNews = News::where('status', 'draft')->count();
        $scheduledNews = News::where('status', 'scheduled')->count();
        $todayVisits = Visit::where('created_at', '>=', now()->startOfDay())->where('created_at', '<', now()->addDay()->startOfDay())->count();
        $nextScheduledNews = News::where('status', 'scheduled')->whereNotNull('published_at')->orderBy('published_at')->take(5)->get(['id', 'title', 'published_at']);
        $totalMessages = Message::count();
        $totalVisits   = Visit::count();

        // =====================
        // CONTENIDO PUBLICADO
        // =====================

        $totalEvents    = Event::where('is_public', true)->count();
        $totalDocuments = Document::where('is_public', true)->count();
        $totalContacts  = Contact::where('is_visible', true)->count();

        // =====================
        // VISITAS ÚLTIMOS 7 DÍAS
        // =====================

        $visitsLabels = [];
        $visitsData   = [];

        $today = now()->startOfDay();
        $dailyVisits = Visit::where('created_at', '>=', $today->copy()->subDays(6))
            ->where('created_at', '<', $today->copy()->addDay())
            ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
            ->groupByRaw('DATE(created_at)')
            ->pluck('total', 'day');

        for ($i = 6; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i);
            $visitsLabels[] = $date->locale('es')->translatedFormat('D d/m');
            $visitsData[] = (int) ($dailyVisits[$date->toDateString()] ?? 0);
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

        $topNews = News::where('is_published', true)->where('views', '>', 0)->orderByDesc('views')
            ->take(5)
            ->get([
                'id',
                'title',
                'views',
                'slug'
            ]);

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
            'activeUsers', 'inactiveUsers', 'draftNews', 'scheduledNews', 'todayVisits', 'nextScheduledNews'

        ));
    }
}
