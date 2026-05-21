@extends('layouts.admin')

@section('content')

<div class="messages-page">

    <!-- HEADER -->

    <div class="messages-header">

        <div>

            <h1 class="messages-title">
                Centro de mensajes
            </h1>

            <p class="messages-subtitle">
                Gestiona los mensajes enviados desde el portal institucional.
            </p>

        </div>

        <!-- SEARCH -->

        <div class="messages-search">

            <i class='bx bx-search'></i>

            <input type="text"
                   id="messageSearch"
                   placeholder="Buscar mensaje...">

        </div>

    </div>

    <!-- STATS -->

    <div class="messages-stats">

        <div class="messages-stat-card">

            <div class="messages-stat-icon blue">

                <i class='bx bx-envelope'></i>

            </div>

            <div>

                <span>Total mensajes</span>

                <h3>{{ $messages->total() }}</h3>

            </div>

        </div>

        <div class="messages-stat-card">

            <div class="messages-stat-icon green">

                <i class='bx bx-time-five'></i>

            </div>

            <div>

                <span>Último recibido</span>

                <h3 class="small-stat">

                    {{ optional($messages->first())->created_at?->format('d/m/Y') ?? '--' }}

                </h3>

            </div>

        </div>

    </div>

    <!-- CONTENT -->

    @if($messages->count())

        <div class="messages-grid"
             id="messagesGrid">

            @foreach ($messages as $msg)

                <div class="message-card"

                     data-search="
                        {{ strtolower($msg->name) }}
                        {{ strtolower($msg->email) }}
                        {{ strtolower($msg->subject) }}
                     ">

                    <!-- TOP -->

                    <div class="message-top">

                        <div class="message-user">

                            <div class="message-avatar">

                                {{ strtoupper(substr($msg->name, 0, 1)) }}

                            </div>

                            <div>

                                <h4>
                                    {{ $msg->name }}
                                </h4>

                                <span>
                                    {{ $msg->email }}
                                </span>

                            </div>

                        </div>

                        <div class="message-date">

                            {{ $msg->created_at->format('d/m/Y H:i') }}

                        </div>

                    </div>

                    <!-- SUBJECT -->

                    <div class="message-subject">

                        <i class='bx bx-message-square-detail'></i>

                        {{ $msg->subject }}

                    </div>

                    <!-- PREVIEW -->

                    <div class="message-preview">

                        {{ Str::limit($msg->message, 140) }}

                    </div>

                    <!-- FOOTER -->

                    <div class="message-footer">

                        <div class="message-status">

                            <span class="status-dot"></span>

                            Recibido

                        </div>

                        <div class="message-actions">

                            <!-- VIEW -->

                            <a href="{{ route('admin.messages.show', $msg) }}"
                               class="message-btn primary-btn">

                                <i class='bx bx-show'></i>

                                Ver

                            </a>

                            <!-- DELETE -->

                            <form action="{{ route('admin.messages.destroy', $msg) }}"
                                  method="POST"

                                  onsubmit="return confirm('¿Eliminar este mensaje?');">

                                @csrf
                                @method('DELETE')

                                <button class="message-btn danger-btn">

                                    <i class='bx bx-trash'></i>

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        <!-- PAGINATION -->

        <div class="messages-pagination">

            {{ $messages->links() }}

        </div>

    @else

        <div class="messages-empty">

            <div class="messages-empty-icon">

                <i class='bx bx-envelope-open'></i>

            </div>

            <h3>
                No hay mensajes recibidos
            </h3>

            <p>
                Los mensajes enviados desde el sitio web
                aparecerán aquí automáticamente.
            </p>

        </div>

    @endif

</div>

@endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', () => {

    const search =
        document.getElementById('messageSearch');

    const cards =
        document.querySelectorAll('.message-card');

    search.addEventListener('input', function(){

        const value =
            this.value.toLowerCase();

        cards.forEach(card => {

            const content =
                card.dataset.search;

            if(content.includes(value)){

                card.style.display = 'flex';

            }else{

                card.style.display = 'none';

            }

        });

    });

});

</script>

@endpush