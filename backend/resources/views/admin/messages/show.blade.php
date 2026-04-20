@extends('layouts.admin')

@section('content')
    <h2>Mensaje de {{ $message->name }}</h2>

    <div class="card mt-4">
        <div class="card-body">
            <p><strong>Nombre:</strong> {{ $message->name }}</p>
            <p><strong>Email:</strong> {{ $message->email }}</p>
            <p><strong>Asunto:</strong> {{ $message->subject }}</p>
            <p><strong>Fecha:</strong> {{ $message->created_at->format('d/m/Y H:i') }}</p>

            <hr>

            <h5>Mensaje:</h5>
            <p>{{ $message->message }}</p>

            <a href="{{ route('admin.messages.index') }}" class="btn btn-secondary mt-3">
                Volver
            </a>
        </div>
    </div>
@endsection

