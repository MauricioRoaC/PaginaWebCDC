@extends('layouts.admin')

@section('content')
<h2>Editar Unidad</h2>

<form method="POST" action="{{ route('admin.units.update', $unit) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nombre</label>
        <input type="text" name="name" class="form-control" value="{{ $unit->name }}">
    </div>

    <button class="btn btn-primary">Actualizar</button>
</form>
@endsection