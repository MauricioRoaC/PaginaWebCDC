@extends('layouts.admin')

@section('content')

<div class="message-view-page">

    <!-- HEADER -->

    <div class="message-view-header">

        <div class="message-view-user">

            <!-- AVATAR -->

            <div class="message-view-avatar">

                {{ strtoupper(substr($message->name, 0, 1)) }}

            </div>

            <!-- INFO -->

            <div>

                <span class="message-view-label">

                    Mensaje recibido

                </span>

                <h1>
                    {{ $message->name }}
                </h1>

                <p>

                    {{ $message->email }}

                </p>

            </div>

        </div>

        <!-- ACTIONS -->

        <div class="message-view-actions">

            <a href="{{ route('admin.messages.index') }}"
               class="message-back-btn">

                <i class='bx bx-arrow-back'></i>

                Volver

            </a>

            <form action="{{ route('admin.messages.destroy', $message) }}"
                  method="POST"

                  onsubmit="return confirm('¿Eliminar este mensaje?');">

                @csrf
                @method('DELETE')

                <button class="message-delete-btn">

                    <i class='bx bx-trash'></i>

                    Eliminar

                </button>

            </form>

        </div>

    </div>

    <!-- CONTENT -->

    <div class="message-view-layout">

        <!-- MAIN -->

        <div class="message-view-main">

            <!-- SUBJECT -->

            <div class="message-view-card">

                <div class="message-view-card-top">

                    <div class="message-view-card-icon">

                        <i class='bx bx-message-square-detail'></i>

                    </div>

                    <div>

                        <span>
                            Asunto
                        </span>

                        <h3>
                            {{ $message->subject }}
                        </h3>

                    </div>

                </div>

            </div>

            <!-- MESSAGE -->

            <div class="message-content-card">

                <div class="message-content-header">

                    <h3>
                        Contenido del mensaje
                    </h3>

                    <span>

                        {{ $message->created_at->format('d/m/Y H:i') }}

                    </span>

                </div>

                <div class="message-content-body">

                    {!! nl2br(e($message->message)) !!}

                </div>

            </div>

        </div>

        <!-- SIDEBAR -->

        <div class="message-view-sidebar">

            <!-- INFO -->

            <div class="message-side-card">

                <h4>
                    Información del remitente
                </h4>

                <ul>

                    <li>

                        <span>Nombre</span>

                        <strong>
                            {{ $message->name }}
                        </strong>

                    </li>

                    <li>

                        <span>Correo</span>

                        <strong>
                            {{ $message->email }}
                        </strong>

                    </li>

                    <li>

                        <span>Fecha</span>

                        <strong>

                            {{ $message->created_at->format('d/m/Y') }}

                        </strong>

                    </li>

                    <li>

                        <span>Hora</span>

                        <strong>

                            {{ $message->created_at->format('H:i') }}

                        </strong>

                    </li>

                </ul>

            </div>

            <!-- STATUS -->

            <div class="message-side-card">

                <h4>
                    Estado del mensaje
                </h4>

                <div class="message-status-large">

                    <span class="message-status-dot"></span>

                    Recibido correctamente

                </div>

            </div>

        </div>

    </div>

</div>

@endsection