@extends('layouts.admin')

@section('content')
    <h2 class="mb-4">Resumen general</h2>

 {{-- TARJETAS SUPERIORES --}}
<div class="row g-4 mb-4">

    {{-- USUARIOS --}}
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

    {{-- NOTICIAS --}}
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

    {{-- MENSAJES --}}
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

    {{-- VISITAS --}}
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


    {{-- GRAFICO + CALENDARIO --}}
<div class="row g-4 align-items-stretch">

    {{-- GRAFICO --}}
    <div class="col-lg-8">

        <div class="chart-container">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h5 class="mb-0">
                    Estadísticas de Visitas
                </h5>

                <span class="text-muted small">
                    Últimos 7 días
                </span>

            </div>

            <canvas id="visitsChart"></canvas>

        </div>

    </div>

    {{-- CALENDARIO --}}
    <div class="col-lg-4">

        <div class="calendar-card">

            <div class="calendar-header">

                <h5>Calendario</h5>

                <span class="text-muted">
                    {{ now()->format('F Y') }}
                </span>

            </div>

            <div id="dashboardCalendar"></div>

        </div>

    </div>

</div>
@endsection


@push('scripts')
{{-- Chart.js para las estadísticas --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // ======================
    // GRAFICO DE VISITAS
    // ======================

   const ctx = document.getElementById('visitsChart').getContext('2d');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($visitsLabels) !!},
        datasets: [{
            label: 'Visitas',
            data: {!! json_encode($visitsData) !!},
            borderWidth: 3,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
    }
});


// ======================
    // EVENTOS DESDE BACKEND
    // ======================
    const calendarEvents = @json($calendarEvents);

    const eventsByDate = calendarEvents.reduce((acc, e) => {
        const date = e.date; // "YYYY-MM-DD"
        if (!acc[date]) acc[date] = [];
        acc[date].push(e.title);
        return acc;
    }, {});

    // ======================
    // CALENDARIO CON EVENTOS
    // ======================
    function renderCalendar() {
        const container = document.getElementById("dashboardCalendar");
        const now = new Date();
        const year = now.getFullYear();
        const month = now.getMonth(); // mes actual

        const monthNames = [
            "Enero","Febrero","Marzo","Abril","Mayo","Junio",
            "Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"
        ];

        let firstDay = new Date(year, month, 1).getDay();
        if (firstDay === 0) firstDay = 7; // ajustar para que lunes sea el inicio

        const daysInMonth = new Date(year, month + 1, 0).getDate();

        let html = `
            <div class="text-center mb-2 fw-bold">
                ${monthNames[month]} ${year}
            </div>

            <div class="calendar-grid">
                <div class="calendar-day-name">Lun</div><div>Mar</div><div>Mié</div>
                <div>Jue</div><div>Vie</div><div>Sáb</div><div>Dom</div>
        `;

        // huecos antes del primer día
        for (let i = 1; i < firstDay; i++) {
            html += `<div></div>`;
        }

        // días del mes
        for (let d = 1; d <= daysInMonth; d++) {
            const today = now.getDate();
const isToday = d === today;
            const dayStr = String(d).padStart(2, "0");
            const monthStr = String(month + 1).padStart(2, "0");
            const dateKey = `${year}-${monthStr}-${dayStr}`;

            const events = eventsByDate[dateKey] || [];

            if (events.length) {
                const titlesHtml = events
                    .map(t => `<div class="event-title">• ${t}</div>`)
                    .join("");

                html += `
                    <div class="calendar-day active">
                        <div class="day-number">${d}</div>
                        <div class="events-list">
                            ${titlesHtml}
                        </div>
                    </div>
                `;
            } else {
                html += `
                    <div class="calendar-day ${isToday ? 'active' : ''}">
                        <div class="day-number">${d}</div>
                    </div>
                `;
            }
        }

        html += `</div>`;
        container.innerHTML = html;
    }

    renderCalendar();

</script>
@endpush
