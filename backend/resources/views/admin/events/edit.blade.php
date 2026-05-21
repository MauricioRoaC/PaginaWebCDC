@extends('layouts.admin')

@section('content')

<div class="event-form-page edit-mode">

    <!-- HEADER -->

    <div class="event-form-header">

        <div>

            <h1>
                Editar evento operativo
            </h1>

            <p>
                Actualiza información, horarios y detalles
                del evento institucional.
            </p>

        </div>

        <a href="{{ route('admin.events.index') }}"
           class="event-back-btn">

            <i class='bx bx-arrow-back'></i>

            Volver

        </a>

    </div>

    <!-- ERRORS -->

    @if($errors->any())

        <div class="event-error-box">

            <div class="event-error-title">

                <i class='bx bx-error-circle'></i>

                Revisa los siguientes campos

            </div>

            <ul>

                @foreach($errors->all() as $e)

                    <li>{{ $e }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <!-- LAYOUT -->

    <form action="{{ route('admin.events.update', $event) }}"
          method="POST"

          class="event-layout">

        @csrf
        @method('PUT')

        <!-- LEFT -->

        <div class="event-main-column">

            <!-- MAIN CARD -->

            <div class="event-card">

                <div class="event-section-title">

                    <i class='bx bx-edit-alt'></i>

                    <span>
                        Información del evento
                    </span>

                </div>

                <!-- TITLE -->

                <div class="event-group">

                    <label>
                        Asunto del evento
                    </label>

                    <input type="text"
                           name="title"

                           id="eventTitle"

                           class="event-input"

                           placeholder="Ej: Operativo nocturno zona norte"

                           value="{{ old('title', $event->title) }}"

                           required>

                </div>

                <!-- TYPE -->

                <div class="event-group">

                    <label>
                        Tipo de evento
                    </label>

                    <select class="event-input">

                        <option>
                            Operativo policial
                        </option>

                        <option>
                            Patrullaje
                        </option>

                        <option>
                            Cierre vial
                        </option>

                        <option>
                            Evento institucional
                        </option>

                        <option>
                            Comunicado
                        </option>

                    </select>

                </div>

                <!-- DESCRIPTION -->

                <div class="event-group">

                    <label>
                        Descripción
                    </label>

                    <textarea name="description"
                              id="eventDescription"

                              class="event-textarea"

                              rows="6"

                              placeholder="Describe el operativo o actividad institucional...">{{ old('description', $event->description) }}</textarea>

                </div>

            </div>

            <!-- DATE CARD -->

            <div class="event-card">

                <div class="event-section-title">

                    <i class='bx bx-time-five'></i>

                    <span>
                        Fecha y horario
                    </span>

                </div>

                <div class="event-date-grid">

                    <!-- START -->

                    <div class="event-group">

                        <label>
                            Inicio
                        </label>

                        <input type="datetime-local"
                               name="start_at"

                               id="eventStart"

                               class="event-input"

                               value="{{ old('start_at', $event->start_at->format('Y-m-d\TH:i')) }}"

                               required>

                    </div>

                    <!-- END -->

                    <div class="event-group"
                         id="endDateGroup">

                        <label>
                            Finalización
                        </label>

                        <input type="datetime-local"
                               name="end_at"

                               id="eventEnd"

                               class="event-input"

                               value="{{ old('end_at', $event->end_at ? $event->end_at->format('Y-m-d\TH:i') : '') }}">

                    </div>

                </div>

                <!-- ALL DAY -->

                <div class="event-switch-group">

                    <label class="event-switch">

                        <input type="checkbox"
                               name="all_day"

                               id="all_day"

                               value="1"

                               {{ old('all_day', $event->all_day) ? 'checked' : '' }}>

                        <span class="event-slider"></span>

                    </label>

                    <div>

                        <strong>
                            Evento de todo el día
                        </strong>

                        <p>
                            Oculta la hora de finalización.
                        </p>

                    </div>

                </div>

            </div>

            <!-- LOCATION -->

            <div class="event-card">

                <div class="event-section-title">

                    <i class='bx bx-map'></i>

                    <span>
                        Ubicación
                    </span>

                </div>

                <div class="event-group">

                    <label>
                        Lugar / referencia
                    </label>

                    <input type="text"
                           name="location"

                           id="eventLocation"

                           class="event-input"

                           placeholder="Ej: Av. Blanco Galindo"

                           value="{{ old('location', $event->location) }}">

                </div>

            </div>

        </div>

        <!-- RIGHT -->

        <div class="event-sidebar">

            <!-- PREVIEW -->

            <div class="event-preview-card">

                <div class="event-preview-header">

                    <span>
                        Vista previa
                    </span>

                    <div class="event-live-dot"></div>

                </div>

                <div class="event-preview-body">

                    <div class="event-preview-date">

                        <span id="previewDay">

                            {{ $event->start_at->format('d') }}

                        </span>

                        <small id="previewMonth">

                            {{ strtoupper($event->start_at->translatedFormat('M')) }}

                        </small>

                    </div>

                    <div class="event-preview-content">

                        <h3 id="previewTitle">

                            {{ $event->title }}

                        </h3>

                        <p id="previewLocation">

                            {{ $event->location ?? 'Ubicación pendiente' }}

                        </p>

                        <div class="event-preview-time">

                            <i class='bx bx-time'></i>

                            <span id="previewTime">

                                {{ $event->start_at->format('d/m/Y H:i') }}

                            </span>

                        </div>

                    </div>

                </div>

            </div>

            <!-- PUBLIC -->

            <div class="event-side-card">

                <h3>
                    Publicación
                </h3>

                <div class="event-switch-group">

                    <label class="event-switch">

                        <input type="checkbox"
                               name="is_public"

                               value="1"

                               {{ old('is_public', $event->is_public) ? 'checked' : '' }}>

                        <span class="event-slider"></span>

                    </label>

                    <div>

                        <strong>
                            Visible públicamente
                        </strong>

                        <p>
                            Se mostrará en la página principal.
                        </p>

                    </div>

                </div>

            </div>

            <!-- TIPS -->

            <div class="event-side-card">

                <h3>
                    Recomendaciones
                </h3>

                <ul class="event-tips">

                    <li>

                        <i class='bx bx-check-shield'></i>

                        Verifica horarios antes de actualizar.

                    </li>

                    <li>

                        <i class='bx bx-map-pin'></i>

                        Mantén ubicaciones claras y exactas.

                    </li>

                    <li>

                        <i class='bx bx-world'></i>

                        Revisa si será visible públicamente.

                    </li>

                </ul>

            </div>

            <!-- ACTIONS -->

            <div class="event-actions-box">

                <button type="submit"
                        class="event-save-btn">

                    <i class='bx bx-save'></i>

                    Actualizar evento

                </button>

            </div>

        </div>

    </form>

</div>

@endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', () => {

    // ========================================
    // PREVIEW
    // ========================================

    const title =
        document.getElementById('eventTitle');

    const location =
        document.getElementById('eventLocation');

    const start =
        document.getElementById('eventStart');

    const previewTitle =
        document.getElementById('previewTitle');

    const previewLocation =
        document.getElementById('previewLocation');

    const previewTime =
        document.getElementById('previewTime');

    const previewDay =
        document.getElementById('previewDay');

    const previewMonth =
        document.getElementById('previewMonth');

    title.addEventListener('input', () => {

        previewTitle.textContent =
            title.value || 'Evento operativo';

    });

    location.addEventListener('input', () => {

        previewLocation.textContent =
            location.value || 'Ubicación pendiente';

    });

    start.addEventListener('change', () => {

        if(!start.value) return;

        const date =
            new Date(start.value);

        previewDay.textContent =
            String(date.getDate()).padStart(2, '0');

        previewMonth.textContent =
            date.toLocaleDateString('es-ES', {
                month:'short'
            }).toUpperCase();

        previewTime.textContent =
            date.toLocaleString('es-ES');

    });

    // ========================================
    // ALL DAY
    // ========================================

    const allDay =
        document.getElementById('all_day');

    const endGroup =
        document.getElementById('endDateGroup');

    function toggleEndDate(){

        if(allDay.checked){

            endGroup.style.display = 'none';

        }else{

            endGroup.style.display = 'block';

        }

    }

    allDay.addEventListener(
        'change',
        toggleEndDate
    );

    toggleEndDate();

});

</script>

@endpush