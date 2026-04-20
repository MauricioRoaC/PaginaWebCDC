@extends('layouts.admin')

@section('title', 'Contactos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Contactos</h1>
        <div>
            <a href="{{ route('admin.contact-categories.index') }}" class="btn btn-outline-secondary btn-sm me-2">
                Categorías
            </a>
            <a href="{{ route('admin.contacts.create') }}" class="btn btn-primary btn-sm">
                + Nuevo contacto
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @if($contacts->isEmpty())
        <div class="alert alert-info">
            No hay contactos registrados todavía. Crea uno nuevo para comenzar.
        </div>
    @else
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Logo</th>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Teléfono</th>
                                <th>Ubicación</th>
                                <th>Visible</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contacts as $contact)
                                <tr>
                                    <td>{{ $loop->iteration + ($contacts->currentPage() - 1) * $contacts->perPage() }}</td>

                                    <td>
                                        @if($contact->logo_path)
                                            <img src="{{ asset('storage/'.$contact->logo_path) }}"
                                                 alt="Logo"
                                                 style="height:40px;width:auto;border-radius:4px;">
                                        @else
                                            <span class="text-muted small">Sin logo</span>
                                        @endif
                                    </td>

                                    <td>
                                        <strong>{{ $contact->name }}</strong>
                                        @if($contact->description)
                                            <div class="small text-muted">
                                                {{ \Illuminate\Support\Str::limit($contact->description, 60) }}
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        @if($contact->category)
                                            <span class="badge bg-secondary">
                                                {{ $contact->category->name }}
                                            </span>
                                        @else
                                            <span class="badge bg-light text-muted border">
                                                Sin categoría
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($contact->phone)
                                            <a href="tel:{{ $contact->phone }}">
                                                {{ $contact->phone }}
                                            </a>
                                        @else
                                            <span class="text-muted small">No definido</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($contact->lat && $contact->lng)
                                            <div class="small">
                                                <span class="d-block">
                                                    Lat: {{ $contact->lat }}
                                                </span>
                                                <span class="d-block">
                                                    Lng: {{ $contact->lng }}
                                                </span>
                                            </div>
                                            @if($contact->map_url)
                                                <a href="{{ $contact->map_url }}" target="_blank" class="small">
                                                    Ver en Google Maps
                                                </a>
                                            @endif
                                        @else
                                            <span class="text-muted small">Sin coordenadas</span>
                                        @endif
                                    </td>

                                    <td>
                                        <form action="{{ route('admin.contacts.toggle-visible', $contact) }}"
                                              method="POST">
                                            @csrf
                                            @method('PATCH')

                                            @if($contact->is_visible)
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    Visible
                                                </button>
                                            @else
                                                <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                    Oculto
                                                </button>
                                            @endif
                                        </form>
                                    </td>

                                    <td class="text-end">
                                        <a href="{{ route('admin.contacts.edit', $contact) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            Editar
                                        </a>

                                        <form action="{{ route('admin.contacts.destroy', $contact) }}"
                                              method="POST"
                                              class="d-inline-block"
                                              onsubmit="return confirm('¿Seguro que deseas eliminar este contacto?');">
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

                @if($contacts instanceof \Illuminate\Pagination\AbstractPaginator)
                    <div class="card-footer">
                        {{ $contacts->links() }}
                    </div>
                @endif
            </div>
        </div>
    @endif
@endsection
