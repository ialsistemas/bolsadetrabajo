@extends('app.index')

@section('styles')
    <link rel="stylesheet" href="{{ asset('app/css/avisos/index.min.css') }}">
    <link rel="stylesheet" href="{{ asset('app/plugins/datepicker/datepicker3.css') }}">
    <style type="text/css">
        .hidden{ display: none !important;}
    </style>
@endsection

@section('content')

    {{-- <div id="main">

        <div id="loading-avisos">
            <p>Cargando...</p>
        </div>

        <div class="head-section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3>Crear mi cuenta</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-md-3 filter-cont">
                    <div class="filter"></div>
                </div>
                <div class="col-md-7">
                    <form enctype="multipart/form-data" action="{{ route('alumno.registrar_alumno.post') }}" class="formulario" method="post">
                        @csrf
                        <div class="card aviso">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <input type="text" class="form-input {{ $errors->has('nombres') ? ' is-invalid' : '' }}" value="{{ old('nombres') }}" name="nombres" id="nombres"  placeholder="Nombres" required>
                                    @if ($errors->has('nombres'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nombres') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-input {{ $errors->has('apellidos') ? ' is-invalid' : '' }}" value="{{ old('apellidos') }}"  name="apellidos" id="apellidos" placeholder="Apellidos" required>
                                    @if ($errors->has('apellidos'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('apellidos') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <input type="text" class="form-input {{ $errors->has('telefono') ? ' is-invalid' : '' }}"  value="{{ old('telefono') }}"   name="telefono" id="telefono" minlength="9" maxlength="9" onkeypress="return isNumberKey(event)" placeholder="Teléfono" required>
                                    @if ($errors->has('telefono'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('telefono') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-input border border-dark {{ $errors->has('dni') ? ' is-invalid' : '' }}" value="{{ old('dni') }}" name="dni" id="dni" onkeypress="return isNumberKey(event)" placeholder="DNI" required>
                                    <small id="validationDni" class="form-text text-muted">
                                        Ingrese su dni para autocompletar su información.
                                    </small>
                                    @if ($errors->has('dni'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('dni') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <input type="email" class="form-input {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" name="email" id="email" placeholder="Correo electrónico" required>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-input {{ $errors->has('fecha_nacimiento') ? ' is-invalid' : '' }}" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento')}}" placeholder="Fecha de Nacimiento" autocomplete="off" required>
                                    @if ($errors->has('fecha_nacimiento'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('fecha_nacimiento') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <select name="provincia_id" id="provincia_id" class="form-input {{ $errors->has('provincia_id') ? ' is-invalid' : '' }}" required>
                                        <option value="">Departamento</option>
                                        @foreach($Provincias as $q)
                                            <option value="{{ $q->id }}">{{ $q->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('provincia_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('provincia_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <select name="distrito_id" id="distrito_id" class="form-input {{ $errors->has('distrito_id') ? ' is-invalid' : '' }}" required>
                                        <option value="">Distrito</option>
                                    </select>
                                    @if ($errors->has('distrito_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('distrito_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <select name="area_id" id="area_id" class="form-input {{ $errors->has('area_id') ? ' is-invalid' : '' }}" required>
                                        <option value="">Programa de estudios</option>
                                        @foreach($Areas as $q)
                                            <option value="{{ $q->id }}">{{ $q->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('area_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('area_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <select name="egresado" id="egresado" class="form-input" required>
                                        <option value="">Grado académico</option>
                                        <option value="0">Estudiante</option>
                                        <option value="1">Egresado</option>
                                        <option value="2">Titulado</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card aviso mt-2">
                            <button id="btn-registrar" disabled type="submit">Registrar</button>
                            <a href="{{ route('index') }}" class="text-uppercase">Regresar</a>
                        </div>
                    </form>
                </div>

                <div class="col-md-2 text-center">
                    <a href="javascript:void(0)">
                        <img src="{{ asset('app/img/banner-cv.jpg') }}" alt="">
                    </a>
                </div>
            </div>
        </div>

    </div>

    <style>
        button{
            cursor : pointer
        }
        button:disabled,
        button[disabled]{
            opacity:  0.3;
            cursor : default
        }
    </style> --}}

    <script src="https://kit.fontawesome.com/6f8129a9b1.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('app/css/home/login.css') }}">
    <section class="section_login">
        <div class="content_view_login">
            {{-- <div class="sect_img"> 
                <img src="{{ asset('app/img/logo_ial.png') }}" alt="">
            </div>   --}}
            <div class="sect_login sect_responsive_login">
                <div class="content_crear_alumno">
                    <div class="content_titulo_login">
                        <img src="{{ asset('app/img/logo_ial.png') }}" alt=""><br><br>
                        <span>CREAR MI CUENTA</span>
                        <p class="title_">BOLSA DE TRABAJO IAL</p>
                    </div>
                    <div class="section_page_login">
                        <a href="{{ route('index') }}" class="active-line-bottom" style="padding:22px !important">Alumno</a>
                    </div>
                    <form enctype="multipart/form-data" action="{{ route('alumno.registrar_alumno.post') }}" class="form-login" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="input-group">
                                    <input type="text" autocomplete="off" style="border:2px solid #0072bf !important;" maxlength="11" class="form-control {{ $errors->has('dni') ? ' is-invalid' : '' }}" value="{{ old('dni') }}" name="dni" id="dni" onkeypress="return isNumberKey(event)" placeholder="Ingrese su DNI" required>
                                    <div class="input-group-append">
                                        <a href="javascript:void(0);" class="btn btn-success px-3" id="buscar_dni_alumno">Buscar</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="text" placeholder="Nombres" class="form-control-m {{ $errors->has('nombres') ? ' is-invalid' : '' }}" value="{{ old('nombres') }}" name="nombres" id="nombres" readonly>
                                @if ($errors->has('nombres'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nombres') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="text" placeholder="Apellidos" class="form-control-m {{ $errors->has('apellidos') ? ' is-invalid' : '' }}" value="{{ old('apellidos') }}"  name="apellidos" id="apellidos" readonly>
                                @if ($errors->has('apellidos'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('apellidos') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="text" placeholder="Teléfono" class="form-control-m {{ $errors->has('telefono') ? ' is-invalid' : '' }}"  value="{{ old('telefono') }}"   name="telefono" id="telefono" minlength="9" maxlength="9" onkeypress="return isNumberKey(event)" readonly>
                                @if ($errors->has('telefono'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('telefono') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="email" placeholder="Correo Electronico" autocomplete="off" class="form-control-m {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" name="email" id="email" required>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="text" placeholder="Fecha de Nacimiento" class="form-control-m {{ $errors->has('fecha_nacimiento') ? ' is-invalid' : '' }}" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento')}}" autocomplete="off" readonly>
                                @if ($errors->has('fecha_nacimiento'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('fecha_nacimiento') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <select name="provincia_id" id="provincia_id" class="form-control-m {{ $errors->has('provincia_id') ? ' is-invalid' : '' }}" required>
                                    <option value="" hidden>-- Departamento --</option>
                                    @foreach($Provincias as $q)
                                        <option value="{{ $q->id }}">{{ $q->nombre }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('provincia_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('provincia_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <select name="distrito_id" id="distrito_id" class="form-control-m {{ $errors->has('distrito_id') ? ' is-invalid' : '' }}" required>
                                    <option value="" hidden>-- Distrito --</option>
                                </select>
                                @if ($errors->has('distrito_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('distrito_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <select name="area_id" id="area_id" class="form-control-m {{ $errors->has('area_id') ? ' is-invalid' : '' }}" required>
                                    <option value="" hidden>-- Programa de Estudio --</option>
                                    @foreach($Areas as $q)
                                        <option value="{{ $q->id }}">{{ $q->nombre }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('area_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('area_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <select name="egresado" id="egresado" class="form-control-m" required>
                                    <option value="" hidden>-- Grado Académico --</option>
                                    <option value="0">Estudiante</option>
                                    <option value="1">Egresado</option>
                                    <option value="2">Titulado</option>
                                </select>
                            </div>

                        </div>



                        <div class="">
                            <button type="submit" class="btn-m btn-primary-gradient">Crear Cuenta</button>
                        </div>
                        <br>
                        <div class="text-center text-primary">
                            <a href="{{ route('index') }}" style="color:#00c3f4">Regresar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('app/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app/plugins/datepicker/locales/bootstrap-datepicker.es.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app/plugins/datepicker/bootstrap-datepicker.config.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app/js/alumno/registrar.js') }}"></script>
@endsection

