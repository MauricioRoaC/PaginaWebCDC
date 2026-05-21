@extends('layouts.admin')

@section('content')

<div class="lives-page">

    <!-- HEADER -->

    <div class="lives-header">

        <div>

            <h1 class="lives-title">
                Centro de Lives
            </h1>

            <p class="lives-subtitle">
                Gestiona transmisiones en vivo institucionales.
            </p>

        </div>

        <a href="{{ route('admin.lives.create') }}"
           class="new-live-btn">

            <i class='bx bx-broadcast'></i>

            Nuevo live

        </a>

    </div>

    <!-- STATS -->

    <div class="row g-4 mb-4">

        <div class="col-lg-4">

            <div class="live-stat-card">

                <div class="live-stat-icon green">

                    <i class='bx bx-radio-circle-marked'></i>

                </div>

                <div>

                    <span class="live-stat-label">
                        Lives activos
                    </span>

                    <h3>
                        {{ $lives->where('is_active', true)->count() }}
                    </h3>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="live-stat-card">

                <div class="live-stat-icon blue">

                    <i class='bx bx-video'></i>

                </div>

                <div>

                    <span class="live-stat-label">
                        Total transmisiones
                    </span>

                    <h3>
                        {{ $lives->count() }}
                    </h3>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="live-stat-card">

                <div class="live-stat-icon orange">

                    <i class='bx bx-time-five'></i>

                </div>

                <div>

                    <span class="live-stat-label">
                        Último registro
                    </span>

                    <h3 class="small-stat">
                        {{ optional($lives->first())->created_at?->format('d/m/Y') ?? '--' }}
                    </h3>

                </div>

            </div>

        </div>

    </div>

    <!-- CONTENT -->

    @if($lives->count())

        <div class="live-grid">

            @foreach($lives as $live)

                @php

                    $platform = 'generic';
                    $platformName = 'Streaming';

                    if(str_contains($live->embed_url, 'youtube')){
                        $platform = 'youtube';
                        $platformName = 'YouTube';
                    }

                    elseif(str_contains($live->embed_url, 'facebook')){
                        $platform = 'facebook';
                        $platformName = 'Facebook Live';
                    }

                    elseif(str_contains($live->embed_url, 'tiktok')){
                        $platform = 'tiktok';
                        $platformName = 'TikTok Live';
                    }

                @endphp

                <div class="live-card">

                    <!-- TOP -->

                    <div class="live-card-top">

                        <div class="platform-badge {{ $platform }}">

                            @if($platform === 'youtube')

                                <i class='bx bxl-youtube'></i>

                            @elseif($platform === 'facebook')

                                <i class='bx bxl-facebook-circle'></i>

                            @elseif($platform === 'tiktok')

                                <i class='bx bxl-tiktok'></i>

                            @else

                                <i class='bx bx-wifi'></i>

                            @endif

                            {{ $platformName }}

                        </div>

                        <div class="live-status
                            {{ $live->is_active ? 'active' : 'inactive' }}">

                            <span class="status-dot"></span>

                            {{ $live->is_active ? 'EN VIVO' : 'INACTIVO' }}

                        </div>

                    </div>

                    <!-- BODY -->

                    <div class="live-card-body">

                        <h4>
                            {{ $live->title }}
                        </h4>

                        <p>
                            {{ Str::limit($live->embed_url, 90) }}
                        </p>

                    </div>

                    <!-- FOOTER -->

                    <div class="live-card-footer">

                        <div class="live-date">

                            <i class='bx bx-calendar'></i>

                            {{ $live->created_at->format('d/m/Y H:i') }}

                        </div>

                        <div class="live-actions">

                            <!-- TOGGLE -->

                            <form method="POST"
                                  action="{{ route('admin.lives.toggle', $live) }}">

                                @csrf
                                @method('PATCH')

                                <button class="action-btn warning-btn">

                                    @if($live->is_active)

                                        <i class='bx bx-pause-circle'></i>
                                        

                                    @else

                                        <i class='bx bx-play-circle'></i>
                                        

                                    @endif

                                </button>

                            </form>

                            <!-- DELETE -->

                            <form method="POST"
                                  action="{{ route('admin.lives.destroy', $live) }}">

                                @csrf
                                @method('DELETE')

                                <button class="action-btn danger-btn"
                                    onclick="return confirm('¿Eliminar este live?')">

                                    <i class='bx bx-trash'></i>

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <!-- EMPTY -->

        <div class="empty-live-state">

            <div class="empty-live-icon">

                <i class='bx bx-broadcast'></i>

            </div>

            <h3>
                No hay transmisiones registradas
            </h3>

            <p>
                Crea un nuevo live para comenzar
                transmisiones institucionales.
            </p>

            <a href="{{ route('admin.lives.create') }}"
               class="new-live-btn mt-3">

                <i class='bx bx-plus'></i>

                Crear primer live

            </a>

        </div>

    @endif

</div>

@endsection