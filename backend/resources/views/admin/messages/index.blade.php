@extends('layouts.admin')

@section('content')
    <h2 class="mb-4">Mensajes recibidos</h2>

    @if($messages->count())
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Asunto</th>
                    <th>Fecha</th>
                    <th style="width:140px;">Acciones</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($messages as $msg)
                    <tr>
                        <td>{{ $msg->name }}</td>
                        <td>{{ $msg->email }}</td>
                        <td>{{ $msg->subject }}</td>
                        <td>{{ $msg->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.messages.show', $msg) }}" 
                               class="btn btn-sm btn-primary">
                                Ver
                            </a>

                            <form action="{{ route('admin.messages.destroy', $msg) }}" 
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar este mensaje?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{ $messages->links() }}

    @else
        <p class="text-muted">No hay mensajes recibidos.</p>
    @endif
@endsection

