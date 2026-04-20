@extends('layouts.admin')

@section('title', 'Nueva categoría')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Nueva categoría de contacto</h1>
        <a href="{{ route('admin.contact-categories.index') }}" class="btn btn-outline-secondary btn-sm">
            Volver
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Revisa los campos:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.contact-categories.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nombre de la categoría</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    <small class="text-muted">Ej: Emergencias y atención inmediata</small>
                </div>

                <div class="mt-3 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.contact-categories.index') }}" class="btn btn-light">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Guardar categoría
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
