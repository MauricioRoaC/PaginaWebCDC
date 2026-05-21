@extends('layouts.admin')

@section('title', 'Contactos')

@section('content')

<div class="contacts-page">

    <!-- ========================================
        HEADER
    ========================================= -->

    <div class="contacts-header">

        <div>

            <div class="contacts-badge">
                Directorio institucional
            </div>

            <h1>
                Contactos policiales
            </h1>

            <p>
                Gestiona unidades, líneas institucionales,
                oficinas y contactos públicos visibles
                en la página oficial.
            </p>

        </div>

        <div class="contacts-header-actions">

            <a href="{{ route('admin.contact-categories.index') }}"
               class="contacts-outline-btn">

                <i class='bx bx-category'></i>

                Categorías

            </a>

            <a href="{{ route('admin.contacts.create') }}"
               class="contacts-main-btn">

                <i class='bx bx-plus'></i>

                Nuevo contacto

            </a>

        </div>

    </div>

    <!-- ========================================
        STATS
    ========================================= -->

    <div class="contacts-stats">

        <div class="contacts-stat-card">

            <div class="contacts-stat-icon">
                <i class='bx bx-buildings'></i>
            </div>

            <div>

                <strong>
                    {{ $contacts->total() }}
                </strong>

                <span>
                    Contactos registrados
                </span>

            </div>

        </div>

        <div class="contacts-stat-card">

            <div class="contacts-stat-icon visible">
                <i class='bx bx-show'></i>
            </div>

            <div>

                <strong>
                    {{ $contacts->where('is_visible', true)->count() }}
                </strong>

                <span>
                    Visibles públicamente
                </span>

            </div>

        </div>

    </div>

    <!-- ========================================
        ALERT
    ========================================= -->

    @if(session('success'))

        <div class="contacts-alert-success">

            <i class='bx bx-check-circle'></i>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif

    <!-- ========================================
        EMPTY
    ========================================= -->

    @if($contacts->isEmpty())

        <div class="contacts-empty">

            <div class="contacts-empty-icon">
                <i class='bx bx-phone-off'></i>
            </div>

            <h3>
                No hay contactos registrados
            </h3>

            <p>
                Agrega el primer contacto institucional
                para comenzar.
            </p>

            <a href="{{ route('admin.contacts.create') }}"
               class="contacts-main-btn">

                <i class='bx bx-plus'></i>

                Crear contacto

            </a>

        </div>

    @else

        <!-- ========================================
            GRID
        ========================================= -->

        <div class="contacts-grid">

            @foreach($contacts as $contact)

                <div class="contact-card">

                    <!-- TOP -->

                    <div class="contact-card-top">

                        <div class="contact-logo-wrapper">

                            @if($contact->logo_path)

                                <img src="{{ asset('storage/'.$contact->logo_path) }}"
                                     alt="Logo"

                                     class="contact-logo">

                            @else

                                <div class="contact-logo-placeholder">

                                    <i class='bx bx-buildings'></i>

                                </div>

                            @endif

                        </div>

                        <form action="{{ route('admin.contacts.toggle-visible', $contact) }}"
                              method="POST">

                            @csrf
                            @method('PATCH')

                            @if($contact->is_visible)

                                <button type="submit"
                                        class="contact-visible-btn active">

                                    <i class='bx bx-show'></i>

                                    Visible

                                </button>

                            @else

                                <button type="submit"
                                        class="contact-visible-btn">

                                    <i class='bx bx-hide'></i>

                                    Oculto

                                </button>

                            @endif

                        </form>

                    </div>

                    <!-- BODY -->

                    <div class="contact-card-body">

                        <!-- CATEGORY -->

                        @if($contact->category)

                            <div class="contact-category">

                                {{ $contact->category->name }}

                            </div>

                        @else

                            <div class="contact-category empty">

                                Sin categoría

                            </div>

                        @endif

                        <!-- TITLE -->

                        <h3>
                            {{ $contact->name }}
                        </h3>

                        <!-- DESCRIPTION -->

                        <p>

                            {{ $contact->description
                                ? \Illuminate\Support\Str::limit($contact->description, 90)
                                : 'Sin descripción disponible.' }}

                        </p>

                        <!-- INFO -->

                        <div class="contact-info-list">

                            <!-- PHONE -->

                            <a href="tel:{{ $contact->phone }}"
                               class="contact-info-item">

                                <i class='bx bx-phone'></i>

                                <span>

                                    {{ $contact->phone ?: 'Sin teléfono' }}

                                </span>

                            </a>

                            <!-- MAP -->

                            @if($contact->map_url)

                                <a href="{{ $contact->map_url }}"
                                   target="_blank"

                                   class="contact-info-item">

                                    <i class='bx bx-map'></i>

                                    <span>
                                        Ver ubicación
                                    </span>

                                </a>

                            @else

                                <div class="contact-info-item disabled">

                                    <i class='bx bx-map-pin'></i>

                                    <span>
                                        Sin ubicación
                                    </span>

                                </div>

                            @endif

                        </div>

                    </div>

                    <!-- ACTIONS -->

                    <div class="contact-card-actions">

                        <a href="{{ route('admin.contacts.edit', $contact) }}"
                           class="contact-edit-btn">

                            <i class='bx bx-edit-alt'></i>

                            Editar

                        </a>

                        <form action="{{ route('admin.contacts.destroy', $contact) }}"
                              method="POST"

                              onsubmit="return confirm('¿Eliminar este contacto?')">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="contact-delete-btn">

                                <i class='bx bx-trash'></i>

                                Eliminar

                            </button>

                        </form>

                    </div>

                </div>

            @endforeach

        </div>

        <!-- PAGINATION -->

        @if($contacts instanceof \Illuminate\Pagination\AbstractPaginator)

            <div class="contacts-pagination">

                {{ $contacts->links() }}

            </div>

        @endif

    @endif

</div>

@endsection