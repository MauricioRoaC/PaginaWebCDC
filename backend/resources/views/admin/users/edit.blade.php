@extends('layouts.admin')

@section('content')

<div class="edit-user-page">

    <!-- HEADER -->

    <div class="edit-user-header">

        <div class="d-flex align-items-start gap-3">

            <a href="{{ route('admin.users.index') }}" class="back-btn">
                <i class='bx bx-arrow-back'></i>
            </a>

            <div>

                <h1 class="edit-user-title">
                    Editar usuario
                </h1>

                <p class="edit-user-subtitle">
                    Actualiza la información y permisos del usuario en el sistema.
                </p>

            </div>

        </div>

        <!-- STATUS CARD -->

        <div class="status-card">

            <div class="status-icon">
                <i class='bx bx-user-check'></i>
            </div>

            <div>

                <span class="status-label">
                    Estado actual
                </span>

                @if($user->is_active)

                    <h6 class="status-active">
                        ● Usuario activo
                    </h6>

                @else

                    <h6 class="status-inactive">
                        ● Usuario inactivo
                    </h6>

                @endif

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

    <form action="{{ route('admin.users.update', $user) }}"
          method="POST"
          class="edit-user-card">

        @csrf
        @method('PUT')

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
                        value="{{ old('name', $user->name) }}"
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
                        value="{{ old('email', $user->email) }}"
                        required
                    >

                </div>

            </div>

            <!-- PASSWORD -->

            <div class="col-lg-6">

                <div class="modern-group">

                    <label class="modern-label">
                        <i class='bx bx-lock-alt'></i>
                        Nueva contraseña
                    </label>

                    <div class="password-wrapper">

                        <input
                            type="password"
                            name="password"
                            class="modern-input"
                            placeholder="Déjalo vacío si no cambiará"
                        >

                        <button type="button" class="toggle-password">
                            <i class='bx bx-show'></i>
                        </button>

                    </div>

                    <small class="input-helper">
                        Solo completa este campo si deseas cambiar la contraseña.
                    </small>

                </div>

            </div>

            <!-- CONFIRMAR PASSWORD -->

            <div class="col-lg-6">

                <div class="modern-group">

                    <label class="modern-label">
                        <i class='bx bx-lock'></i>
                        Confirmar nueva contraseña
                    </label>

                    <div class="password-wrapper">

                        <input
                            type="password"
                            name="password_confirmation"
                            class="modern-input"
                            placeholder="Repite la nueva contraseña"
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

                        <option value="admin"
                            {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>

                            Admin

                        </option>

                        <option value="superadmin"
                            {{ old('role', $user->role) === 'superadmin' ? 'selected' : '' }}>

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

                        @foreach($units as $unit)

                            <option value="{{ $unit->id }}"
                                {{ old('unit_id', $user->unit_id) == $unit->id ? 'selected' : '' }}>

                                {{ $unit->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

        </div>

        <!-- STATUS SWITCH -->

        <div class="user-status-section">

            <div>

                <h5>
                    Estado del usuario
                </h5>

                <p>
                    Activa o desactiva el acceso de este usuario al sistema.
                </p>

            </div>

            <div class="switch-wrapper">

                <span class="switch-text">
                    Inactivo
                </span>

                <label class="modern-switch">

                    <input
                        type="checkbox"
                        name="is_active"
                        {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                    >

                    <span class="slider"></span>

                </label>

                <span class="switch-text active">
                    Activo
                </span>

            </div>

        </div>

        <!-- FOOTER -->

        <div class="edit-user-footer">

            <a href="{{ route('admin.users.index') }}"
               class="cancel-btn">

                <i class='bx bx-x'></i>
                Cancelar

            </a>

            <button type="submit" class="modern-btn">

                <i class='bx bx-save'></i>
                Actualizar usuario

            </button>

        </div>

    </form>

</div>

@endsection