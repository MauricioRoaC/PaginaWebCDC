@extends('layouts.admin')

@section('title', 'Categorías de contacto')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Categorías de contacto</h1>
        <a href="{{ route('admin.contact-categories.create') }}" class="btn btn-primary btn-sm">
            + Nueva categoría
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @if($categories->isEmpty())
        <div class="alert alert-info">
            No hay categorías creadas todavía.
        </div>
    @else
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Slug</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td><span class="text-muted">{{ $category->slug }}</span></td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.contact-categories.edit', $category) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            Editar
                                        </a>
                                        <form action="{{ route('admin.contact-categories.destroy', $category) }}"
                                              method="POST"
                                              class="d-inline-block"
                                              onsubmit="return confirm('¿Eliminar esta categoría? Los contactos quedarán sin categoría.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection
