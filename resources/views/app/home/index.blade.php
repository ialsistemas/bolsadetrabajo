<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bolsa de Trabajo</title>
    <link rel="shortcut icon" href="{{ asset('app/img/logo_ial.png') }}" type="image/x-icon">
</head>
<body>
    <script src="https://kit.fontawesome.com/6f8129a9b1.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="{{ asset('app/css/home/login.css') }}">
<section class="section_login">
    <div class="content_view_login"
        style="
    display: flex;
    width: 100%;
    height: 100vh;
    background: url('{{ asset($configuracion->banneruser) }}');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;">
        <div class="sect_login">
            <div class="content_login">
                <div class="content_titulo_login">
                    {{-- <img src="{{ asset('app/img/logo_ial.png') }}" alt=""><br><br> --}}
                    {{-- NAVIDAD --}}
                    @if ($configuracion->logo)
                        <img src="{{ asset($configuracion->logo) }}" alt=""
                            style="width: 50% !important;"><br><br>
                    @endif
                    <span>BIENVENIDOS</span>
                    <p class="title_">BOLSA DE TRABAJO IAL</p>
                    <p>Más oportunidades laborales</p>
                    <div class="access_administrador">
                        <a href="{{ route('auth.login') }}"><i style="color: #0072bf; font-size:20px;"
                                class="fa-solid fa-users-between-lines"></i></a>
                    </div>
                </div>
                <div class="section_page_login">
                    <a href="{{ route('index') }}" class="active-line-bottom">Solo Alumnos</a>
                    <a href="{{ route('loginEmpresa') }}">Solo Empleador</a>
                </div>
                <form class="form-login" action="{{ route('alumno.login.post') }}" method="post">
                    @csrf
                    <div class="">
                        <label for="" class="text-primary-m">DNI del estudiante</label>
                        <input type="text" autocomplete="off" id="usuario_alumno" name="usuario_alumno"
                            class="form-control-m {{ $errors->has('usuario_alumno') ? ' is-invalid' : '' }}"
                            value="{{ old('usuario_alumno') }}">
                        @if ($errors->has('usuario_alumno'))
                            <span class="invalid-feedback" role="alert">
                                <span
                                    style="color:#cd3232; font-weigth:100 !important;">{{ $errors->first('usuario_alumno') }}</span>
                            </span>
                        @endif
                    </div>
                    <br>
                    <div class="">
                        <label for="" class="text-primary-m">Contraseña</label>
                        <div class="control-password">
                            <input type="password" id="password_alumno" name="password"
                                class="form-control-m {{ $errors->has('usuario_alumno') ? ' is-invalid' : '' }}">
                            @if ($errors->has('password_alumno'))
                                <span class="invalid-feedback" role="alert">
                                    <span
                                        style="color:#cd3232; font-weigth:100 !important;">{{ $errors->first('password_alumno') }}</span>
                                </span>
                            @endif
                            <a href="javascript:void(0);" onclick="togglePasswordVisibility()"><i id="toggleButton"
                                    class="fa-solid fa-eye-slash"></i></a>
                        </div>
                    </div>
                    <br>
                    <div class="">
                        <button type="submit" class="btn-m btn-primary-gradient">Ingresar <i
                                class="fa-solid fa-right-to-bracket"></i></button>
                    </div>
                    <br>
                    <div class="text-center text-primary">
                        ¿No tienes una cuenta? <a href="{{ route('alumno.crear_alumno') }}"
                            style="color:#00c3f4">Registrate</a>
                    </div>

                </form>
            </div>

        </div>
    </div>
</section>



<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("password_alumno");
        var toggleButton = document.getElementById("toggleButton");
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleButton.classList.remove("fa-eye-slash");
            toggleButton.classList.add("fa-eye");
        } else {
            passwordInput.type = "password";
            toggleButton.classList.remove("fa-eye");
            toggleButton.classList.add("fa-eye-slash");
        }
    }
</script>
</body>
</html>
