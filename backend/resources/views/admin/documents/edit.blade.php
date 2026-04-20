@extends('layouts.admin')

@section('content')
    <h2 class="mb-4">Editar documento</h2>

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

    <form action="{{ route('admin.documents.update', $document) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Número de documento</label>
            <input type="text" name="number" class="form-control" value="{{ old('number', $document->number) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Título*</label>
            <input type="text" name="title" class="form-control"
                   value="{{ old('title', $document->title) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $document->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Tipo de documento*</label>
            <select name="type" class="form-select" required>
                <option value="rendicion" {{ old('type', $document->type) == 'rendicion' ? 'selected' : '' }}>
                    Rendición de Cuentas Públicas
                </option>
                <option value="poa" {{ old('type', $document->type) == 'poa' ? 'selected' : '' }}>
                    Plan Operativo Anual (POA)
                </option>
                <option value="pei" {{ old('type', $document->type) == 'pei' ? 'selected' : '' }}>
                    Plan Estratégico Institucional (PEI)
                </option>
            </select>
        </div>

       <div class="mb-3">
    <label class="form-label">Enlace del PDF*</label>
    <input type="url" name="file_url" class="form-control"
           value="{{ old('file_url', $document->file_url) }}" required>
</div>


        <div class="mb-3 form-check">
            <input type="checkbox" name="is_public" id="is_public" class="form-check-input"
                   value="1" {{ old('is_public', $document->is_public) ? 'checked' : '' }}>
            <label for="is_public" class="form-check-label">Visible en la página pública</label>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
