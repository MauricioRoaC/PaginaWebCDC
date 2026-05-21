<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>
        Recuperar contraseña | Comando Cochabamba
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
        WRAPPER
    ========================================= -->

    <div class="login-wrapper forgot-wrapper">

        <!-- ========================================
            LEFT SIDE
        ========================================= -->

        <div class="login-brand-panel">

            <div class="login-brand-content">

                <div class="login-brand-badge">

                    <i class='bx bx-lock-open-alt'></i>

                    Recuperación segura de acceso

                </div>

                <div class="login-brand-logo">

                    <img src="{{ asset('assets/images/logoadmin/logo.svg') }}"
                         alt="Logo institucional">

                </div>

                <h1>
                    Restablecimiento
                    de contraseña
                </h1>

                <p>
                    Recupera el acceso a tu cuenta institucional
                    mediante un enlace seguro enviado a tu correo.
                </p>

                <div class="login-brand-stats">

                    <div class="login-stat-card">

                        <strong>
                            100%
                        </strong>

                        <span>
                            Acceso seguro
                        </span>

                    </div>

                    <div class="login-stat-card">

                        <strong>
                            SSL
                        </strong>

                        <span>
                            Protección cifrada
                        </span>

                    </div>

                    <div class="login-stat-card">

                        <strong>
                            Email
                        </strong>

                        <span>
                            Verificación oficial
                        </span>

                    </div>

                </div>

            </div>

        </div>

        <!-- ========================================
            RIGHT SIDE
        ========================================= -->

        <div class="login-form-panel">

            <div class="login-card forgot-card">

                <!-- TOP -->

                <div class="login-card-top">

                    <div class="login-mobile-logo">

                        <img src="{{ asset('assets/images/logoadmin/logo.svg') }}"
                             alt="Logo">

                    </div>

                    <div class="login-form-badge">

                        Recuperación institucional

                    </div>

                    <h2>
                        ¿Olvidaste tu contraseña?
                    </h2>

                    <p>
                        Ingresa tu correo institucional y te enviaremos
                        un enlace seguro para restablecer tu acceso.
                    </p>

                </div>

                <!-- ALERT SUCCESS -->

                @if(session('status'))

                    <div class="login-alert login-alert-success">

                        <i class='bx bx-check-circle'></i>

                        <span>
                            {{ session('status') }}
                        </span>

                    </div>

                @endif

                <!-- ALERT ERROR -->

                @if($errors->any())

                    <div class="login-alert login-alert-danger">

                        <i class='bx bx-error-circle'></i>

                        <span>
                            {{ $errors->first() }}
                        </span>

                    </div>

                @endif

                <!-- FORM -->

                <form method="POST"
                      action="{{ route('admin.password.email') }}"

                      class="login-form">

                    @csrf

                    <!-- EMAIL -->

                    <div class="login-input-group">

                        <label for="email">

                            Correo electrónico institucional

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

                    <!-- SUBMIT -->

                    <button type="submit"
                            class="login-submit-btn">

                        <i class='bx bx-send'></i>

                        Enviar enlace de recuperación

                    </button>

                </form>

                <!-- EXTRA -->

                <div class="forgot-extra-box">

                    <div class="forgot-extra-icon">

                        <i class='bx bx-shield-quarter'></i>

                    </div>

                    <div>

                        <strong>
                            Seguridad institucional
                        </strong>

                        <p>
                            El enlace expirará automáticamente
                            después de un tiempo por seguridad.
                        </p>

                    </div>

                </div>

                <!-- FOOTER -->

                <div class="login-footer">

                    <a href="{{ route('login') }}"
                       class="forgot-back-btn">

                        <i class='bx bx-arrow-back'></i>

                        Volver al inicio de sesión

                    </a>

                </div>

            </div>

        </div>

    </div>

    <!-- BOOTSTRAP -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
