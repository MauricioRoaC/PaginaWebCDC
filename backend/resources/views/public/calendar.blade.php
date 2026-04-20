@extends('layouts.app') {{-- o el layout público que uses --}}

@section('content')
    <h2 class="mb-4">Calendario de actividades</h2>
    <div id="calendar"></div>

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                events: '{{ url('/api/events') }}',
                eventClick: function(info) {
                    // solo mostrar detalle, nada de editar
                    alert(info.event.title + (info.event.extendedProps.location
                        ? '\n\n' + info.event.extendedProps.location
                        : ''));
                }
            });
            calendar.render();
        });
    </script>
@endsection
