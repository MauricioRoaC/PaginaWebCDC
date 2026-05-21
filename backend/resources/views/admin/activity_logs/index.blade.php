@extends('layouts.admin')

@section('content')

<div class="activity-page">

    <!-- ========================================
        HEADER
    ========================================= -->

    <div class="activity-header">

        <div>

            <div class="activity-badge">
                Centro de monitoreo institucional
            </div>

            <h1>
                Historial de actividad
            </h1>

            <p>
                Supervisa acciones realizadas dentro
                del sistema administrativo en tiempo real.
            </p>

        </div>

        <div class="activity-header-status">

            <div class="activity-status-dot"></div>

            Sistema activo

        </div>

    </div>

    <!-- ========================================
        FILTERS
    ========================================= -->

    <form method="GET"
          class="activity-filter-bar">

        <!-- SEARCH -->

        <div class="activity-search-box">

            <i class='bx bx-search'></i>

            <input type="text"
                   name="search"

                   placeholder="Buscar administrador..."

                   value="{{ request('search') }}">

        </div>

        <!-- MODULE -->

        <div class="activity-select-box">

            <i class='bx bx-grid-alt'></i>

            <select name="module">

                <option value="">
                    Todos los módulos
                </option>

                <option value="users"
                    {{ request('module') == 'users' ? 'selected' : '' }}>
                    Usuarios
                </option>

                <option value="news"
                    {{ request('module') == 'news' ? 'selected' : '' }}>
                    Noticias
                </option>

                <option value="events"
                    {{ request('module') == 'events' ? 'selected' : '' }}>
                    Eventos
                </option>

                <option value="contacts"
                    {{ request('module') == 'contacts' ? 'selected' : '' }}>
                    Contactos
                </option>

            </select>

        </div>

        <!-- BUTTON -->

        <button class="activity-filter-btn">

            <i class='bx bx-filter-alt'></i>

            Filtrar

        </button>

    </form>

    <!-- ========================================
        STATS
    ========================================= -->

    <div class="activity-stats-grid">

        <!-- TOTAL -->

        <div class="activity-stat-card">

            <div class="activity-stat-icon total">

                <i class='bx bx-history'></i>

            </div>

            <div>

                <strong>
                    {{ $logs->total() }}
                </strong>

                <span>
                    Registros totales
                </span>

            </div>

        </div>

        <!-- TODAY -->

        <div class="activity-stat-card">

            <div class="activity-stat-icon success">

                <i class='bx bx-check-circle'></i>

            </div>

            <div>

                <strong>
                    {{ $logs->where('created_at', '>=', now()->startOfDay())->count() }}
                </strong>

                <span>
                    Acciones hoy
                </span>

            </div>

        </div>

        <!-- MODULE -->

        <div class="activity-stat-card">

            <div class="activity-stat-icon module">

                <i class='bx bx-layer'></i>

            </div>

            <div>

                <strong>
                    {{ request('module') ?: 'Todos' }}
                </strong>

                <span>
                    Módulo filtrado
                </span>

            </div>

        </div>

    </div>

    <!-- ========================================
        TABLE
    ========================================= -->

    <div class="activity-table-wrapper">

        <div class="activity-table-header">

            <div>

                <h3>
                    Registro de acciones
                </h3>

                <p>
                    Actividad reciente del panel administrativo.
                </p>

            </div>

        </div>

        <div class="table-responsive">

            <table class="activity-table">

                <thead>

                    <tr>

                        <th>
                            Usuario
                        </th>

                        <th>
                            Acción
                        </th>

                        <th>
                            Módulo
                        </th>

                        <th>
                            Descripción
                        </th>

                        <th>
                            Fecha
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($logs as $log)

                        <tr>

                            <!-- USER -->

                            <td>

                                <div class="activity-user">

                                    <div class="activity-user-avatar">

                                        {{ strtoupper(substr($log->user->name ?? 'S', 0, 1)) }}

                                    </div>

                                    <div>

                                        <strong>
                                            {{ $log->user->name ?? 'Sistema' }}
                                        </strong>

                                        <span>
                                            Administrador
                                        </span>

                                    </div>

                                </div>

                            </td>

                            <!-- ACTION -->

                            <td>

                                @php

                                    $actionClass = match($log->action){

                                        'create' => 'success',
                                        'update' => 'warning',
                                        'delete' => 'danger',
                                        default => 'default'

                                    };

                                @endphp

                                <div class="activity-action {{ $actionClass }}">

                                    @if($log->action === 'create')

                                        <i class='bx bx-plus-circle'></i>

                                    @elseif($log->action === 'update')

                                        <i class='bx bx-edit'></i>

                                    @elseif($log->action === 'delete')

                                        <i class='bx bx-trash'></i>

                                    @else

                                        <i class='bx bx-history'></i>

                                    @endif

                                    {{ ucfirst($log->action) }}

                                </div>

                            </td>

                            <!-- MODULE -->

                            <td>

                                <div class="activity-module">

                                    {{ ucfirst($log->module) }}

                                </div>

                            </td>

                            <!-- DESCRIPTION -->

                            <td>

                                <div class="activity-description">

                                    {{ $log->description }}

                                </div>

                            </td>

                            <!-- DATE -->

                            <td>

                                <div class="activity-date">

                                    <strong>

                                        {{ $log->created_at->format('d/m/Y') }}

                                    </strong>

                                    <span>

                                        {{ $log->created_at->format('H:i') }}

                                    </span>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5">

                                <div class="activity-empty">

                                    <div class="activity-empty-icon">

                                        <i class='bx bx-history'></i>

                                    </div>

                                    <h3>
                                        No hay registros disponibles
                                    </h3>

                                    <p>
                                        No se encontraron actividades
                                        para los filtros seleccionados.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <!-- ========================================
        PAGINATION
    ========================================= -->

    <div class="activity-pagination">

        {{ $logs->onEachSide(1)->links() }}

    </div>

</div>

@endsection