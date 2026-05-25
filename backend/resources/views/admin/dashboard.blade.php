@extends('layouts.admin')
    @section('content')

<h2 class="dashboard-title mb-4">
    Resumen General
</h2>

<!-- =========================
     KPI SUPERIORES
========================= -->

<div class="row g-4 mb-4">

    <div class="col-md-6 col-xl-3">

        <div class="card dashboard-card h-100">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>

                    <h6 class="card-title">
                        Usuarios en el panel
                    </h6>

                    <p class="card-value mb-0">
                        {{ $totalUsers }}
                    </p>

                </div>

                <div class="dashboard-icon">
                    <i class='bx bx-user'></i>
                </div>

            </div>

        </div>

    </div>

    <div class="col-md-6 col-xl-3">

        <div class="card dashboard-card h-100">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>

                    <h6 class="card-title">
                        Noticias publicadas
                    </h6>

                    <p class="card-value mb-0">
                        {{ $totalNews }}
                    </p>

                </div>

                <div class="dashboard-icon">
                    <i class='bx bx-news'></i>
                </div>

            </div>

        </div>

    </div>

    <div class="col-md-6 col-xl-3">

        <div class="card dashboard-card h-100">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>

                    <h6 class="card-title">
                        Mensajes recibidos
                    </h6>

                    <p class="card-value mb-0">
                        {{ $totalMessages }}
                    </p>

                </div>

                <div class="dashboard-icon">
                    <i class='bx bx-envelope'></i>
                </div>

            </div>

        </div>

    </div>

    <div class="col-md-6 col-xl-3">

        <div class="card dashboard-card h-100">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>

                    <h6 class="card-title">
                        Visitas al sitio
                    </h6>

                    <p class="card-value mb-0">
                        {{ $totalVisits }}
                    </p>

                </div>

                <div class="dashboard-icon">
                    <i class='bx bx-show'></i>
                </div>

            </div>

        </div>

    </div>

</div>

<!-- =========================
     VISITAS + CONTENIDO
========================= -->

<div class="row g-4 mb-4">

    <div class="col-xl-8">

        <div class="dashboard-widget">

            <div class="widget-header">

                <div>

                    <h5>
                        Estadísticas de Visitas
                    </h5>

                    <span>
                        Últimos 7 días
                    </span>

                </div>

            </div>

            <div class="widget-chart">

                <canvas id="visitsChart"></canvas>

            </div>

        </div>

    </div>

    <div class="col-xl-4">

        <div class="dashboard-widget">

            <div class="widget-header">

                <div>

                    <h5>
                        Contenido publicado
                    </h5>

                    <span>
                        Distribución actual
                    </span>

                </div>

            </div>

            <div class="widget-chart">

                <canvas id="contentChart"></canvas>

            </div>

            <div class="content-legend">

                <div>
                    <span class="legend-dot news"></span>
                    Noticias
                    <strong>{{ $totalNews }}</strong>
                </div>

                <div>
                    <span class="legend-dot events"></span>
                    Eventos
                    <strong>{{ $totalEvents }}</strong>
                </div>

                <div>
                    <span class="legend-dot documents"></span>
                    Documentos
                    <strong>{{ $totalDocuments }}</strong>
                </div>

                <div>
                    <span class="legend-dot contacts"></span>
                    Contactos
                    <strong>{{ $totalContacts }}</strong>
                </div>

            </div>

        </div>

    </div>

</div>
<!-- =========================
     ACTIVIDAD + EVENTOS
========================= -->

<div class="row g-4 mb-4">

    <!-- ACTIVIDAD -->

    <div class="col-xl-6">

        <div class="dashboard-widget">

            <div class="widget-header">

                <div>

                    <h5>
                        Actividad reciente
                    </h5>

                    <span>
                        Últimos movimientos del sistema
                    </span>

                </div>

            </div>

            <div class="activity-list">

                @forelse($recentActivities as $activity)

                    <div class="activity-item">

                        <div class="activity-dot"></div>

                        <div class="activity-content">

                            <strong>
                                {{ $activity->user->name ?? 'Sistema' }}
                            </strong>

                            <p>
                                {{ $activity->description }}
                            </p>

                            <small>
                                {{ $activity->created_at->diffForHumans() }}
                            </small>

                        </div>

                    </div>

                @empty

                    <div class="empty-widget">

                        No hay actividad registrada.

                    </div>

                @endforelse

            </div>

        </div>

    </div>

    <!-- EVENTOS -->

    <div class="col-xl-6">

        <div class="dashboard-widget">

            <div class="widget-header">

                <div>

                    <h5>
                        Próximos eventos
                    </h5>

                    <span>
                        Agenda institucional
                    </span>

                </div>

            </div>

            <div class="events-list">

                @forelse($upcomingEvents as $event)

                    <div class="event-item">

                        <div class="event-date">

                            <strong>
                                {{ \Carbon\Carbon::parse($event->start_at)->format('d') }}
                            </strong>

                            <span>
                                {{ \Carbon\Carbon::parse($event->start_at)->translatedFormat('M') }}
                            </span>

                        </div>

                        <div class="event-info">

                            <h6>
                                {{ $event->title }}
                            </h6>

                            <small>

                                {{ \Carbon\Carbon::parse($event->start_at)->format('d/m/Y H:i') }}

                            </small>

                        </div>

                    </div>

                @empty

                    <div class="empty-widget">

                        No hay eventos próximos.

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>

<!-- =========================
     TOP NOTICIAS
========================= -->

<div class="dashboard-widget dashboard-top-news mb-4">

    <div class="widget-header">

        <div>

            <h5>
                Noticias más vistas
            </h5>

            <span>
                Contenido con mayor alcance
            </span>

        </div>

    </div>

    <div class="top-news-list">

        @forelse($topNews as $news)

            <div class="top-news-item">

                <div class="top-news-rank">

                    #{{ $loop->iteration }}

                </div>

                <div class="top-news-content">

                    <h6>

                        {{ $news->title }}

                    </h6>

                    <small>

                        {{ number_format($news->views) }}
                        visualizaciones

                    </small>

                </div>

            </div>

        @empty

            <div class="empty-widget">

                No existen estadísticas de noticias todavía.

            </div>

        @endforelse

    </div>

</div>
@endsection


@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    // =========================
    // VISITAS
    // =========================

    const visitsCtx =
        document.getElementById('visitsChart');

    if (visitsCtx) {

        new Chart(visitsCtx, {

            type: 'line',

            data: {

                labels: {!! json_encode($visitsLabels) !!},

                datasets: [{

                    label: 'Visitas',

                    data: {!! json_encode($visitsData) !!},

                    borderColor: '#637227',

                    backgroundColor: 'rgba(99,114,39,.12)',

                    fill: true,

                    tension: .4,

                    borderWidth: 3,

                    pointRadius: 4,

                    pointHoverRadius: 7

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {
                        display: false
                    }

                },

                scales: {

                    y: {

                        beginAtZero: true,

                        grid: {
                            color: 'rgba(148,163,184,.12)'
                        }

                    },

                    x: {

                        grid: {
                            display: false
                        }

                    }

                }

            }

        });

    }

    // =========================
    // CONTENIDO PUBLICADO
    // =========================

    const contentCtx =
        document.getElementById('contentChart');

    if (contentCtx) {

        new Chart(contentCtx, {

            type: 'doughnut',

            data: {

                labels: [

                    'Noticias',
                    'Eventos',
                    'Documentos',
                    'Contactos'

                ],

                datasets: [{

                    data: [

                        {{ $totalNews }},
                        {{ $totalEvents }},
                        {{ $totalDocuments }},
                        {{ $totalContacts }}

                    ],

                    backgroundColor: [

                        '#637227',
                        '#4f5c1f',
                        '#899a46',
                        '#c5d18d'

                    ],

                    borderWidth: 0

                }]

            },

            options: {

                cutout: '72%',

                plugins: {

                    legend: {
                        display: false
                    }

                }

            }

        });

    }

</script>

@endpush
