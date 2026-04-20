@extends('layouts.admin')

@section('content')
<h2>Crear Unidad</h2>

<form method="POST" action="{{ route('admin.units.store') }}">
    @csrf

    <div class="mb-3">
        <label>Nombre</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <button class="btn btn-success">Guardar</button>
</form>
@endsection