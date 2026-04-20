@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card" style="max-width: 420px; width:100%; border-radius: 1.25rem;">
        <div class="card-body p-4">

            <h5 class="mb-3 text-center">Nueva contraseña</h5>
            <p class="text-muted" style="font-size:0.9rem;">
                Ingresa tu nueva contraseña y confírmala.
            </p>

            @if($errors->any())
                <div class="alert alert-danger py-2">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li style="font-size: 0.9rem">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" name="email" id="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ $email ?? old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Nueva contraseña</label>
                    <input type="password" name="password" id="password"
                           class="form-control @error('password') is-invalid @enderror" required>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100" style="background-color:#637227; border-color:#637227;">
                    Guardar nueva contraseña
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
