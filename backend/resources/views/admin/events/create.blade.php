@extends('layouts.admin')

@section('content')
    <h2 class="mb-4">Nuevo evento</h2>

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

    <form action="{{ route('admin.events.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Asunto*</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Inicio*</label>
            <input type="datetime-local" name="start_at" class="form-control"
                   value="{{ old('start_at') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Fin</label>
            <input type="datetime-local" name="end_at" class="form-control"
                   value="{{ old('end_at') }}">
            <small class="form-text text-muted">
                Opcional. Si es un evento de todo el día, puedes dejarlo vacío.
            </small>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="all_day" id="all_day" class="form-check-input"
                   value="1" {{ old('all_day') ? 'checked' : '' }}>
            <label for="all_day" class="form-check-label">Evento de todo el día</label>
        </div>

        <div class="mb-3">
            <label class="form-label">Ubicación / Detalle</label>
            <input type="text" name="location" class="form-control" value="{{ old('location') }}"
                   placeholder="Ej: Cierre Av. XXX desde Av. YYY hasta Av. ZZZ">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="is_public" id="is_public" class="form-check-input"
                   value="1" {{ old('is_public', 1) ? 'checked' : '' }}>
            <label for="is_public" class="form-check-label">Visible en la página pública</label>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
