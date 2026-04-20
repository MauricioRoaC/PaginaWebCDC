@extends('layouts.admin')

@section('content')
<h2>Historial de Actividad</h2>

<form method="GET" class="mb-3 d-flex gap-2">
    <input type="text" name="search" class="form-control" placeholder="Buscar usuario..." value="{{ request('search') }}">

    <select name="module" class="form-select">
        <option value="">Todos los módulos</option>
        <option value="users">Usuarios</option>
        <option value="news">Noticias</option>
        <option value="events">Eventos</option>
        <option value="contacts">Contactos</option>
    </select>

    <button class="btn btn-primary">Filtrar</button>
</form>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Acción</th>
                <th>Módulo</th>
                <th>Descripción</th>
                <th>Fecha</th>
            </tr>
        </thead>

        <tbody>
            @foreach($logs as $log)
            <tr>
                <td>{{ $log->user->name ?? 'Sistema' }}</td>
                <td>{{ $log->action }}</td>
                <td>{{ $log->module }}</td>
                <td>{{ $log->description }}</td>
                <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- PAGINACIÓN -->
<div class="pagination-container">
    {{ $logs->onEachSide(1)->links() }}
</div>

@endsection