@extends('layouts.admin')

@section('content')
<h2>Unidades</h2>

<a href="{{ route('admin.units.create') }}" class="btn btn-primary mb-3">Crear Unidad</a>

<table class="table">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Acciones</th>
    </tr>

    @foreach($units as $unit)
    <tr>
        <td>{{ $unit->id }}</td>
        <td>{{ $unit->name }}</td>
        <td>
            <a href="{{ route('admin.units.edit', $unit) }}" class="btn btn-warning btn-sm">Editar</a>

            <form action="{{ route('admin.units.destroy', $unit) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">Eliminar</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection