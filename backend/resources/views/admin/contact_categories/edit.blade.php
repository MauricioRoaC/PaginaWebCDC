@extends('layouts.admin')

@section('title', 'Editar categoría')

@section('content')

<div class="contact-category-form-page edit-mode">

    <!-- ========================================
        HEADER
    ========================================= -->

    <div class="contact-category-form-header">

        <div>

            <div class="contact-category-form-badge edit">
                Editando categoría institucional
            </div>

            <h1>
                Editar categoría
            </h1>

            <p>
                Actualiza el nombre y organización
                de las categorías utilizadas en
                el directorio institucional.
            </p>

        </div>

        <a href="{{ route('admin.contact-categories.index') }}"
           class="contact-category-back-btn">

            <i class='bx bx-arrow-back'></i>

            Volver

        </a>

    </div>

    <!-- ========================================
        ERRORS
    ========================================= -->

    @if($errors->any())

        <div class="contact-category-error-box">

            <div class="contact-category-error-title">

                <i class='bx bx-error-circle'></i>

                Revisa los siguientes campos

            </div>

            <ul>

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <!-- ========================================
        FORM
    ========================================= -->

    <form action="{{ route('admin.contact-categories.update', $contactCategory) }}"
          method="POST"

          class="contact-category-form-layout">

        @csrf
        @method('PUT')

        <!-- ========================================
            LEFT
        ========================================= -->

        <div class="contact-category-main-column">

            <div class="contact-category-form-card">

                <div class="contact-category-section-title">

                    <i class='bx bx-category'></i>

                    <span>
                        Información de categoría
                    </span>

                </div>

                <!-- NAME -->

                <div class="contact-category-group">

                    <label>
                        Nombre de la categoría
                    </label>

                    <input type="text"
                           name="name"

                           id="categoryName"

                           class="contact-category-input"

                           placeholder="Ej: Emergencias y atención inmediata"

                           value="{{ old('name', $contactCategory->name) }}"

                           required>

                    <small class="contact-category-help-text">

                        Usa nombres organizados y claros
                        para mantener el directorio limpio.

                    </small>

                </div>

                <!-- SLUG -->

                <div class="contact-category-group">

                    <label>
                        Slug generado
                    </label>

                    <input type="text"
                           class="contact-category-input"

                           value="{{ $contactCategory->slug }}"

                           readonly>

                    <small class="contact-category-help-text">

                        El slug se actualiza automáticamente
                        según el nombre de la categoría.

                    </small>

                </div>

            </div>

        </div>

        <!-- ========================================
            RIGHT
        ========================================= -->

        <div class="contact-category-sidebar">

            <!-- PREVIEW -->

            <div class="contact-category-preview-card">

                <div class="contact-category-preview-header">

                    <span>
                        Vista previa
                    </span>

                    <div class="contact-category-preview-dot"></div>

                </div>

                <div class="contact-category-preview-body">

                    <div class="contact-category-preview-icon">

                        <i class='bx bx-folder'></i>

                    </div>

                    <div class="contact-category-preview-content">

                        <div class="contact-category-preview-badge">

                            Categoría institucional

                        </div>

                        <h3 id="categoryPreviewName">

                            {{ $contactCategory->name }}

                        </h3>

                        <p>

                            Esta categoría se utiliza
                            para organizar contactos
                            y unidades institucionales.

                        </p>

                    </div>

                </div>

            </div>

            <!-- INFO -->

            <div class="contact-category-side-card">

                <h3>
                    Información
                </h3>

                <ul class="contact-category-tips">

                    <li>

                        <i class='bx bx-folder'></i>

                        Categoría actualmente registrada.

                    </li>

                    <li>

                        <i class='bx bx-edit'></i>

                        Los cambios afectan el directorio.

                    </li>

                    <li>

                        <i class='bx bx-check-shield'></i>

                        Mantén una estructura organizada.

                    </li>

                </ul>

            </div>

            <!-- ACTION -->

            <button type="submit"
                    class="contact-category-save-btn edit-btn">

                <i class='bx bx-save'></i>

                Actualizar categoría

            </button>

        </div>

    </form>

</div>

@endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', () => {

    const categoryName =
        document.getElementById('categoryName');

    const categoryPreview =
        document.getElementById('categoryPreviewName');

    categoryName.addEventListener('input', () => {

        categoryPreview.textContent =
            categoryName.value || 'Nueva categoría';

    });

});

</script>

@endpush