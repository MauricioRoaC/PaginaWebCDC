@extends('layouts.admin')

@section('title', 'Editar contacto')

@section('content')

<div class="contact-form-page edit-mode">

    <!-- ========================================
        HEADER
    ========================================= -->

    <div class="contact-form-header">

        <div>

            <div class="contact-form-badge edit">
                Editando contacto institucional
            </div>

            <h1>
                Editar contacto
            </h1>

            <p>
                Actualiza información institucional,
                teléfonos, ubicación y visibilidad
                pública del contacto.
            </p>

        </div>

        <a href="{{ route('admin.contacts.index') }}"
           class="contact-back-btn">

            <i class='bx bx-arrow-back'></i>

            Volver al listado

        </a>

    </div>

    <!-- ========================================
        ERRORS
    ========================================= -->

    @if($errors->any())

        <div class="contact-error-box">

            <div class="contact-error-title">

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

    <form action="{{ route('admin.contacts.update', $contact) }}"
          method="POST"

          enctype="multipart/form-data"

          class="contact-form-layout">

        @csrf
        @method('PUT')

        <!-- ========================================
            LEFT COLUMN
        ========================================= -->

        <div class="contact-main-column">

            @include('admin.contacts._form')

        </div>

        <!-- ========================================
            RIGHT COLUMN
        ========================================= -->

        <div class="contact-sidebar">

            <!-- PREVIEW -->

            <div class="contact-preview-card">

                <div class="contact-preview-header">

                    <span>
                        Vista previa
                    </span>

                    <div class="contact-preview-dot"></div>

                </div>

                <div class="contact-preview-body">

                    <div class="contact-preview-logo"
                         id="previewLogo">

                        @if($contact->logo_path)

                            <img src="{{ asset('storage/'.$contact->logo_path) }}"
                                 class="contact-preview-image">

                        @else

                            <i class='bx bx-buildings'></i>

                        @endif

                    </div>

                    <div>

                        <div class="contact-preview-category">

                            {{ $contact->category->name ?? 'Institucional' }}

                        </div>

                        <h3 id="previewName">

                            {{ $contact->name }}

                        </h3>

                        <p id="previewDescription">

                            {{ $contact->description
                                ?: 'La descripción aparecerá aquí.' }}

                        </p>

                    </div>

                    <div class="contact-preview-info">

                        <div class="contact-preview-item">

                            <i class='bx bx-phone'></i>

                            <span id="previewPhone">

                                {{ $contact->phone ?: 'Sin teléfono' }}

                            </span>

                        </div>

                    </div>

                </div>

            </div>

            <!-- VISIBILITY -->

            <div class="contact-side-card">

                <h3>
                    Publicación
                </h3>

                <div class="contact-switch-group">

                    <label class="contact-switch">

                        <input type="checkbox"
                               name="is_visible"

                               value="1"

                               {{ old('is_visible', $contact->is_visible ?? true) ? 'checked' : '' }}>

                        <span class="contact-slider"></span>

                    </label>

                    <div>

                        <strong>
                            Visible públicamente
                        </strong>

                        <p>
                            Este contacto aparecerá
                            en el frontend público.
                        </p>

                    </div>

                </div>

            </div>

            <!-- QUICK ACTION -->

            @if($contact->map_url)

                <div class="contact-side-card">

                    <h3>
                        Acceso rápido
                    </h3>

                    <a href="{{ $contact->map_url }}"
                       target="_blank"

                       class="contact-map-btn">

                        <i class='bx bx-map'></i>

                        Abrir ubicación

                    </a>

                </div>

            @endif

            <!-- SAVE -->

            <button type="submit"
                    class="contact-save-btn edit-btn">

                <i class='bx bx-save'></i>

                Actualizar contacto

            </button>

        </div>

    </form>

</div>

@endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', () => {

    const name =
        document.getElementById('contactName');

    const description =
        document.getElementById('contactDescription');

    const phone =
        document.getElementById('contactPhone');

    const previewName =
        document.getElementById('previewName');

    const previewDescription =
        document.getElementById('previewDescription');

    const previewPhone =
        document.getElementById('previewPhone');

    const logoInput =
        document.getElementById('contactLogo');

    const previewLogo =
        document.getElementById('previewLogo');

    // ========================================
    // NAME
    // ========================================

    name.addEventListener('input', () => {

        previewName.textContent =
            name.value || 'Nuevo contacto';

    });

    // ========================================
    // DESCRIPTION
    // ========================================

    description.addEventListener('input', () => {

        previewDescription.textContent =
            description.value ||
            'La descripción aparecerá aquí.';

    });

    // ========================================
    // PHONE
    // ========================================

    phone.addEventListener('input', () => {

        previewPhone.textContent =
            phone.value || 'Sin teléfono';

    });

    // ========================================
    // LOGO
    // ========================================

    logoInput.addEventListener('change', (e) => {

        const file = e.target.files[0];

        if(!file) return;

        const reader = new FileReader();

        reader.onload = function(ev){

            previewLogo.innerHTML = `
                <img src="${ev.target.result}"
                     class="contact-preview-image">
            `;

        };

        reader.readAsDataURL(file);

    });

});

</script>

@endpush