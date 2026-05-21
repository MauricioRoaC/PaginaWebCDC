@extends('layouts.admin')

@section('content')

<div class="units-page">

    <!-- HEADER -->

    <div class="units-header">

        <div>
            <h1 class="units-title">
                Unidades
            </h1>

            <p class="units-subtitle">
                Gestiona las unidades policiales registradas en el sistema.
            </p>
        </div>

        <a href="{{ route('admin.units.create') }}" class="modern-btn">
            <i class='bx bx-plus'></i>
            Crear unidad
        </a>

    </div>

    <!-- STATS -->

    <div class="row g-4 mb-4">

        <div class="col-md-6 col-xl-3">

            <div class="dashboard-card">

                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>

                        <div class="card-title">
                            Total unidades
                        </div>

                        <div class="card-value">
                            {{ $units->count() }}
                        </div>

                    </div>

                    <div class="dashboard-icon">
                        <i class='bx bx-buildings'></i>
                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-6 col-xl-3">

            <div class="dashboard-card">

                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>

                        <div class="card-title">
                            Usuarios asignados
                        </div>

                        <div class="card-value">
                            {{ \App\Models\User::count() }}
                        </div>

                    </div>

                    <div class="dashboard-icon">
                        <i class='bx bx-group'></i>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- CONTENT -->

    <div class="row g-4">

        <!-- TABLE -->

        <div class="col-xl-8">

            <div class="modern-table">

                <div class="table-header">

                    <h5>
                        Listado de unidades
                    </h5>

                    <form method="GET" class="units-filters">

    <div class="search-box small-search">

        <i class='bx bx-search'></i>

        <input
            type="text"
            name="search"
            placeholder="Buscar unidad..."
            value="{{ request('search') }}"
        >

    </div>

</form>
                </div>

                <table class="table align-middle mb-0">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Unidad</th>
                            <th>Usuarios</th>
                            <th>Acciones</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($units as $unit)

                        <tr>

                            <td>
                                #{{ $unit->id }}
                            </td>

                            <td>

                                <div class="unit-cell">

                                    <div class="unit-icon">
                                        <i class='bx bx-buildings'></i>
                                    </div>

                                    <div>

                                        <div class="unit-name">
                                            {{ $unit->name }}
                                        </div>

                                        <div class="unit-description">
                                            Unidad policial registrada
                                        </div>

                                    </div>

                                </div>

                            </td>

                            <td>

                                <span class="modern-badge gray">
                                    {{ $unit->users->count() ?? 0 }} usuarios
                                </span>

                            </td>

                            <td>

                                <div class="table-actions">

                                    <a href="{{ route('admin.units.edit', $unit) }}"
                                       class="action-btn warning">

                                        <i class='bx bx-pencil'></i>

                                    </a>

                                    <form action="{{ route('admin.units.destroy', $unit) }}"
                                          method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button class="action-btn danger">
                                            <i class='bx bx-trash'></i>
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

        <!-- SIDEBAR -->

        <div class="col-xl-4">

            <div class="unit-info-card">

                <div class="info-card-icon">
                    <i class='bx bx-info-circle'></i>
                </div>

                <h5>
                    Información
                </h5>

                <p>
                    Las unidades permiten organizar a los usuarios dentro del comando departamental.
                </p>

            </div>

            <div class="recent-card">

                <h5>
                    Actividad reciente
                </h5>

                <div class="recent-item">

                    <div class="recent-dot"></div>

                    <div>

                        <strong>
                            Unidad creada
                        </strong>

                        <p>
                            Última actualización registrada.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection