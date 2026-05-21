@extends('layouts.admin')

@section('content')
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css"/>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
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
                                       name="avatar"
                                       class="modern-file">

                                <small>
                                    PNG, JPG o GIF. Máx. 2MB
                                </small>

                            </div>
                            <div class="crop-container mt-3">

    <img id="imageCropper"
         style="max-width:100%; display:none;">

</div>

                            @if($user->avatar)

                                <div class="current-avatar">

    <img id="avatarPreview"
         src="{{ asset('storage/'.$user->avatar) }}"
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

let cropper;

const input = document.querySelector('.modern-file');
const image = document.getElementById('imageCropper');

input.addEventListener('change', (e) => {

    const file = e.target.files[0];

    if (!file) return;

    const reader = new FileReader();

    reader.onload = () => {

        image.src = reader.result;
        image.style.display = 'block';

        if (cropper) {
            cropper.destroy();
        }

        cropper = new Cropper(image, {

            aspectRatio: 1,
            viewMode: 1,

            dragMode: 'move',

            guides: false,
            center: false,

            cropBoxMovable: false,
            cropBoxResizable: false,

            background: false,

            responsive: true,

            zoomable: true,
            scalable: true,
            movable: true,

        });

    };

    reader.readAsDataURL(file);

});

</script>

@endpush