<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="WebAltoque">
    <meta name="Resource-type" content="Document">
    <meta http-equiv="X-UA-Compatible" content="IE=5; IE=6; IE=7; IE=8; IE=9; IE=10">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Bolsa Trabajo | Administrador</title>
    <link rel="stylesheet" href="{{ asset('auth/css/login/index.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body
    style="padding: 0; margin: 0; 
    background: linear-gradient(to bottom, rgb(0 0 0 / 7%), rgb(4 74 176 / 34%)), 
                url('{{ asset($configuracion->banneradmin) }}');
    background-attachment: fixed;
    background-size: cover;
    background-position: center center;
    color: white;">
    <!-- Contenido de tu página -->
</body>

<section class="login">
    <div class="wrap-content">
        <div style="background-color:#044ab0; text-align: center; border-radius:5px;">
            <h5 class="form-title" style="color:white; margin: 0; padding: 10px 0; font-size: 12px; font-weight: 100;">
                <i class="fa fa-lock" style="margin-right: 8px;"></i>Acceso solo para Administrador
            </h5>
        </div>
        @if ($configuracion->logo)
            <div class="form-logo">
                {{-- <img src="{{ asset('app/img/logo.png') }}" alt="Instituto Arzobispo Loayza"> --}}
                {{-- NAVIDAD --}}
                <img src="{{ asset($configuracion->logo) }}" alt="Instituto Arzobispo Loayza" style="width: 60%">
            </div>
        @endif
        <form method="post" action="{{ route('auth.login.post') }}">
            @csrf
            <div class="form-group">
                <input type="text" class="form-input {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                    id="email" placeholder="Usuario" value="{{ old('email') }}" required>
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <input type="password" class="form-input {{ $errors->has('password') ? ' is-invalid' : '' }}"
                    name="password" id="password" placeholder="Contraseña" required>
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <button type="submit" class="button">Iniciar Sesión</button>
            <br>
            {{-- Se Aumento  --}}
            <a href="{{ route('index') }}" class="return-label">Regresar a la página principal</a>
        </form>
        <!-- Footer -->

    </div>

    <footer class="foologin">
        <p>&copy; 2024 Instituto Arzobispo Loayza. Todos los derechos reservados.</p>
    </footer>
</section>
<style>
    .login {
        flex-direction: column;
        justify-content: space-between;
    }

    .foologin {
        margin-top: 50px;
        justify-content: space-between;
        text-align: center;
        font-size: 12px;
        color: #ffffff;
    }
</style>

</body>

</html>
