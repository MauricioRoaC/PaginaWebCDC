@extends('layouts.admin')

@section('content')

<div class="users-page">

    <!-- HEADER -->

    <div class="users-header">
        <div>
            <h1 class="users-title">Usuarios del panel</h1>
            <p class="users-subtitle">
                Gestiona las cuentas de acceso del sistema.
            </p>
        </div>

        <a href="{{ route('admin.users.create') }}" class="modern-btn">
            <i class='bx bx-plus'></i>
            Nuevo usuario
        </a>
    </div>

    <!-- STATS -->

    <div class="row g-4 mb-4">

        <div class="col-md-6 col-xl-3">
            <div class="dashboard-card">
                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>
                        <div class="card-title">
                            Total usuarios
                        </div>

                        <div class="card-value">
                            {{ $users->count() }}
                        </div>
                    </div>

                    <div class="dashboard-icon">
                        <i class='bx bx-user'></i>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="dashboard-card">
                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>
                        <div class="card-title">
                            Usuarios activos
                        </div>

                        <div class="card-value">
                            {{ $users->where('is_active', true)->count() }}
                        </div>
                    </div>

                    <div class="dashboard-icon">
                        <i class='bx bx-check-circle'></i>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <!-- FILTROS -->

  <form method="GET" class="users-filters">

    <div class="search-box">

        <i class='bx bx-search'></i>

        <input
            type="text"
            name="search"
            placeholder="Buscar usuario..."
            value="{{ request('search') }}"
        >

    </div>

    <select
        name="role"
        class="modern-select"
    >

        <option value="">
            Todos los roles
        </option>

        <option
            value="admin"
            {{ request('role') == 'admin' ? 'selected' : '' }}
        >
            Admin
        </option>

        <option
            value="superadmin"
            {{ request('role') == 'superadmin' ? 'selected' : '' }}
        >
            Superadmin
        </option>

    </select>

    <button
        type="submit"
        class="btn btn-primary"
    >
        Filtrar
    </button>

</form>

    <!-- TABLA -->

    <div class="modern-table">

        <table class="table align-middle mb-0">

            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>

            @foreach($users as $user)

                <tr>

                    <td>
                        <div class="user-cell">

                            <div class="user-avatar">
                                {{ strtoupper(substr($user->name,0,1)) }}
                            </div>

                            <div>
                                <div class="user-name">
                                    {{ $user->name }}
                                </div>

                                <div class="user-role-small">
                                    Usuario del sistema
                                </div>
                            </div>

                        </div>
                    </td>

                    <td>
                        {{ $user->email }}
                    </td>

                    <td>

                        @if($user->role === 'superadmin')

                            <span class="modern-badge danger">
                                Superadmin
                            </span>

                        @else

                            <span class="modern-badge gray">
                                Admin
                            </span>

                        @endif

                    </td>

                    <td>

                        @if($user->is_active)

                            <span class="modern-badge success">
                                Activo
                            </span>

                        @else

                            <span class="modern-badge gray">
                                Inactivo
                            </span>

                        @endif

                    </td>

                    <td>

                        <div class="table-actions">

                            <a href="{{ route('admin.users.edit', $user) }}"
                               class="action-btn warning">

                                <i class='bx bx-pencil'></i>

                            </a>

                            @if($user->id !== auth()->id())

                            <form action="{{ route('admin.users.destroy', $user) }}"
                                  method="POST"
                                  onsubmit="return confirm('¿Eliminar este usuario?');">

                                @csrf
                                @method('DELETE')

                                <button class="action-btn danger">
                                    <i class='bx bx-trash'></i>
                                </button>

                            </form>

                            @endif

                        </div>

                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection
