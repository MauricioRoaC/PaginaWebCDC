<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar contraseña - Comando Cochabamba</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { min-height: 100vh; }
        .card-custom {
            max-width: 420px;
            border-radius: 1.25rem;
            border: none;
            box-shadow: 0 20px 50px rgba(0,0,0,0.10);
        }
    </style>
</head>
<body class="bg-light d-flex align-items-center">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card card-custom">
                <div class="card-body p-4">

                    <h5 class="mb-2 text-center">Recuperar contraseña</h5>
                    <p class="text-muted small mb-4 text-center">
                        Ingresa tu correo electrónico. Si está registrado, te enviaremos un enlace para restablecer tu contraseña.
                    </p>

                    @if(session('status'))
                        <div class="alert alert-success py-2">{{ session('status') }}</div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger py-2">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.password.email') }}"
>
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" name="email" id="email"
                                   class="form-control" required autofocus
                                   value="{{ old('email') }}">
                        </div>

                        <button type="submit" class="btn w-100 text-white"
                                style="background:#637227; border-color:#637227;">
                            Enviar enlace
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}" class="small">Volver al inicio de sesión</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
