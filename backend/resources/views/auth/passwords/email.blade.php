@extends('layouts.app') {{-- o el layout que uses para auth, puedes usar el mismo estilo del login si quieres --}}

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card" style="max-width: 420px; width:100%; border-radius: 1.25rem;">
        <div class="card-body p-4">

            <h5 class="mb-3 text-center">Recuperar contraseña</h5>
            <p class="text-muted" style="font-size:0.9rem;">
                Ingresa tu correo electrónico. Si está registrado, te enviaremos un enlace para restablecer tu contraseña.
            </p>

            @if(session('status'))
                <div class="alert alert-success py-2">{{ session('status') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger py-2">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li style="font-size: 0.9rem">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" name="email" id="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" required autofocus>
                </div>

                <button type="submit" class="btn btn-primary w-100" style="background-color:#637227; border-color:#637227;">
                    Enviar enlace
                </button>

                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" style="font-size:0.9rem;">Volver al inicio de sesión</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
