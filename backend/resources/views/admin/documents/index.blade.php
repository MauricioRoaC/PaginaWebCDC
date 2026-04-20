@extends('layouts.admin')

@section('content')
    <h2 class="mb-4">Documentos</h2>

    <div class="mb-3">
        <a href="{{ route('admin.documents.create') }}" class="btn btn-primary">Nuevo documento</a>
    </div>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>N°</th>
            <th>Título</th>
            <th>Tipo</th>
            <th>Visible</th>
            <th>Archivo</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @forelse($documents as $doc)
            <tr>
                <td>{{ $doc->number ?? '-' }}</td>
                <td>{{ $doc->title }}</td>
                <td>
                    @switch($doc->type)
                        @case('rendicion') Rendición de Cuentas @break
                        @case('poa') Plan Operativo Anual @break
                        @case('pei') Plan Estratégico Institucional @break
                    @endswitch
                </td>
                <td>
                    @if($doc->is_public)
                        <span class="badge bg-success">Sí</span>
                    @else
                        <span class="badge bg-secondary">No</span>
                    @endif
                </td>
                <td>
                   @if($doc->file_url)
    <a href="{{ $doc->file_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
        Ver documento
    </a>
@else
    <span class="text-muted">Sin enlace</span>
@endif

                    {{-- Editar --}}
                    <a href="{{ route('admin.documents.edit', $doc) }}" class="btn btn-sm btn-warning">
                        Editar
                    </a>

                    {{-- Eliminar --}}
                    <form action="{{ route('admin.documents.destroy', $doc) }}"
                          method="POST"
                          style="display:inline-block"
                          onsubmit="return confirm('¿Eliminar este documento?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit">
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">No hay documentos registrados.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $documents->links() }}
@endsection
