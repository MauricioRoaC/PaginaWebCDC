@extends('layouts.admin')

@section('title', 'Editar contacto')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Editar contacto</h1>
        <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary btn-sm">
            Volver al listado
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
            <form action="{{ route('admin.contacts.update', $contact) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('admin.contacts._form')

                <div class="mt-3 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.contacts.index') }}" class="btn btn-light">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Actualizar contacto
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
