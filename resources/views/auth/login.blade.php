<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sislepga</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="adminlte/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="adminlte/css/adminlte.min.css">

    <style>
        .custom-checkbox-sm input[type="checkbox"] {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            accent-color: #007bff;
            vertical-align: middle;
        }

        .custom-checkbox-sm label {
            font-size: 14px;
            margin-left: 4px;
            vertical-align: middle;
            cursor: pointer;
            margin-top: 6px;
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ url('/') }}" class="h1"><b>Sislepga</b></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Inicia session con tu cuenta.</p>
                <div class="mb-3">
                    <div class="form-group">
                        <label class="form-label" for="email">Correo</label>
                        <input type="email" class="form-control" id="email" name="email" :value="old('email')" autofocus autocomplete="email">
                        <small id="email-error" class="text-danger"></small>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-group">
                        <label class="form-label" for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" autocomplete="current-password">
                        <small id="password-error" class="text-danger"></small>
                    </div>
                </div>
                <!-- <div class="mb-3">
                        <div class="custom-checkbox-sm">
                            <input type="checkbox" id="remember" class="checkbox">
                            <label for="remember">
                                Recordar
                            </label>
                        </div>
                    </div> -->
                <div class="mb-3 d-flex justify-content-center">
                    <button type="button" class="btn btn-primary" onclick="login()" id="login-btn">Iniciar Session</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="adminlte/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="adminlte/js/adminlte.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#email').focus();

            // limpiar error al escribir
            $('#email, #password').on('input', function() {
                const id = $(this).attr('id');
                $('#' + id + '-error').text('');
                $(this).removeClass('is-invalid');
            });

            // Enter en password hace login
            $('#password').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#login-btn').click();
                }
            });

            $('#login-btn').on('click', login);
        });

        function validateEmail(email) {
            // regex simple para validar formato
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(String(email).toLowerCase());
        }

        function clearErrors() {
            $('#email-error').text('');
            $('#password-error').text('');
            $('#email, #password').removeClass('is-invalid');
        }

        function showErrors(errors) {
            
            if (!errors) return;
            if (errors.email) {
                const msg = Array.isArray(errors.email) ? errors.email[0] : errors.email;
                $('#email-error').text(msg);
                $('#email').addClass('is-invalid');
            }
            if (errors.password) {
                const msg = Array.isArray(errors.password) ? errors.password[0] : errors.password;
                $('#password-error').text(msg);
                $('#password').addClass('is-invalid');
            }
        }

        function login() {
            clearErrors();

            const email = $('#email').val().trim();
            const password = $('#password').val().trim();

            const clientErrors = {};
            if (!email) {
                clientErrors.email = 'Por favor ingrese su correo electrónico.';
            } else if (!validateEmail(email)) {
                clientErrors.email = 'El correo electrónico no es válido.';
            }

            if (!password) {
                clientErrors.password = 'Debe ingresar una contraseña.';
            }

            if (Object.keys(clientErrors).length > 0) {
                showErrors(clientErrors);
                const first = Object.keys(clientErrors)[0];
                $('#' + first).focus();
                return;
            }

            $('#login-btn').prop('disabled', true);

            $.ajax({
                url: '{{ route('login') }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    email: email,
                    password: password
                },
                success: function(res) {
                    if (res && res.status === 'success') {
                        window.location.href = res.redirect || '/inicio';
                    } else if (res && res.errors) {
                        showErrors(res.errors);
                    } else {
                        alert('Respuesta inesperada del servidor.');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        // errores de validación / backend
                        const response = xhr.responseJSON;
                        if (response && response.errors) {
                            showErrors(response.errors);
                        }
                    }
                },
                complete: function() {
                    $('#login-btn').prop('disabled', false);
                }
            });
        }
    </script>
</body>

</html>
