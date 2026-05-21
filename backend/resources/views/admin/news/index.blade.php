@extends('layouts.admin')

@section('content')

<div class="news-page">

    <!-- HEADER -->

    <div class="news-header">

        <div>

            <h1 class="news-title">
                Noticias
            </h1>

            <p class="news-subtitle">
                Gestiona y publica las noticias institucionales del sistema.
            </p>

        </div>

        <div class="news-header-actions">

            <!-- SEARCH -->

            <form method="GET" class="news-filters">

    <!-- SEARCH -->

    <div class="search-box">

        <i class='bx bx-search'></i>

        <input
            type="text"
            name="search"
            placeholder="Buscar noticias..."
            value="{{ request('search') }}"
        >

    </div>
</form>

            <!-- BUTTON -->

            <a href="{{ route('admin.news.create') }}" class="modern-btn">

                <i class='bx bx-plus'></i>
                Nueva noticia

            </a>

        </div>

    </div>

    <!-- STATS -->

    <div class="row g-4 mb-4">

        <!-- TOTAL -->

        <div class="col-md-6 col-xl-3">

            <div class="dashboard-card">

                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>

                        <div class="card-title">
                            Total noticias
                        </div>

                        <div class="card-value">
                            {{ $news->count() }}
                        </div>

                        <div class="card-description">
                            Noticias registradas
                        </div>

                    </div>

                    <div class="dashboard-icon">

                        <i class='bx bx-news'></i>

                    </div>

                </div>

            </div>

        </div>

        <!-- PUBLICADAS -->

        <div class="col-md-6 col-xl-3">

            <div class="dashboard-card">

                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>

                        <div class="card-title">
                            Publicadas
                        </div>

                        <div class="card-value">
                            {{ $news->where('is_published', true)->count() }}
                        </div>

                        <div class="card-description">
                            Visibles públicamente
                        </div>

                    </div>

                    <div class="dashboard-icon green">

                        <i class='bx bx-check-circle'></i>

                    </div>

                </div>

            </div>

        </div>

        <!-- IMÁGENES -->

        <div class="col-md-6 col-xl-3">

            <div class="dashboard-card">

                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>

                        <div class="card-title">
                            Galería
                        </div>

                        <div class="card-value">
                            {{ \App\Models\NewsImage::count() }}
                        </div>

                        <div class="card-description">
                            Imágenes almacenadas
                        </div>

                    </div>

                    <div class="dashboard-icon orange">

                        <i class='bx bx-image'></i>

                    </div>

                </div>

            </div>

        </div>

        <!-- RECIENTES -->

        <div class="col-md-6 col-xl-3">

            <div class="dashboard-card">

                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>

                        <div class="card-title">
                            Este mes
                        </div>

                        <div class="card-value">
                            {{ $news->where('created_at', '>=', now()->startOfMonth())->count() }}
                        </div>

                        <div class="card-description">
                            Noticias recientes
                        </div>

                    </div>

                    <div class="dashboard-icon purple">

                        <i class='bx bx-trending-up'></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- CONTENT -->

    <div class="row g-4">

        <!-- TABLE -->

        <div class="col-xl-9">

            <div class="modern-table">

                <!-- TABLE HEADER -->

                <div class="table-header">

                    <div>

                        <h5>
                            Listado de noticias
                        </h5>

                        <span>
                            Últimas noticias publicadas en el sistema.
                        </span>

                    </div>

                    <select class="modern-select-table">

                        <option>
                            Más recientes
                        </option>

                        <option>
                            Más antiguas
                        </option>

                    </select>

                </div>

                <!-- TABLE -->

                @if($news->count())

                    <div class="table-responsive">

                        <table class="table align-middle mb-0">

                            <thead>

                            <tr>

                                <th>
                                    Noticia
                                </th>

                                <th>
                                    Fecha
                                </th>

                                <th>
                                    Estado
                                </th>

                                <th>
                                    Acciones
                                </th>

                            </tr>

                            </thead>

                            <tbody>

                            @foreach($news as $item)

                                <tr>

                                    <!-- NEWS -->

                                    <td>

                                        <div class="news-item-cell">

                                            <!-- IMAGE -->

                                            <div class="news-thumb">

                                                @if($item->mainImage)

                                                    <img
                                                        src="{{ asset('storage/' . $item->mainImage->path) }}"
                                                        alt="{{ $item->title }}"
                                                    >

                                                @else

                                                    <div class="no-image">

                                                        <i class='bx bx-image'></i>

                                                    </div>

                                                @endif

                                            </div>

                                            <!-- INFO -->

                                            <div class="news-info">

                                                <h6>
                                                    {{ $item->title }}
                                                </h6>

                                                <p>
                                                    {{ Str::limit($item->description, 90) }}
                                                </p>

                                                <span class="news-slug">
                                                    slug: {{ $item->slug }}
                                                </span>

                                            </div>

                                        </div>

                                    </td>

                                    <!-- DATE -->

                                    <td>

                                        <div class="news-date">

                                            <i class='bx bx-calendar'></i>

                                            <span>
                                                {{ optional($item->published_at)->format('d/m/Y H:i') }}
                                            </span>

                                        </div>

                                    </td>

                                    <!-- STATUS -->

                                    <td>

                                        @if($item->is_published)

                                            <span class="modern-badge success">
                                                Publicada
                                            </span>

                                        @else

                                            <span class="modern-badge warning">
                                                Borrador
                                            </span>

                                        @endif

                                    </td>

                                    <!-- ACTIONS -->

                                    <td>

                                        <div class="table-actions">

                                            <!-- VIEW -->

                                            <a href="#"
                                               class="action-btn view">

                                                <i class='bx bx-show'></i>

                                            </a>

                                            <!-- EDIT -->

                                            <a href="{{ route('admin.news.edit', $item) }}"
                                               class="action-btn warning">

                                                <i class='bx bx-pencil'></i>

                                            </a>

                                            <!-- DELETE -->

                                            <form action="{{ route('admin.news.destroy', $item) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('¿Eliminar esta noticia?');">

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

                    <!-- PAGINATION -->

                    <div class="modern-pagination">

                        {{ $news->links() }}

                    </div>

                @else

                    <!-- EMPTY -->

                    <div class="empty-state">

                        <div class="empty-icon">

                            <i class='bx bx-news'></i>

                        </div>

                        <h4>
                            No hay noticias
                        </h4>

                        <p>
                            Aún no existen noticias registradas en el sistema.
                        </p>

                        <a href="{{ route('admin.news.create') }}"
                           class="modern-btn">

                            <i class='bx bx-plus'></i>
                            Crear primera noticia

                        </a>

                    </div>

                @endif

            </div>

        </div>

        <!-- SIDEBAR -->

        <div class="col-xl-3">

            <!-- ACTIVITY -->

            <div class="side-card">

                <div class="side-card-header">

                    <h5>
                        Actividad reciente
                    </h5>

                </div>

                <div class="activity-list">

                    <div class="activity-item">

                        <div class="activity-icon green">

                            <i class='bx bx-plus'></i>

                        </div>

                        <div>

                            <strong>
                                Nueva noticia creada
                            </strong>

                            <p>
                                Última publicación registrada.
                            </p>

                        </div>

                    </div>

                    <div class="activity-item">

                        <div class="activity-icon orange">

                            <i class='bx bx-edit'></i>

                        </div>

                        <div>

                            <strong>
                                Contenido actualizado
                            </strong>

                            <p>
                                Noticias modificadas recientemente.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

            <!-- TIPS -->

            <div class="side-card mt-4">

                <div class="side-card-header">

                    <h5>
                        Consejos
                    </h5>

                </div>

                <div class="tips-list">

                    <div class="tip-item">

                        <i class='bx bx-image'></i>

                        <span>
                            Usa imágenes WEBP optimizadas.
                        </span>

                    </div>

                    <div class="tip-item">

                        <i class='bx bx-text'></i>

                        <span>
                            Escribe títulos claros y directos.
                        </span>

                    </div>

                    <div class="tip-item">

                        <i class='bx bx-check-shield'></i>

                        <span>
                            Verifica la información antes de publicar.
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection