@extends('layouts.admin')

@section('content')

<div class="live-create-page">

    <!-- HEADER -->

    <div class="live-create-header">

        <div class="d-flex align-items-start gap-3">

            <a href="{{ route('admin.lives.index') }}"
               class="live-back-btn">

                <i class='bx bx-arrow-back'></i>

            </a>

            <div>

                <h1 class="live-create-title">
                    Nuevo Live
                </h1>

                <p class="live-create-subtitle">
                    Configura una nueva transmisión institucional.
                </p>

            </div>

        </div>

        <!-- STATUS -->

        <div class="live-editor-status">

            <div class="status-dot live-dot"></div>

            <span>
                Configuración activa
            </span>

        </div>

    </div>

    <!-- ERRORS -->

    @if($errors->any())

        <div class="modern-alert danger-alert">

            <div class="modern-alert-icon">
                <i class='bx bx-error-circle'></i>
            </div>

            <div>

                <h6>
                    Ocurrió un error
                </h6>

                <ul class="mb-0">

                    @foreach($errors->all() as $e)

                        <li>{{ $e }}</li>

                    @endforeach

                </ul>

            </div>

        </div>

    @endif

    <!-- FORM -->

    <form method="POST"
          action="{{ route('admin.lives.store') }}"
          id="liveForm">

        @csrf

        <div class="row g-4">

            <!-- LEFT -->

            <div class="col-xl-8">

                <div class="live-editor-card">

                    <!-- TITLE -->

                    <div class="modern-group">

                        <label class="modern-label">

                            <i class='bx bx-video'></i>

                            Título del live

                        </label>

                        <input type="text"
                               name="title"
                               class="modern-input"
                               placeholder="Ej: Operativo zona sur..."
                               maxlength="255"
                               required>

                    </div>

                    <!-- URL -->

                    <div class="modern-group mt-4">

                        <div class="d-flex justify-content-between align-items-center mb-2">

                            <label class="modern-label mb-0">

                                <i class='bx bx-link'></i>

                                Embed o link

                            </label>

                            <!-- PLATFORM -->

                            <div id="platformBadge"
                                 class="platform-preview generic">

                                <i class='bx bx-wifi'></i>

                                Sin detectar

                            </div>

                        </div>

                        <textarea name="embed_url"
                                  id="embedInput"
                                  class="modern-textarea"
                                  rows="6"
                                  placeholder="Pega aquí el iframe o enlace del live..."
                                  required></textarea>

                    </div>

                    <!-- PREVIEW -->

                    <div class="modern-group mt-4">

                        <label class="modern-label">

                            <i class='bx bx-show'></i>

                            Vista previa

                        </label>

                        <div class="live-preview-area"
                             id="livePreview">

                            <div class="preview-placeholder">

                                <i class='bx bx-broadcast'></i>

                                <p>
                                    El preview del live aparecerá aquí
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- RIGHT -->

            <div class="col-xl-4">

                <!-- INFO -->

                <div class="side-card">

                    <div class="side-card-header">

                        <h5>
                            Estado del live
                        </h5>

                    </div>

                    <div class="live-status-box">

                        <div class="live-status-icon">

                            <i class='bx bx-radio-circle-marked'></i>

                        </div>

                        <div>

                            <h6>
                                Activación automática
                            </h6>

                            <p>
                                El nuevo live se publicará automáticamente
                                y desactivará el anterior.
                            </p>

                        </div>

                    </div>

                </div>

                <!-- SUPPORTED -->

                <div class="side-card mt-4">

                    <div class="side-card-header">

                        <h5>
                            Plataformas soportadas
                        </h5>

                    </div>

                    <div class="supported-platforms">

                        <div class="supported-item youtube">

                            <i class='bx bxl-youtube'></i>

                            <span>YouTube Live</span>

                        </div>

                        <div class="supported-item facebook">

                            <i class='bx bxl-facebook-circle'></i>

                            <span>Facebook Live</span>

                        </div>

                        <div class="supported-item tiktok">

                            <i class='bx bxl-tiktok'></i>

                            <span>TikTok Live</span>

                        </div>

                    </div>

                </div>

                <!-- TIPS -->

                <div class="side-card mt-4">

                    <div class="side-card-header">

                        <h5>
                            Recomendaciones
                        </h5>

                    </div>

                    <div class="editor-tips">

                        <div class="tip-item">

                            <i class='bx bx-check-circle'></i>

                            <span>
                                Usa títulos claros y descriptivos.
                            </span>

                        </div>

                        <div class="tip-item">

                            <i class='bx bx-check-circle'></i>

                            <span>
                                Verifica que el live esté público.
                            </span>

                        </div>

                        <div class="tip-item">

                            <i class='bx bx-check-circle'></i>

                            <span>
                                Evita enlaces rotos o privados.
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- FOOTER -->

        <div class="editor-footer">

            <a href="{{ route('admin.lives.index') }}"
               class="cancel-btn">

                <i class='bx bx-x'></i>

                Cancelar

            </a>

            <button type="submit"
                    class="modern-btn">

                <i class='bx bx-broadcast'></i>

                Publicar live

            </button>

        </div>

    </form>

</div>

@endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function(){

    const embedInput =
        document.getElementById('embedInput');

    const platformBadge =
        document.getElementById('platformBadge');

    const livePreview =
        document.getElementById('livePreview');

    function detectPlatform(value){

        const content = value.toLowerCase();

        // YOUTUBE

        if(content.includes('youtube')){

            platformBadge.className =
                'platform-preview youtube';

            platformBadge.innerHTML = `
                <i class='bx bxl-youtube'></i>
                YouTube Live
            `;

        }

        // FACEBOOK

        else if(content.includes('facebook')){

            platformBadge.className =
                'platform-preview facebook';

            platformBadge.innerHTML = `
                <i class='bx bxl-facebook-circle'></i>
                Facebook Live
            `;

        }

        // TIKTOK

        else if(content.includes('tiktok')){

            platformBadge.className =
                'platform-preview tiktok';

            platformBadge.innerHTML = `
                <i class='bx bxl-tiktok'></i>
                TikTok Live
            `;

        }

        // GENERIC

        else{

            platformBadge.className =
                'platform-preview generic';

            platformBadge.innerHTML = `
                <i class='bx bx-wifi'></i>
                Sin detectar
            `;

        }

    }

    function updatePreview(value){

        if(value.trim() === ''){

            livePreview.innerHTML = `

                <div class="preview-placeholder">

                    <i class='bx bx-broadcast'></i>

                    <p>
                        El preview del live aparecerá aquí
                    </p>

                </div>

            `;

            return;
        }

        // IFRAME

        if(value.includes('<iframe')){

            livePreview.innerHTML = value;

        }

        // LINK

        else{

            livePreview.innerHTML = `

                <div class="link-preview">

                    <i class='bx bx-link-external'></i>

                    <span>
                        Preview disponible al publicar
                    </span>

                </div>

            `;

        }

    }

    embedInput.addEventListener('input', function(){

        detectPlatform(this.value);

        updatePreview(this.value);

    });

});

</script>

@endpush