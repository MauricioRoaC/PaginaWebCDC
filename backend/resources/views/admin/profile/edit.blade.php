@extends('layouts.admin')

@section('content')
    <h2 class="mb-4">Mi perfil</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="col-md-6">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nombre completo</label>
            <input type="text"
                   name="name"
                   class="form-control"
                   value="{{ old('name', $user->name) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Correo electrónico</label>
            <input type="email"
                   name="email"
                   class="form-control"
                   value="{{ old('email', $user->email) }}"
                   required>
        </div>
<div class="mb-3">
    <label class="form-label">Fotografía de perfil</label>
    <input type="file" name="avatar" class="form-control">

    @if($user->avatar)
        <div class="mt-3">
            <img src="{{ asset('storage/'.$user->avatar) }}"
                 alt="avatar"
                 width="120"
                 class="rounded">
        </div>
    @endif
</div>

        <hr>

        <h5 class="mt-3">Cambiar contraseña (opcional)</h5>

        <div class="mb-3">
            <label class="form-label">Nueva contraseña</label>
            <input type="password" name="password" class="form-control">
            <small class="text-muted">Déjalo vacío si no quieres cambiarla.</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Confirmar nueva contraseña</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Guardar cambios</button>
    </form>
@endsection
