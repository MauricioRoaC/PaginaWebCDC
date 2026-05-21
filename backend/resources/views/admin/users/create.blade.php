@extends('layouts.admin')

@section('content')

<div class="create-user-page">

    <!-- HEADER -->

    <div class="create-user-header">

        <div class="d-flex align-items-start gap-3">

            <a href="{{ route('admin.users.index') }}" class="back-btn">
                <i class='bx bx-arrow-back'></i>
            </a>

            <div>
                <h1 class="create-user-title">
                    Crear usuario
                </h1>

                <p class="create-user-subtitle">
                    Completa los datos para registrar un nuevo usuario en el sistema.
                </p>
            </div>

        </div>

        <div class="info-box">
            <i class='bx bx-shield-quarter'></i>

            <div>
                <h6>Información</h6>
                <p>
                    Todos los campos son obligatorios para crear el usuario.
                </p>
            </div>
        </div>

    </div>

    <!-- ERRORES -->

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

    <form action="{{ route('admin.users.store') }}"
          method="POST"
          class="create-user-card">

        @csrf

        <div class="row g-4">

            <!-- NOMBRE -->

            <div class="col-lg-6">

                <div class="modern-group">

                    <label class="modern-label">
                        <i class='bx bx-user'></i>
                        Nombre completo
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="modern-input"
                        placeholder="Ej: Juan Carlos Pérez"
                        value="{{ old('name') }}"
                        required
                    >

                </div>

            </div>

            <!-- EMAIL -->

            <div class="col-lg-6">

                <div class="modern-group">

                    <label class="modern-label">
                        <i class='bx bx-envelope'></i>
                        Correo institucional
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="modern-input"
                        placeholder="Ej: juan.perez@policia.gob"
                        value="{{ old('email') }}"
                        required
                    >

                </div>

            </div>

            <!-- PASSWORD -->

            <div class="col-lg-6">

                <div class="modern-group">

                    <label class="modern-label">
                        <i class='bx bx-lock-alt'></i>
                        Contraseña
                    </label>

                    <div class="password-wrapper">

                        <input
                            type="password"
                            name="password"
                            class="modern-input password-input"
                            placeholder="Ingresa la contraseña"
                            required
                        >

                        <button type="button" class="toggle-password">
                            <i class='bx bx-show'></i>
                        </button>

                    </div>

                </div>

            </div>

            <!-- CONFIRMAR -->

            <div class="col-lg-6">

                <div class="modern-group">

                    <label class="modern-label">
                        <i class='bx bx-lock'></i>
                        Confirmar contraseña
                    </label>

                    <div class="password-wrapper">

                        <input
                            type="password"
                            name="password_confirmation"
                            class="modern-input password-input"
                            placeholder="Repite la contraseña"
                            required
                        >

                        <button type="button" class="toggle-password">
                            <i class='bx bx-show'></i>
                        </button>

                    </div>

                </div>

            </div>

            <!-- ROL -->

            <div class="col-lg-6">

                <div class="modern-group">

                    <label class="modern-label">
                        <i class='bx bx-shield'></i>
                        Rol
                    </label>

                    <select name="role"
                            class="modern-input modern-select"
                            required>

                        <option value="">
                            Seleccionar rol
                        </option>

                        <option value="admin"
                            {{ old('role') === 'admin' ? 'selected' : '' }}>
                            Admin
                        </option>

                        <option value="superadmin"
                            {{ old('role') === 'superadmin' ? 'selected' : '' }}>
                            Superadmin
                        </option>

                    </select>

                </div>

            </div>

            <!-- UNIDAD -->

            <div class="col-lg-6">

                <div class="modern-group">

                    <label class="modern-label">
                        <i class='bx bx-buildings'></i>
                        Unidad
                    </label>

                    <select name="unit_id"
                            class="modern-input modern-select"
                            required>

                        <option value="">
                            Seleccionar unidad
                        </option>

                        @foreach($units as $unit)

                            <option value="{{ $unit->id }}"
                                {{ old('unit_id') == $unit->id ? 'selected' : '' }}>

                                {{ $unit->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

        </div>

        <!-- FOOTER -->

        <div class="create-user-footer">

            <div class="security-message">

                <i class='bx bx-info-circle'></i>

                <div>
                    <h6>Importante</h6>

                    <p>
                        El usuario podrá acceder al sistema según el rol y la unidad asignada.
                    </p>
                </div>

            </div>

            <div class="footer-actions">

                <a href="{{ route('admin.users.index') }}"
                   class="cancel-btn">

                    <i class='bx bx-x'></i>
                    Cancelar

                </a>

                <button type="submit" class="modern-btn">

                    <i class='bx bx-save'></i>
                    Guardar usuario

                </button>

            </div>

        </div>

    </form>

</div>

@endsection
