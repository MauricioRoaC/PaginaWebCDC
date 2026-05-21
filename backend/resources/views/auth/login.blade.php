<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>
        Acceso Institucional | Comando Cochabamba
    </title>

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <!-- BOOTSTRAP -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- BOXICONS -->

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'
          rel='stylesheet'>

    <!-- ADMIN CSS -->

    <link rel="stylesheet"
          href="{{ asset('css/admin.css') }}">

</head>

<body class="login-body">

    <!-- ========================================
        BACKGROUND EFFECTS
    ========================================= -->

    <div class="login-bg-overlay"></div>

    <div class="login-glow login-glow-1"></div>

    <div class="login-glow login-glow-2"></div>

    <!-- ========================================
        LOGIN WRAPPER
    ========================================= -->

    <div class="login-wrapper">

        <!-- ========================================
            LEFT PANEL
        ========================================= -->

        <div class="login-brand-panel">

            <div class="login-brand-content">

                <div class="login-brand-badge">

                    <i class='bx bx-shield-quarter'></i>

                    Sistema seguro institucional

                </div>

                <div class="login-brand-logo">

                    <img src="{{ asset('assets/images/logoadmin/logo.svg') }}"
                         alt="Logo institucional">

                </div>

                <h1>
                    Centro Administrativo
                    Institucional
                </h1>

                <p>
                    Plataforma centralizada para la gestión,
                    monitoreo y administración del
                    Comando Departamental de Cochabamba.
                </p>

                <!-- STATS -->

                <div class="login-brand-stats">

                    <div class="login-stat-card">

                        <strong>
                            24/7
                        </strong>

                        <span>
                            Monitoreo activo
                        </span>

                    </div>

                    <div class="login-stat-card">

                        <strong>
                            SSL
                        </strong>

                        <span>
                            Conexión segura
                        </span>

                    </div>

                    <div class="login-stat-card">

                        <strong>
                            Admin
                        </strong>

                        <span>
                            Acceso protegido
                        </span>

                    </div>

                </div>

            </div>

        </div>

        <!-- ========================================
            RIGHT PANEL
        ========================================= -->

        <div class="login-form-panel">

            <div class="login-card">

                <!-- TOP -->

                <div class="login-card-top">

                    <div class="login-mobile-logo">

                        <img src="{{ asset('assets/images/logoadmin/logo.svg') }}"
                             alt="Logo">

                    </div>

                    <div class="login-form-badge">

                        Acceso administrativo

                    </div>

                    <h2>
                        Iniciar sesión
                    </h2>

                    <p>
                        Ingresa con tu cuenta institucional.
                    </p>

                </div>

                <!-- ALERTS -->

                @if($errors->any())

                    <div class="login-alert login-alert-danger">

                        <i class='bx bx-error-circle'></i>

                        <span>
                            {{ $errors->first() }}
                        </span>

                    </div>

                @endif

                @if(session('status'))

                    <div class="login-alert login-alert-success">

                        <i class='bx bx-check-circle'></i>

                        <span>
                            {{ session('status') }}
                        </span>

                    </div>

                @endif

                <!-- FORM -->

                <form method="POST"
                      action="{{ route('login.post') }}"

                      class="login-form">

                    @csrf

                    <!-- EMAIL -->

                    <div class="login-input-group">

                        <label for="email">

                            Correo institucional

                        </label>

                        <div class="login-input-wrapper">

                            <i class='bx bx-envelope'></i>

                            <input type="email"
                                   name="email"

                                   id="email"

                                   placeholder="usuario@institucion.gob"

                                   value="{{ old('email') }}"

                                   required

                                   autofocus>

                        </div>

                    </div>

                    <!-- PASSWORD -->

                    <div class="login-input-group">

                        <label for="password">

                            Contraseña

                        </label>

                        <div class="login-input-wrapper">

                            <i class='bx bx-lock-alt'></i>

                            <input type="password"
                                   name="password"

                                   id="password"

                                   placeholder="Ingresa tu contraseña"

                                   required>

                            <button type="button"
                                    id="togglePassword"

                                    class="login-password-toggle">

                                <i class='bx bx-show'></i>

                            </button>

                        </div>

                    </div>

                    <!-- OPTIONS -->

                    <div class="login-options">

                        <label class="login-remember">

                            <input type="checkbox"
                                   name="remember">

                            <span>
                                Recordar sesión
                            </span>

                        </label>

                        <a href="{{ route('admin.password.request') }}"
                           class="login-forgot-link">

                            ¿Olvidaste tu contraseña?

                        </a>

                    </div>

                    <!-- SUBMIT -->

                    <button type="submit"
                            class="login-submit-btn">

                        <i class='bx bx-log-in-circle'></i>

                        Ingresar al sistema

                    </button>

                </form>

                <!-- FOOTER -->

                <div class="login-footer">

                    <div class="login-footer-status">

                        <div class="login-footer-dot"></div>

                        Sistema protegido y monitoreado

                    </div>

                    <p>
                        Acceso exclusivo para personal autorizado.
                    </p>

                </div>

            </div>

        </div>

    </div>

    <!-- BOOTSTRAP -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- LOGIN SCRIPT -->

    <script>

        const togglePassword =
            document.getElementById('togglePassword');

        const passwordField =
            document.getElementById('password');

        const toggleIcon =
            togglePassword.querySelector('i');

        togglePassword.addEventListener('click', () => {

            if(passwordField.type === 'password'){

                passwordField.type = 'text';

                toggleIcon.classList.remove('bx-show');

                toggleIcon.classList.add('bx-hide');

            }else{

                passwordField.type = 'password';

                toggleIcon.classList.remove('bx-hide');

                toggleIcon.classList.add('bx-show');

            }

        });

    </script>

</body>

</html>