@extends('layouts.admin')

@section('content')
    <h2 class="mb-4">Calendario de actividades</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
            Nuevo evento
        </a>
    </div>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Asunto</th>
            <th>Inicio</th>
            <th>Fin</th>
            <th>Ubicación</th>
            <th>Público</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @forelse($events as $event)
            <tr>
                <td>{{ $event->title }}</td>
                <td>{{ $event->start_at->format('d/m/Y H:i') }}</td>
                <td>{{ $event->end_at ? $event->end_at->format('d/m/Y H:i') : '-' }}</td>
                <td>{{ $event->location ?? '-' }}</td>
                <td>
                    @if($event->is_public)
                        <span class="badge bg-success">Sí</span>
                    @else
                        <span class="badge bg-secondary">No</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-sm btn-warning">Editar</a>

                    <form action="{{ route('admin.events.destroy', $event) }}"
                          method="POST"
                          style="display:inline-block"
                          onsubmit="return confirm('¿Eliminar este evento?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">No hay eventos registrados.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $events->links() }}
@endsection
