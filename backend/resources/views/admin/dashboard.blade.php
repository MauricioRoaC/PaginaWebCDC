@extends('layouts.admin')

@section('content')
    <h2 class="mb-4">Resumen general</h2>

    {{-- TARJETAS SUPERIORES --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card dashboard-card">
                <div class="card-body">
                    <h6 class="card-title mb-2">Usuarios en el panel</h6>
                    <p class="card-value mb-0">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card dashboard-card">
                <div class="card-body">
                    <h6 class="card-title mb-2">Noticias publicadas</h6>
                    <p class="card-value mb-0">{{ $totalNews }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card dashboard-card">
                <div class="card-body">
                    <h6 class="card-title mb-2">Mensajes recibidos</h6>
                    <p class="card-value mb-0">{{ $totalMessages }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card dashboard-card">
                <div class="card-body">
                    <h6 class="card-title mb-2">Visitas al sitio</h6>
                    <p class="card-value mb-0">{{ $totalVisits }}</p>
                </div>
            </div>
        </div>
    </div>


    {{-- GRAFICO DE VISITAS + CALENDARIO --}}
    <div class="row g-4">

        {{-- GRAFICO DE VISITAS --}}
       <div class="col-lg-8">
    <div class="card shadow-sm p-3">
        <h5 class="mb-3">Estadísticas de Visitas</h5>

        <div class="chart-container">
            <canvas id="visitsChart"></canvas>
        </div>
    </div>
</div>


        {{-- CALENDARIO --}}
        <div class="col-lg-4">
            <div class="card shadow-sm p-3">
                <h5 class="mb-3">Calendario</h5>
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
                <div>Lun</div><div>Mar</div><div>Mié</div>
                <div>Jue</div><div>Vie</div><div>Sáb</div><div>Dom</div>
        `;

        // huecos antes del primer día
        for (let i = 1; i < firstDay; i++) {
            html += `<div></div>`;
        }

        // días del mes
        for (let d = 1; d <= daysInMonth; d++) {
            const dayStr = String(d).padStart(2, "0");
            const monthStr = String(month + 1).padStart(2, "0");
            const dateKey = `${year}-${monthStr}-${dayStr}`;

            const events = eventsByDate[dateKey] || [];

            if (events.length) {
                const titlesHtml = events
                    .map(t => `<div class="event-title">• ${t}</div>`)
                    .join("");

                html += `
                    <div class="day has-event">
                        <div class="day-number">${d}</div>
                        <div class="events-list">
                            ${titlesHtml}
                        </div>
                    </div>
                `;
            } else {
                html += `
                    <div class="day">
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
