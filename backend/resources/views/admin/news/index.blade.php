@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Noticias</h2>
        <a href="{{ route('admin.news.create') }}" class="btn btn-sm btn-primary">Nueva noticia</a>
    </div>

    @if($news->count())
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                <tr>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Fecha publicación</th>
                    <th style="width: 150px;">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($news as $item)
                    <tr>
                        <td>{{ $item->title }}</td>
                        <td>{{ Str::limit($item->description, 80) }}</td>
                        <td>{{ optional($item->published_at)->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-sm btn-warning">
                                Editar
                            </a>
                            <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar esta noticia?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{ $news->links() }}
    @else
        <p>No hay noticias creadas aún.</p>
    @endif
@endsection
