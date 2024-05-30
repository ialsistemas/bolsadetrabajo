{{-- @extends('app.index') --}}

@section('styles')
    {{-- <link rel="stylesheet" href="{{ asset('app/css/home/index.css') }}"> --}}
@endsection

@section('content')

    {{-- <div id="main">
        <div class="banner-header">
            <img src="{{ asset('app/img/bolsa-de-trabajo_azul_oscuro.jpg') }}" class="img-fluid" alt="Bolsa Laboral">
        </div>
        <div class="auth-forms">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <form action="{{ route('alumno.login.post') }}" method="post" class="assign">
                            @csrf
                            <h5>Aplicar a un empleo</h5>
                            <div class="form-group">
                                <input type="text" id="usuario_alumno" name="usuario_alumno" class="form-input {{ $errors->has('usuario_alumno') ? ' is-invalid' : '' }}" value="{{ old('usuario_alumno') }}" required>
                                <label for="usuario_alumno">Usuario</label>
                                @if ($errors->has('usuario_alumno'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('usuario_alumno') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="password" id="password_alumno" name="password" class="form-input {{ $errors->has('password_alumno') ? ' is-invalid' : '' }}" required>
                                <label for="password_alumno">Contraseña</label>
                                @if ($errors->has('password_alumno'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password_alumno') }}</strong>
                                </span>
                                @endif
                            </div>
                            <button type="submit">Ingresar</button>
                            <a href="{{ route('alumno.crear_alumno') }}" class="text-uppercase">Solicitar acceso</a>
                        </form>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <form action="{{ route('empresa.login.post') }}" method="post" class="publish">
                            @csrf
                            <h5>Publicar una oferta</h5>
                            <div class="form-group">
                                <input type="text" id="usuario_empresa" name="usuario_empresa" class="form-input {{ $errors->has('usuario_empresa') ? ' is-invalid' : '' }}" value="{{ old('usuario_empresa') }}" required>
                                <label for="usuario_empresa">Usuario</label>
                                @if ($errors->has('usuario_empresa'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('usuario_empresa') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="password" id="password_empresa" name="password" class="form-input {{ $errors->has('password_empresa') ? ' is-invalid' : '' }}" required>
                                <label for="password_empresa">Contraseña</label>
                                @if ($errors->has('password_empresa'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password_empresa') }}</strong>
                                </span>
                                @endif
                            </div>
                            <button type="submit">Ingresar</button>
                            <a href="{{ route('empresa.crear_empresa') }}" class="text-uppercase">Crear una cuenta</a>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <div></div>
    </div> --}}

@endsection
<script src="https://kit.fontawesome.com/6f8129a9b1.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="{{ asset('app/css/home/login.css') }}">
<section class="section_login">
    <div class="content_view_login">
        <div class="sect_login">
            <div class="content_login">
                <div class="content_titulo_login">
                    <img src="{{ asset('app/img/logo_ial.png') }}" alt=""><br><br>
                    <span>BIENVENIDOS</span>
                    <p class="title_">BOLSA DE TRABAJO IAL CR</p>
                    <p>Más oportunidades laborales</p>
                    <div class="access_administrador">
                        <a href="{{ route('auth.login') }}"><i style="color: #0072bf; font-size:20px;" class="fa-solid fa-users-between-lines"></i></a>
                    </div>
                </div>
                <div class="section_page_login">
                    <a href="{{ route('index') }}" class="active-line-bottom">Alumno</a>
                    <a href="{{ route('loginEmpresa') }}">Empleador</a>
                </div>
                <form class="form-login" action="{{ route('alumno.login.post') }}" method="post">
                    @csrf
                    <div class="">
                        <label for="" class="text-primary-m">Usuario</label>
                        <input type="text" autocomplete="off" id="usuario_alumno" name="usuario_alumno" class="form-control-m {{ $errors->has('usuario_alumno') ? ' is-invalid' : '' }}" value="{{ old('usuario_alumno') }}" >
                        @if ($errors->has('usuario_alumno'))
                            <span class="invalid-feedback" role="alert">
                            <span style="color:#cd3232; font-weigth:100 !important;">{{ $errors->first('usuario_alumno') }}</span>
                        </span>
                        @endif
                    </div>
                    <br>
                    <div class="">
                        <label for="" class="text-primary-m">Contraseña</label>
                        <div class="control-password">
                            <input type="password" id="password_alumno" name="password" class="form-control-m {{ $errors->has('usuario_alumno') ? ' is-invalid' : '' }}">
                            @if ($errors->has('password_alumno'))
                                <span class="invalid-feedback" role="alert">
                                <span style="color:#cd3232; font-weigth:100 !important;">{{ $errors->first('password_alumno') }}</span>
                            </span>
                            @endif
                            <a href="javascript:void(0);" onclick="togglePasswordVisibility()"><i id="toggleButton" class="fa-solid fa-eye-slash"></i></a>                            
                        </div>
                    </div>
                    <br>
                    <div class="">
                        <button type="submit" class="btn-m btn-primary-gradient">Ingresar <i class="fa-solid fa-right-to-bracket"></i></button>
                    </div>
                    <br>
                    <div class="text-center text-primary">
                        ¿No tienes una cuenta? <a href="{{ route('alumno.crear_alumno') }}" style="color:#00c3f4">Registrate</a>
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