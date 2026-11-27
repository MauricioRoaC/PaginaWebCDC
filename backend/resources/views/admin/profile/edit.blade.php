@extends('layouts.admin')

@section('content')

<div class="profile-page">

    {{-- HEADER --}}
    <div class="profile-header mb-4">

        <div>
            <h2 class="profile-title">
                Mi perfil
            </h2>

            <p class="profile-subtitle">
                Gestiona tu información personal
            </p>
        </div>

    </div>

    {{-- ALERTAS --}}
    @if(session('success'))
        <div class="alert alert-success modern-alert">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger modern-alert">
            <ul class="mb-0">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">

        {{-- COLUMNA IZQUIERDA --}}
        <div class="col-lg-7">

            <div class="profile-card">

                <div class="profile-card-header">
                    <h4>Información de perfil</h4>
                    <p>
                        Actualiza tu información personal y datos de contacto.
                    </p>
                </div>

                <form action="{{ route('admin.profile.update') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    {{-- NOMBRE --}}
                    <div class="modern-group">

                        <label class="modern-label">
                            <i class='bx bx-user'></i>
                            Nombre completo
                        </label>

                        <input type="text"
                               name="name"
                               class="modern-input"
                               value="{{ old('name', $user->name) }}"
                               required>

                    </div>

                    {{-- EMAIL --}}
                    <div class="modern-group">

                        <label class="modern-label">
                            <i class='bx bx-envelope'></i>
                            Correo electrónico
                        </label>

                        <input type="email"
                               name="email"
                               class="modern-input"
                               value="{{ old('email', $user->email) }}"
                               required>

                    </div>

                    {{-- FOTO --}}
                    <div class="modern-group">

                        <label class="modern-label">
                            <i class='bx bx-camera'></i>
                            Fotografía de perfil
                        </label>

                        <div class="avatar-upload">

                            <div class="upload-box">

                                <input type="file"
                                       name="avatar" id="avatarInput" accept="image/jpeg,image/png,image/webp"
                                       class="modern-file">

                                <small>
                                    PNG, JPG o WebP. Máx. 2MB
                                </small>

                            </div>
                            <div class="crop-container mt-3" id="avatarCrop" hidden style="max-width:100%; height:320px;">

    <img id="imageCropper"
         style="max-width:100%; display:none;">

</div>
<div id="cropControls" hidden class="mt-2">
<button type="button" class="btn btn-outline-secondary btn-sm" id="zoomOut">−</button>
<button type="button" class="btn btn-outline-secondary btn-sm" id="zoomIn">+</button>
<button type="button" class="btn btn-outline-secondary btn-sm" id="cancelCrop">Cancelar recorte</button>
<small class="d-block mt-2">Arrastra la foto y ajusta el zoom. El recorte se aplicará al guardar.</small>
</div>
<p id="cropStatus" role="status" class="small mt-2"></p>

                            @if($user->avatar)

                                <div class="current-avatar">

    <img id="avatarPreview"
         src="{{ \App\Services\PublicMedia::url($user->avatar) }}"
         alt="avatar">

    <button type="button"
            class="delete-avatar-btn">

        <i class='bx bx-trash'></i>

    </button>

</div>

                            @endif

                        </div>

                    </div>

                    <hr class="modern-divider">

                    {{-- PASSWORD --}}
                    <div class="password-section">

                        <h5>
                            <i class='bx bx-lock-alt'></i>
                            Cambiar contraseña (opcional)
                        </h5>

                        <p>
                            Deja los campos vacíos si no deseas cambiar tu contraseña.
                        </p>

                    </div>

                    {{-- PASSWORD --}}
                    <div class="modern-group">

                        <label class="modern-label">
                            Nueva contraseña
                        </label>

                        <input type="password"
                               name="password"
                               class="modern-input"
                               placeholder="Ingresa tu nueva contraseña">

                    </div>

                    {{-- CONFIRMAR --}}
                    <div class="modern-group">

                        <label class="modern-label">
                            Confirmar nueva contraseña
                        </label>

                        <input type="password"
                               name="password_confirmation"
                               class="modern-input"
                               placeholder="Confirma tu nueva contraseña">

                    </div>

                    <button type="submit" class="modern-btn">

                        <i class='bx bx-save'></i>
                        Guardar cambios

                    </button>

                </form>

            </div>

        </div>

        {{-- COLUMNA DERECHA --}}
        <div class="col-lg-5">

            <div class="profile-card">

                <div class="profile-card-header">
                    <h4>Información de la cuenta</h4>

                    <p>
                        Resumen de tu cuenta actual.
                    </p>
                </div>

                <div class="account-info">

                    <div class="account-item">

                        <div class="account-icon">
                            <i class='bx bx-user-circle'></i>
                        </div>

                        <div>
                            <span>Rol</span>
                            <strong>
                                {{ ucfirst($user->role) }}
                            </strong>
                        </div>

                    </div>

                    <div class="account-item">

                        <div class="account-icon">
                            <i class='bx bx-calendar'></i>
                        </div>

                        <div>
                            <span>Miembro desde</span>
                            <strong>
                                {{ $user->created_at->format('d \d\e F \d\e Y') }}
                            </strong>
                        </div>

                    </div>

                    <div class="account-item">

                        <div class="account-icon">
                            <i class='bx bx-shield'></i>
                        </div>

                        <div>
                            <span>Estado de la cuenta</span>
                            <strong class="text-success">
                                Activa
                            </strong>
                        </div>

                    </div>

                </div>

                <div class="security-box">

                    <i class='bx bx-check-shield'></i>

                    <div>
                        <h6>Consejo de seguridad</h6>

                        <p>
                            Mantén tu contraseña segura y actualízala periódicamente.
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
<script>
(() => {
    const input = document.getElementById('avatarInput');
    const image = document.getElementById('imageCropper');
    const area = document.getElementById('avatarCrop');
    const controls = document.getElementById('cropControls');
    const status = document.getElementById('cropStatus');
    const form = input.form;
    let cropper = null, url = null, ready = false, busy = false, prepared = false;
    function reset() {
        if (cropper) cropper.destroy();
        cropper = null; ready = false; prepared = false;
        image.removeAttribute('src');
        if (url) URL.revokeObjectURL(url);
        url = null; area.hidden = true; controls.hidden = true;
    }
    input.addEventListener('change', () => {
        reset(); status.textContent = '';
        const file = input.files[0];
        if (!file) return;
        if (!['image/jpeg','image/png','image/webp'].includes(file.type) || file.size > 2048 * 1024) {
            input.value = ''; status.textContent = 'Selecciona una imagen JPG, PNG o WebP de hasta 2 MB.'; return;
        }
        if (typeof Cropper !== 'function') {
            input.value = ''; status.textContent = 'No se pudo cargar el editor. Recarga la página.'; return;
        }
        area.hidden = false; controls.hidden = false;
        image.style.display = 'block';
        url = URL.createObjectURL(file);
        image.src = url;
        cropper = new Cropper(image, {
            aspectRatio: 1, viewMode: 1, dragMode: 'move',
            autoCropArea: 0.85, cropBoxMovable: true, cropBoxResizable: true,
            background: false, responsive: true, zoomable: true, movable: true,
            ready() { ready = true; }
        });
    });
    document.getElementById('zoomIn').onclick = () => { if (ready) cropper.zoom(0.1); };
    document.getElementById('zoomOut').onclick = () => { if (ready) cropper.zoom(-0.1); };
    document.getElementById('cancelCrop').onclick = () => { reset(); input.value = ''; status.textContent = ''; };
    form.addEventListener('submit', event => {
        if (prepared || !input.files.length) return;
        event.preventDefault();
        if (busy) return;
        if (!ready || !cropper) { status.textContent = 'Espera a que se cargue el editor.'; return; }
        busy = true;
        const submitter = event.submitter;
        try {
            const canvas = cropper.getCroppedCanvas({width:512,height:512,fillColor:'#fff',imageSmoothingQuality:'high'});
            if (!canvas) throw new Error('No canvas');
            canvas.toBlob(blob => {
                try {
                    if (!blob) throw new Error('No image');
                    const transfer = new DataTransfer();
                    transfer.items.add(new File([blob], 'avatar.jpg', {type:'image/jpeg'}));
                    input.files = transfer.files;
                    prepared = true;
                    form.requestSubmit(submitter || undefined);
                } catch (error) {
                    status.textContent = 'No se pudo preparar el recorte. Intenta nuevamente.';
                } finally { busy = false; }
            }, 'image/jpeg', 0.9);
        } catch (error) {
            busy = false; status.textContent = 'No se pudo recortar la imagen.';
        }
    });
})();
</script>
@endpush
