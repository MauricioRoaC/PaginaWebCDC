@extends('layouts.admin')

@section('content')
<h2>Agregar Live</h2>

<form method="POST" action="{{ route('admin.lives.store') }}">
    @csrf

    <div class="mb-3">
        <label>Título</label>
        <input type="text" name="title" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Embed o Link del Live</label>
        <textarea name="embed_url" class="form-control" rows="4" required></textarea>
    </div>

    <button class="btn btn-success">Guardar Live</button>
</form>
@endsection