@extends('layouts.admin')

@section('title', 'Nuevo contacto')

@section('content')

<div class="contact-form-page">

    <!-- ========================================
        HEADER
    ========================================= -->

    <div class="contact-form-header">

        <div>

            <div class="contact-form-badge">
                Nuevo contacto institucional
            </div>

            <h1>
                Registrar contacto
            </h1>

            <p>
                Agrega unidades policiales, líneas
                institucionales, oficinas y contactos
                públicos visibles en el portal web.
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

    <form action="{{ route('admin.contacts.store') }}"
          method="POST"

          enctype="multipart/form-data"

          class="contact-form-layout">

        @csrf

        <!-- ========================================
            LEFT COLUMN
        ========================================= -->

        <div class="contact-main-column">

            <!-- BASIC INFO -->

            <div class="contact-form-card">

                <div class="contact-section-title">

                    <i class='bx bx-buildings'></i>

                    <span>
                        Información institucional
                    </span>

                </div>

                <!-- NAME -->

                <div class="contact-group">

                    <label>
                        Nombre de la unidad o contacto
                    </label>

                    <input type="text"
                           name="name"

                           id="contactName"

                           class="contact-input"

                           placeholder="Ej: Patrulla Caminera"

                           value="{{ old('name', $contact->name ?? '') }}"

                           required>

                </div>

                <!-- CATEGORY -->

                <div class="contact-group">

                    <label>
                        Categoría
                    </label>

                    <select name="contact_category_id"
                            class="contact-input">

                        <option value="">
                            Sin categoría
                        </option>

                        @foreach($categories as $category)

                            <option value="{{ $category->id }}"
                                @selected(old('contact_category_id', $contact->contact_category_id ?? '') == $category->id)>

                                {{ $category->name }}

                            </option>

                        @endforeach

                    </select>

                    <small class="contact-help-text">

                        Puedes crear nuevas categorías
                        desde el apartado correspondiente.

                    </small>

                </div>

                <!-- DESCRIPTION -->

                <div class="contact-group">

                    <label>
                        Descripción
                    </label>

                    <textarea name="description"
                              id="contactDescription"

                              class="contact-textarea"

                              placeholder="Describe brevemente la función de esta unidad o contacto...">{{ old('description', $contact->description ?? '') }}</textarea>

                </div>

            </div>

            <!-- CONTACT INFO -->

            <div class="contact-form-card">

                <div class="contact-section-title">

                    <i class='bx bx-phone'></i>

                    <span>
                        Información de contacto
                    </span>

                </div>

                <!-- PHONE -->

                <div class="contact-group">

                    <label>
                        Número de contacto
                    </label>

                    <input type="text"
                           name="phone"

                           id="contactPhone"

                           class="contact-input"

                           placeholder="+591 4441234"

                           value="{{ old('phone', $contact->phone ?? '') }}">

                </div>

                <!-- MAP -->

                <div class="contact-group">

                    <label>
                        URL de Google Maps
                    </label>

                    <input type="text"
                           name="map_url"

                           class="contact-input"

                           placeholder="https://maps.google.com/..."

                           value="{{ old('map_url', $contact->map_url ?? '') }}">

                    <small class="contact-help-text">

                        Se abrirá automáticamente desde
                        el frontend público.

                    </small>

                </div>

                <!-- LAT LNG -->

                <div class="contact-coordinates-grid">

                    <div class="contact-group">

                        <label>
                            Latitud
                        </label>

                        <input type="text"
                               name="lat"

                               class="contact-input"

                               placeholder="-17.393"

                               value="{{ old('lat', $contact->lat ?? '') }}">

                    </div>

                    <div class="contact-group">

                        <label>
                            Longitud
                        </label>

                        <input type="text"
                               name="lng"

                               class="contact-input"

                               placeholder="-66.157"

                               value="{{ old('lng', $contact->lng ?? '') }}">

                    </div>

                </div>

            </div>

            <!-- LOGO -->

            <div class="contact-form-card">

                <div class="contact-section-title">

                    <i class='bx bx-image'></i>

                    <span>
                        Imagen institucional
                    </span>

                </div>

                <label class="contact-upload-box">

                    <input type="file"
                           name="logo"

                           id="contactLogo"

                           hidden>

                    <div class="contact-upload-icon">

                        <i class='bx bx-cloud-upload'></i>

                    </div>

                    <h4>
                        Arrastra una imagen aquí
                    </h4>

                    <p>
                        JPG, PNG • Máximo 5MB
                    </p>

                </label>

                <div id="contactPreview"></div>

            </div>

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

                        <i class='bx bx-buildings'></i>

                    </div>

                    <div>

                        <div class="contact-preview-category">
                            Institucional
                        </div>

                        <h3 id="previewName">
                            Nuevo contacto
                        </h3>

                        <p id="previewDescription">
                            La descripción aparecerá aquí.
                        </p>

                    </div>

                    <div class="contact-preview-info">

                        <div class="contact-preview-item">

                            <i class='bx bx-phone'></i>

                            <span id="previewPhone">
                                Sin teléfono
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

            <!-- TIPS -->

            <div class="contact-side-card">

                <h3>
                    Recomendaciones
                </h3>

                <ul class="contact-tips">

                    <li>

                        <i class='bx bx-check-shield'></i>

                        Usa nombres claros y oficiales.

                    </li>

                    <li>

                        <i class='bx bx-map'></i>

                        Agrega enlaces válidos de Maps.

                    </li>

                    <li>

                        <i class='bx bx-image'></i>

                        Utiliza logos institucionales.

                    </li>

                </ul>

            </div>

            <!-- ACTIONS -->

            <button type="submit"
                    class="contact-save-btn">

                <i class='bx bx-save'></i>

                Guardar contacto

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

    // NAME

    name.addEventListener('input', () => {

        previewName.textContent =
            name.value || 'Nuevo contacto';

    });

    // DESCRIPTION

    description.addEventListener('input', () => {

        previewDescription.textContent =
            description.value ||
            'La descripción aparecerá aquí.';

    });

    // PHONE

    phone.addEventListener('input', () => {

        previewPhone.textContent =
            phone.value || 'Sin teléfono';

    });

    // LOGO

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