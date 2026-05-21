<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>
        Nueva contraseña | Comando Cochabamba
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

                    <i class='bx bx-lock-alt'></i>

                    Restablecimiento protegido

                </div>

                <div class="login-brand-logo">

                    <img src="{{ asset('assets/images/logoadmin/logo.svg') }}"
                         alt="Logo institucional">

                </div>

                <h1>
                    Configura
                    tu nueva clave
                </h1>

                <p>
                    Establece una nueva contraseña segura
                    para recuperar el acceso al sistema
                    administrativo institucional.
                </p>

                <!-- STATS -->

                <div class="login-brand-stats">

                    <div class="login-stat-card">

                        <strong>
                            256bit
                        </strong>

                        <span>
                            Seguridad cifrada
                        </span>

                    </div>

                    <div class="login-stat-card">

                        <strong>
                            SSL
                        </strong>

                        <span>
                            Protección activa
                        </span>

                    </div>

                    <div class="login-stat-card">

                        <strong>
                            Seguro
                        </strong>

                        <span>
                            Acceso institucional
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

                        Nueva contraseña

                    </div>

                    <h2>
                        Restablecer acceso
                    </h2>

                    <p>
                        Ingresa una nueva contraseña segura
                        y confirma los datos para finalizar
                        el proceso de recuperación.
                    </p>

                </div>

                <!-- ERRORS -->

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
                      action="{{ route('admin.password.update') }}"

                      class="login-form">

                    @csrf

                    <input type="hidden"
                           name="token"

                           value="{{ $token }}">

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

                                   value="{{ $email ?? old('email') }}"

                                   placeholder="usuario@institucion.gob"

                                   required>

                        </div>

                    </div>

                    <!-- PASSWORD -->

                    <div class="login-input-group">

                        <label for="password">

                            Nueva contraseña

                        </label>

                        <div class="login-input-wrapper">

                            <i class='bx bx-lock-alt'></i>

                            <input type="password"
                                   name="password"

                                   id="password"

                                   placeholder="Ingresa una nueva contraseña"

                                   required>

                            <button type="button"
                                    id="togglePassword"

                                    class="login-password-toggle">

                                <i class='bx bx-show'></i>

                            </button>

                        </div>

                    </div>

                    <!-- CONFIRM PASSWORD -->

                    <div class="login-input-group">

                        <label for="password_confirmation">

                            Confirmar contraseña

                        </label>

                        <div class="login-input-wrapper">

                            <i class='bx bx-check-shield'></i>

                            <input type="password"
                                   name="password_confirmation"

                                   id="password_confirmation"

                                   placeholder="Confirma la contraseña"

                                   required>

                            <button type="button"
                                    id="toggleConfirmPassword"

                                    class="login-password-toggle">

                                <i class='bx bx-show'></i>

                            </button>

                        </div>

                    </div>

                    <!-- SUBMIT -->

                    <button type="submit"
                            class="login-submit-btn">

                        <i class='bx bx-save'></i>

                        Guardar nueva contraseña

                    </button>

                </form>

                <!-- SECURITY BOX -->

                <div class="forgot-extra-box">

                    <div class="forgot-extra-icon">

                        <i class='bx bx-shield-quarter'></i>

                    </div>

                    <div>

                        <strong>
                            Seguridad institucional
                        </strong>

                        <p>
                            Utiliza una contraseña fuerte
                            y evita compartirla con terceros.
                        </p>

                    </div>

                </div>

                <!-- FOOTER -->

                <div class="login-footer">

                    <div class="login-footer-status">

                        <div class="login-footer-dot"></div>

                        Restablecimiento protegido

                    </div>

                    <p>
                        Sistema administrativo institucional seguro.
                    </p>

                </div>

            </div>

        </div>

    </div>

    <!-- BOOTSTRAP -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- PASSWORD TOGGLE -->

    <script>

        function setupPasswordToggle(buttonId, inputId){

            const button =
                document.getElementById(buttonId);

            const input =
                document.getElementById(inputId);

            const icon =
                button.querySelector('i');

            button.addEventListener('click', () => {

                if(input.type === 'password'){

                    input.type = 'text';

                    icon.classList.remove('bx-show');

                    icon.classList.add('bx-hide');

                }else{

                    input.type = 'password';

                    icon.classList.remove('bx-hide');

                    icon.classList.add('bx-show');

                }

            });

        }

        setupPasswordToggle(
            'togglePassword',
            'password'
        );

        setupPasswordToggle(
            'toggleConfirmPassword',
            'password_confirmation'
        );

    </script>

</body>

</html>