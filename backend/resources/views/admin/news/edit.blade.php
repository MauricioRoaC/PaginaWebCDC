@extends('layouts.admin')

@section('content')
    <h2 class="mb-3">Editar noticia</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $news->title) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción corta</label>
            <textarea name="description" class="form-control" rows="3" required>{{ old('description', $news->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Contenido completo (opcional)</label>
            <textarea name="body" class="form-control" rows="6">{{ old('body', $news->body) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label d-block">Imágenes actuales</label>
            @if($news->images->count())
                <div class="d-flex flex-wrap gap-2 mb-2">
                    @foreach($news->images as $img)
                        <div>
                            <img src="{{ asset('storage/'.$img->path) }}" alt="" style="height:80px;">
                            @if($img->is_main)
                                <div><small class="text-success">Principal</small></div>
                            @endif
                        </div>
                    @endforeach
                </div>
                <small class="text-muted d-block mb-2">
                    Si subes nuevas imágenes, reemplazarán a las anteriores.
                </small>
            @else
                <p class="text-muted">Esta noticia no tiene imágenes.</p>
            @endif

            <input type="file" name="images[]" class="form-control" multiple>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
