@extends('layouts.admin')

@section('content')
    <h2 class="mb-4">Editar evento</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Revisa los campos:</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.events.update', $event) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Asunto*</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $event->title) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $event->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Inicio*</label>
            <input type="datetime-local" name="start_at" class="form-control"
                   value="{{ old('start_at', $event->start_at->format('Y-m-d\TH:i')) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Fin</label>
            <input type="datetime-local" name="end_at" class="form-control"
                   value="{{ old('end_at', $event->end_at ? $event->end_at->format('Y-m-d\TH:i') : '') }}">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="all_day" id="all_day" class="form-check-input"
                   value="1" {{ old('all_day', $event->all_day) ? 'checked' : '' }}>
            <label for="all_day" class="form-check-label">Evento de todo el día</label>
        </div>

        <div class="mb-3">
            <label class="form-label">Ubicación / Detalle</label>
            <input type="text" name="location" class="form-control"
                   value="{{ old('location', $event->location) }}">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="is_public" id="is_public" class="form-check-input"
                   value="1" {{ old('is_public', $event->is_public) ? 'checked' : '' }}>
            <label for="is_public" class="form-check-label">Visible en la página pública</label>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
