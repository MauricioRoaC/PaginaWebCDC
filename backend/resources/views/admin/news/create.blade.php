@extends('layouts.admin')

@section('content')
    <h2 class="mb-3">Crear noticia</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción corta</label>
            <textarea name="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Contenido completo (opcional)</label>
            <textarea name="body" class="form-control" rows="6">{{ old('body') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Imágenes (máx. 10)</label>
            <input type="file" name="images[]" class="form-control" multiple>
            <small class="text-muted">Cada imagen máximo 2MB.</small>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
