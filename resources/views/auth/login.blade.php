<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SISGE</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
                <a href="{{ url('/')}}" class="h1"><b>SISGE</b></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Inicia session con tu cuenta.</p>

                @if (session('status'))
                <div class="mb-3 txt-success">
                    {{ session('status') }}
                </div>
                @endif

                <form action="{{ route('login')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <div class="form-group">
                            <label class="form-label" for="email">Correo</label>
                            <input type="email" class="form-control" id="email" name="email" :value="old('email')" autofocus autocomplete="username">
                            @error('email')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-group">
                            <label class="form-label" for="password">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" autocomplete="current-password">
                            @error('password')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
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
                        <button type="submit" class="btn btn-primary">Iniciar Session</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="adminlte/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="adminlte/js/adminlte.min.js"></script>
</body>

</html>