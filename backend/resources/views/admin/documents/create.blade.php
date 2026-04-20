@extends('layouts.admin')

@section('content')
    <h2 class="mb-4">Nuevo documento</h2>

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

    <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Número de documento</label>
            <input type="text" name="number" class="form-control" value="{{ old('number') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Título*</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Tipo de documento*</label>
            <select name="type" class="form-select" required>
                <option value="">Seleccione...</option>
                <option value="rendicion" {{ old('type') == 'rendicion' ? 'selected' : '' }}>
                    Rendición de Cuentas Públicas
                </option>
                <option value="poa" {{ old('type') == 'poa' ? 'selected' : '' }}>
                    Plan Operativo Anual (POA)
                </option>
                <option value="pei" {{ old('type') == 'pei' ? 'selected' : '' }}>
                    Plan Estratégico Institucional (PEI)
                </option>
            </select>
        </div>

        <div class="mb-3">
    <label class="form-label">Enlace del PDF*</label>
    <input type="url" name="file_url" class="form-control" 
           placeholder="https://drive.google.com/....pdf" required>
    <small class="text-muted">
        Puedes usar enlaces de Google Drive, Dropbox, OneDrive, servidores, etc.
    </small>
</div>


        <div class="mb-3 form-check">
            <input type="checkbox" name="is_public" id="is_public" class="form-check-input"
                   value="1" {{ old('is_public', 1) ? 'checked' : '' }}>
            <label for="is_public" class="form-check-label">Visible en la página pública</label>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
