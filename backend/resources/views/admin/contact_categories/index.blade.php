@extends('layouts.admin')

@section('title', 'Categorías de contacto')

@section('content')

<div class="contact-category-page">

    <!-- ========================================
        HEADER
    ========================================= -->

    <div class="contact-category-header">

        <div>

            <div class="contact-category-badge">
                Organización institucional
            </div>

            <h1>
                Categorías de contacto
            </h1>

            <p>
                Organiza las unidades, oficinas y líneas
                institucionales visibles en el directorio público.
            </p>

        </div>

        <a href="{{ route('admin.contact-categories.create') }}"
           class="contact-category-create-btn">

            <i class='bx bx-plus'></i>

            Nueva categoría

        </a>

    </div>

    <!-- ========================================
        ALERT
    ========================================= -->

    @if(session('success'))

        <div class="contact-category-alert">

            <i class='bx bx-check-circle'></i>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif

    <!-- ========================================
        EMPTY
    ========================================= -->

    @if($categories->isEmpty())

        <div class="contact-category-empty">

            <div class="contact-category-empty-icon">

                <i class='bx bx-category'></i>

            </div>

            <h3>
                No hay categorías registradas
            </h3>

            <p>
                Crea categorías para organizar
                los contactos institucionales.
            </p>

            <a href="{{ route('admin.contact-categories.create') }}"
               class="contact-category-create-btn">

                <i class='bx bx-plus'></i>

                Crear categoría

            </a>

        </div>

    @else

        <!-- ========================================
            STATS
        ========================================= -->

        <div class="contact-category-stats">

            <div class="contact-category-stat-card">

                <div class="contact-category-stat-icon">

                    <i class='bx bx-category'></i>

                </div>

                <div>

                    <strong>
                        {{ $categories->count() }}
                    </strong>

                    <span>
                        Categorías creadas
                    </span>

                </div>

            </div>

        </div>

        <!-- ========================================
            GRID
        ========================================= -->

        <div class="contact-category-grid">

            @foreach($categories as $category)

                <div class="contact-category-card">

                    <!-- TOP -->

                    <div class="contact-category-card-top">

                        <div class="contact-category-icon">

                            <i class='bx bx-folder'></i>

                        </div>

                        <div class="contact-category-slug">

                            {{ $category->slug }}

                        </div>

                    </div>

                    <!-- BODY -->

                    <div class="contact-category-body">

                        <h3>

                            {{ $category->name }}

                        </h3>

                        <p>

                            Categoría utilizada para
                            clasificar contactos y unidades
                            institucionales.

                        </p>

                    </div>

                    <!-- ACTIONS -->

                    <div class="contact-category-actions">

                        <a href="{{ route('admin.contact-categories.edit', $category) }}"
                           class="contact-category-edit-btn">

                            <i class='bx bx-edit'></i>

                            Editar

                        </a>

                        <form action="{{ route('admin.contact-categories.destroy', $category) }}"
                              method="POST"

                              onsubmit="return confirm('¿Eliminar esta categoría? Los contactos quedarán sin categoría.')">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="contact-category-delete-btn">

                                <i class='bx bx-trash'></i>

                                Eliminar

                            </button>

                        </form>

                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>

@endsection