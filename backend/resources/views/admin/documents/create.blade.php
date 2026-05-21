@extends('layouts.admin')

@section('content')

<div class="doc-form-page">

    <!-- HEADER -->

    <div class="doc-form-header">

        <div>

            <h1>
                Nuevo documento institucional
            </h1>

            <p>
                Publica enlaces oficiales de documentos,
                rendiciones y planes institucionales.
            </p>

        </div>

        <a href="{{ route('admin.documents.index') }}"
           class="doc-back-btn">

            <i class='bx bx-arrow-back'></i>

            Volver

        </a>

    </div>

    <!-- ERRORS -->

    @if($errors->any())

        <div class="doc-error-box">

            <div class="doc-error-title">

                <i class='bx bx-error-circle'></i>

                Revisa los siguientes campos

            </div>

            <ul>

                @foreach($errors->all() as $e)

                    <li>{{ $e }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <!-- FORM -->

    <form action="{{ route('admin.documents.store') }}"
          method="POST"

          class="doc-layout">

        @csrf

        <!-- LEFT -->

        <div class="doc-main-column">

            <!-- INFO -->

            <div class="doc-card">

                <div class="doc-section-title">

                    <i class='bx bx-file'></i>

                    <span>
                        Información del documento
                    </span>

                </div>

                <!-- NUMBER -->

                <div class="doc-group">

                    <label>
                        Número de documento
                    </label>

                    <input type="text"
                           name="number"

                           class="doc-input"

                           placeholder="Ej: POA-2026"

                           value="{{ old('number') }}">

                </div>

                <!-- TITLE -->

                <div class="doc-group">

                    <label>
                        Título principal
                    </label>

                    <input type="text"
                           name="title"

                           id="docTitle"

                           class="doc-input"

                           placeholder="Ej: Plan Operativo Anual 2026"

                           value="{{ old('title') }}"

                           required>

                </div>

                <!-- DESCRIPTION -->

                <div class="doc-group">

                    <label>
                        Descripción
                    </label>

                    <textarea name="description"
                              id="docDescription"

                              class="doc-textarea"

                              placeholder="Describe brevemente el contenido del documento...">{{ old('description') }}</textarea>

                </div>

            </div>

            <!-- TYPE -->

            <div class="doc-card">

                <div class="doc-section-title">

                    <i class='bx bx-category'></i>

                    <span>
                        Clasificación
                    </span>

                </div>

                <div class="doc-group">

                    <label>
                        Tipo de documento
                    </label>

                    <select name="type"
                            id="docType"

                            class="doc-input"

                            required>

                        <option value="">
                            Selecciona una categoría
                        </option>

                        <option value="rendicion"
                            {{ old('type') == 'rendicion' ? 'selected' : '' }}>

                            Rendición de cuentas

                        </option>

                        <option value="poa"
                            {{ old('type') == 'poa' ? 'selected' : '' }}>

                            Plan Operativo Anual (POA)

                        </option>

                        <option value="pei"
                            {{ old('type') == 'pei' ? 'selected' : '' }}>

                            Plan Estratégico Institucional (PEI)

                        </option>

                    </select>

                </div>

            </div>

            <!-- URL -->

            <div class="doc-card">

                <div class="doc-section-title">

                    <i class='bx bx-link'></i>

                    <span>
                        Enlace del documento
                    </span>

                </div>

                <div class="doc-group">

                    <label>
                        URL del PDF o Drive
                    </label>

                    <input type="url"
                           name="file_url"

                           id="docUrl"

                           class="doc-input"

                           placeholder="https://drive.google.com/..."

                           value="{{ old('file_url') }}"

                           required>

                    <small class="doc-help-text">

                        Compatible con Google Drive,
                        OneDrive, Dropbox o PDFs directos.

                    </small>

                </div>

                <!-- DETECTION -->

                <div class="doc-url-detect"
                     id="urlDetectBox">

                    <i class='bx bx-globe'></i>

                    <span id="urlDetectText">

                        Esperando enlace...

                    </span>

                </div>

            </div>

        </div>

        <!-- RIGHT -->

        <div class="doc-sidebar">

            <!-- PREVIEW -->

            <div class="doc-preview-card">

                <div class="doc-preview-header">

                    <span>
                        Vista previa
                    </span>

                    <div class="doc-live-dot"></div>

                </div>

                <div class="doc-preview-body">

                    <div class="doc-preview-icon"
                         id="previewIcon">

                        <i class='bx bx-file'></i>

                    </div>

                    <div class="doc-preview-content">

                        <span class="doc-preview-badge"
                              id="previewType">

                            Documento

                        </span>

                        <h3 id="previewTitle">

                            Documento institucional

                        </h3>

                        <p id="previewDescription">

                            La descripción del documento
                            aparecerá aquí.

                        </p>

                    </div>

                </div>

            </div>

            <!-- PUBLIC -->

            <div class="doc-side-card">

                <h3>
                    Publicación
                </h3>

                <div class="doc-switch-group">

                    <label class="doc-switch">

                        <input type="checkbox"
                               name="is_public"

                               value="1"

                               {{ old('is_public', 1) ? 'checked' : '' }}>

                        <span class="doc-slider"></span>

                    </label>

                    <div>

                        <strong>
                            Visible públicamente
                        </strong>

                        <p>
                            El documento será visible
                            en el portal institucional.
                        </p>

                    </div>

                </div>

            </div>

            <!-- TIPS -->

            <div class="doc-side-card">

                <h3>
                    Recomendaciones
                </h3>

                <ul class="doc-tips">

                    <li>

                        <i class='bx bx-check-shield'></i>

                        Verifica que el enlace sea público.

                    </li>

                    <li>

                        <i class='bx bx-link-external'></i>

                        Usa títulos claros y oficiales.

                    </li>

                    <li>

                        <i class='bx bx-file'></i>

                        Mantén organizada la documentación.

                    </li>

                </ul>

            </div>

            <!-- ACTIONS -->

            <div class="doc-actions-box">

                <button type="submit"
                        class="doc-save-btn">

                    <i class='bx bx-save'></i>

                    Publicar documento

                </button>

            </div>

        </div>

    </form>

</div>

@endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', () => {

    // ========================================
    // PREVIEW
    // ========================================

    const title =
        document.getElementById('docTitle');

    const description =
        document.getElementById('docDescription');

    const type =
        document.getElementById('docType');

    const url =
        document.getElementById('docUrl');

    const previewTitle =
        document.getElementById('previewTitle');

    const previewDescription =
        document.getElementById('previewDescription');

    const previewType =
        document.getElementById('previewType');

    const previewIcon =
        document.getElementById('previewIcon');

    const detectText =
        document.getElementById('urlDetectText');

    // TITLE

    title.addEventListener('input', () => {

        previewTitle.textContent =
            title.value || 'Documento institucional';

    });

    // DESCRIPTION

    description.addEventListener('input', () => {

        previewDescription.textContent =
            description.value ||
            'La descripción del documento aparecerá aquí.';

    });

    // TYPE

    type.addEventListener('change', () => {

        switch(type.value){

            case 'poa':

                previewType.textContent =
                    'POA';

            break;

            case 'pei':

                previewType.textContent =
                    'PEI';

            break;

            case 'rendicion':

                previewType.textContent =
                    'Rendición';

            break;

            default:

                previewType.textContent =
                    'Documento';

        }

    });

    // URL DETECT

    url.addEventListener('input', () => {

        const value = url.value;

        if(value.includes('drive.google')){

            detectText.textContent =
                'Google Drive detectado';

            previewIcon.innerHTML =
                "<i class='bx bxl-google'></i>";

        }

        else if(value.includes('.pdf')){

            detectText.textContent =
                'Documento PDF detectado';

            previewIcon.innerHTML =
                "<i class='bx bxs-file-pdf'></i>";

        }

        else if(value.includes('onedrive')){

            detectText.textContent =
                'OneDrive detectado';

            previewIcon.innerHTML =
                "<i class='bx bxl-microsoft'></i>";

        }

        else{

            detectText.textContent =
                'Enlace externo detectado';

            previewIcon.innerHTML =
                "<i class='bx bx-link-external'></i>";

        }

    });

});

</script>

@endpush