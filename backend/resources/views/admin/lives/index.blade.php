@extends('layouts.admin')

@section('content')
<h2>Lista de Lives</h2>

<a href="{{ route('admin.lives.create') }}" class="btn btn-success mb-3">
    + Agregar Live
</a>

<table class="table">
    <thead>
        <tr>
            <th>Título</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        @foreach($lives as $live)
            <tr>
                <td>{{ $live->title }}</td>

                <td>
                    @if($live->is_active)
                        <span class="badge bg-success">Activo</span>
                    @else
                        <span class="badge bg-secondary">Inactivo</span>
                    @endif
                </td>

                <td>
                    <!-- ACTIVAR / DESACTIVAR -->
                    <form method="POST" action="{{ route('admin.lives.toggle', $live) }}" style="display:inline;">
                        @csrf
                        @method('PATCH')

                        <button class="btn btn-warning btn-sm me-1">
                            {{ $live->is_active ? 'Desactivar' : 'Activar' }}
                        </button>
                    </form>

                    <!-- ELIMINAR -->
                    <form method="POST" action="{{ route('admin.lives.destroy', $live) }}" style="display:inline;">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger btn-sm"
                            onclick="return confirm('¿Seguro que deseas eliminar este live?')">
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection