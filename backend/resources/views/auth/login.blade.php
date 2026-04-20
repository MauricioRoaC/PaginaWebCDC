<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ingreso al Panel - Comando Cochabamba</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: #ffffffff;
        }

        .login-card {
            border-radius: 1.25rem;
            box-shadow: 0 20px 50px rgba(57, 107, 11, 0.12);
            border: none;
        }

        .logo-institucional img {
            max-width: 100px;
            opacity: 0.95;
            margin-bottom: 1rem;
        }

        .btn-login {
            background:#637227;
            border-color:#637227;
        }

        .btn-login:hover {
            background:#525f1f;
            border-color:#525f1f;
        }

        .form-text-link {
            color:#637227;
            font-size:0.9rem;
            text-decoration:none;
        }

        .form-text-link:hover {
            text-decoration:underline;
            color:#4e5b1c;
        }

        .input-group-text {
            cursor:pointer;
        }
    </style>
</head>
<body class="d-flex align-items-center">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">

            <div class="card login-card p-4">

                <div class="text-center logo-institucional">
                    <img src="{{ asset('assets/images/logoadmin/logo.svg') }}" alt="Logo">
                </div>

                <h5 class="text-center mb-1">Panel Administrativo</h5>
                <p class="text-muted text-center small mb-4">
                    Comando Departamental de Cochabamba
                </p>

                @if($errors->any())
                    <div class="alert alert-danger text-start py-2">
                        {{ $errors->first() }}
                    </div>
                @endif

                @if(session('status'))
                    <div class="alert alert-success text-start py-2">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf

                    <div class="mb-3 text-start">
                        <label for="email" class="form-label">Correo institucional</label>
                        <input type="email" name="email" id="email" class="form-control"
                               required autofocus value="{{ old('email') }}">
                    </div>

                    <div class="mb-3 text-start">
                        <label for="password" class="form-label">Contraseña</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password"
                                   class="form-control" required>
                            <span class="input-group-text" id="togglePassword">
                                👁
                            </span>
                        </div>
                    </div>

                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div class="form-check text-start mb-0">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Recordar sesión</label>
                        </div>

                        <a href="{{ route('admin.password.request') }}" class="form-text-link">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>

                    <button type="submit" class="btn btn-login w-100 text-white">
                        Ingresar
                    </button>
                </form>

            </div>

            <p class="text-center text-muted small mt-3">
                Acceso exclusivo para personal autorizado.
            </p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');

    togglePassword.addEventListener('click', () => {
        passwordField.type =
            passwordField.type === 'password'
                ? 'text'
                : 'password';
    });
</script>
</body>
</html>
