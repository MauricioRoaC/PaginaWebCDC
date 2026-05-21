@extends('layouts.admin')

@section('content')

<div class="docs-page">

    <!-- HEADER -->

    <div class="docs-header">

        <div>

            <h1>
                Biblioteca documental
            </h1>

            <p>
                Gestiona documentos institucionales,
                planes operativos y rendiciones públicas.
            </p>

        </div>

        <a href="{{ route('admin.documents.create') }}"
           class="docs-create-btn">

            <i class='bx bx-plus'></i>

            Nuevo documento

        </a>

    </div>

    <!-- SUCCESS -->

    @if(session('success'))

        <div class="docs-alert-success">

            <i class='bx bx-check-circle'></i>

            {{ session('success') }}

        </div>

    @endif

    <!-- EMPTY -->

    @if(!$documents->count())

        <div class="docs-empty">

            <div class="docs-empty-icon">

                <i class='bx bx-folder-open'></i>

            </div>

            <h3>
                No hay documentos registrados
            </h3>

            <p>
                Agrega documentos institucionales
                para comenzar la biblioteca pública.
            </p>

            <a href="{{ route('admin.documents.create') }}"
               class="docs-empty-btn">

                Crear primer documento

            </a>

        </div>

    @else

        <!-- STATS -->

        <div class="docs-stats-grid">

            <div class="docs-stat-card">

                <div class="docs-stat-icon green">

                    <i class='bx bx-file'></i>

                </div>

                <div>

                    <strong>
                        {{ $documents->total() }}
                    </strong>

                    <span>
                        Documentos
                    </span>

                </div>

            </div>

            <div class="docs-stat-card">

                <div class="docs-stat-icon blue">

                    <i class='bx bx-show'></i>

                </div>

                <div>

                    <strong>
                        {{ $documents->where('is_public', true)->count() }}
                    </strong>

                    <span>
                        Públicos
                    </span>

                </div>

            </div>

            <div class="docs-stat-card">

                <div class="docs-stat-icon orange">

                    <i class='bx bx-folder'></i>

                </div>

                <div>

                    <strong>
                        {{ $documents->where('type', 'poa')->count() }}
                    </strong>

                    <span>
                        POA
                    </span>

                </div>

            </div>

        </div>

        <!-- GRID -->

        <div class="docs-grid">

            @foreach($documents as $doc)

                <div class="doc-card">

                    <!-- TOP -->

                    <div class="doc-card-top">

                        <div class="doc-icon">

                            @if(str_contains($doc->file_url, 'drive.google'))

                                <i class='bx bxl-google'></i>

                            @elseif(str_contains($doc->file_url, '.pdf'))

                                <i class='bx bxs-file-pdf'></i>

                            @else

                                <i class='bx bx-link-external'></i>

                            @endif

                        </div>

                        <div class="doc-status">

                            @if($doc->is_public)

                                <span class="doc-public">

                                    Público

                                </span>

                            @else

                                <span class="doc-private">

                                    Interno

                                </span>

                            @endif

                        </div>

                    </div>

                    <!-- TYPE -->

                    <div class="doc-type">

                        @switch($doc->type)

                            @case('rendicion')

                                <span class="doc-badge rendicion">

                                    Rendición

                                </span>

                            @break

                            @case('poa')

                                <span class="doc-badge poa">

                                    POA

                                </span>

                            @break

                            @case('pei')

                                <span class="doc-badge pei">

                                    PEI

                                </span>

                            @break

                        @endswitch

                    </div>

                    <!-- TITLE -->

                    <h3 class="doc-title">

                        {{ $doc->title }}

                    </h3>

                    <!-- NUMBER -->

                    @if($doc->number)

                        <div class="doc-number">

                            Documento N°
                            {{ $doc->number }}

                        </div>

                    @endif

                    <!-- DESCRIPTION -->

                    <p class="doc-description">

                        {{ $doc->description
                            ? Str::limit($doc->description, 110)
                            : 'Documento institucional disponible para consulta pública.' }}

                    </p>

                    <!-- META -->

                    <div class="doc-meta">

                        <div>

                            <i class='bx bx-calendar'></i>

                            {{ $doc->created_at->format('d/m/Y') }}

                        </div>

                    </div>

                    <!-- ACTIONS -->

                    <div class="doc-actions">

                        <a href="{{ $doc->file_url }}"
                           target="_blank"

                           class="doc-view-btn">

                            <i class='bx bx-show-alt'></i>

                            Ver documento

                        </a>

                        <div class="doc-actions-right">

                            <!-- EDIT -->

                            <a href="{{ route('admin.documents.edit', $doc) }}"
                               class="doc-edit-btn">

                                <i class='bx bx-edit'></i>

                            </a>

                            <!-- DELETE -->

                            <form action="{{ route('admin.documents.destroy', $doc) }}"
                                  method="POST"

                                  onsubmit="return confirm('¿Eliminar este documento?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="doc-delete-btn">

                                    <i class='bx bx-trash'></i>

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        <!-- PAGINATION -->

        <div class="docs-pagination">

            {{ $documents->links() }}

        </div>

    @endif

</div>

@endsection