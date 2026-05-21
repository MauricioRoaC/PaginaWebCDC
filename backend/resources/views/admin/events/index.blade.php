@extends('layouts.admin')

@section('content')

<div class="events-page">

    <!-- HEADER -->

    <div class="events-header">

        <div>

            <h1 class="events-title">
                Calendario operativo
            </h1>

            <p class="events-subtitle">
                Gestiona actividades, operativos y eventos institucionales.
            </p>

        </div>

        <a href="{{ route('admin.events.create') }}"
           class="new-event-btn">

            <i class='bx bx-plus'></i>

            Nuevo evento

        </a>

    </div>

    <!-- ALERT -->

    @if(session('success'))

        <div class="events-success">

            <i class='bx bx-check-circle'></i>

            {{ session('success') }}

        </div>

    @endif

    <!-- STATS -->

    <div class="events-stats">

        <!-- TOTAL -->

        <div class="event-stat-card">

            <div class="event-stat-icon blue">

                <i class='bx bx-calendar'></i>

            </div>

            <div>

                <span>Total eventos</span>

                <h3>
                    {{ $events->total() }}
                </h3>

            </div>

        </div>

        <!-- PUBLIC -->

        <div class="event-stat-card">

            <div class="event-stat-icon green">

                <i class='bx bx-world'></i>

            </div>

            <div>

                <span>Públicos</span>

                <h3>

                    {{ $events->where('is_public', true)->count() }}

                </h3>

            </div>

        </div>

        <!-- UPCOMING -->

        <div class="event-stat-card">

            <div class="event-stat-icon orange">

                <i class='bx bx-time-five'></i>

            </div>

            <div>

                <span>Próximos</span>

                <h3>

                    {{ $events->where('start_at', '>=', now())->count() }}

                </h3>

            </div>

        </div>

    </div>

    <!-- SEARCH -->

    <div class="events-search">

        <i class='bx bx-search'></i>

        <input type="text"
               id="eventSearch"
               placeholder="Buscar evento...">

    </div>

    <!-- CONTENT -->

    @if($events->count())

        <div class="events-grid"
             id="eventsGrid">

            @foreach($events as $event)

                <div class="event-card"

                     data-search="
                        {{ strtolower($event->title) }}
                        {{ strtolower($event->location ?? '') }}
                     ">

                    <!-- TOP -->

                    <div class="event-card-top">

                        <!-- DATE -->

                        <div class="event-date-box">

                            <span class="event-day">

                                {{ $event->start_at->format('d') }}

                            </span>

                            <span class="event-month">

                                {{ $event->start_at->translatedFormat('M') }}

                            </span>

                        </div>

                        <!-- STATUS -->

                        @if($event->is_public)

                            <div class="event-badge public-badge">

                                <i class='bx bx-world'></i>

                                Público

                            </div>

                        @else

                            <div class="event-badge private-badge">

                                <i class='bx bx-lock-alt'></i>

                                Interno

                            </div>

                        @endif

                    </div>

                    <!-- TITLE -->

                    <h3 class="event-title">

                        {{ $event->title }}

                    </h3>

                    <!-- DESCRIPTION -->

                    <p class="event-description">

                        {{ $event->description
                            ? Str::limit($event->description, 120)
                            : 'Sin descripción registrada.' }}

                    </p>

                    <!-- INFO -->

                    <div class="event-info">

                        <!-- START -->

                        <div class="event-info-item">

                            <i class='bx bx-time'></i>

                            <span>

                                {{ $event->start_at->format('d/m/Y H:i') }}

                            </span>

                        </div>

                        <!-- END -->

                        <div class="event-info-item">

                            <i class='bx bx-calendar-check'></i>

                            <span>

                                {{ $event->end_at
                                    ? $event->end_at->format('d/m/Y H:i')
                                    : 'Sin fecha final' }}

                            </span>

                        </div>

                        <!-- LOCATION -->

                        <div class="event-info-item">

                            <i class='bx bx-map'></i>

                            <span>

                                {{ $event->location ?? 'Sin ubicación' }}

                            </span>

                        </div>

                    </div>

                    <!-- FOOTER -->

                    <div class="event-footer">

                        @if($event->all_day)

                            <div class="all-day-badge">

                                <i class='bx bx-sun'></i>

                                Todo el día

                            </div>

                        @else

                            <div class="all-day-badge inactive">

                                Evento programado

                            </div>

                        @endif

                        <!-- ACTIONS -->

                        <div class="event-actions">

                            <!-- EDIT -->

                            <a href="{{ route('admin.events.edit', $event) }}"
                               class="event-btn edit-btn">

                                <i class='bx bx-edit-alt'></i>

                            </a>

                            <!-- DELETE -->

                            <form action="{{ route('admin.events.destroy', $event) }}"
                                  method="POST"

                                  onsubmit="return confirm('¿Eliminar este evento?')">

                                @csrf
                                @method('DELETE')

                                <button class="event-btn delete-btn">

                                    <i class='bx bx-trash'></i>

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        <!-- PAGINATION -->

        <div class="events-pagination">

            {{ $events->links() }}

        </div>

    @else

        <!-- EMPTY -->

        <div class="events-empty">

            <div class="events-empty-icon">

                <i class='bx bx-calendar-x'></i>

            </div>

            <h3>
                No hay eventos registrados
            </h3>

            <p>
                Los eventos operativos e institucionales
                aparecerán aquí automáticamente.
            </p>

        </div>

    @endif

</div>

@endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', () => {

    const search =
        document.getElementById('eventSearch');

    const cards =
        document.querySelectorAll('.event-card');

    search.addEventListener('input', function(){

        const value =
            this.value.toLowerCase();

        cards.forEach(card => {

            const content =
                card.dataset.search;

            if(content.includes(value)){

                card.style.display = 'flex';

            }else{

                card.style.display = 'none';

            }

        });

    });

});

</script>

@endpush