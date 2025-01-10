@extends('app.index')

@section('styles')
    <link rel="stylesheet" href="{{ asset('app/css/avisos/index.min.css') }}">
    <link rel="stylesheet" href="{{ asset('app/plugins/datepicker/datepicker3.css') }}">
    <style type="text/css">
        .hidden {
            display: none !important;
        }
    </style>
@endsection

@section('content')
    <script src="https://kit.fontawesome.com/6f8129a9b1.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('app/css/home/login.css') }}">
    <section class="section_login">
        <div class="content_view_login">
            <style>
                .step-guide {
                    display: flex;
                    flex-direction: column;
                    gap: 15px;
                    font-size: 14px;
                }

                .step-item {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    padding: 10px;
                    border: 1px solid #0072bf;
                    border-radius: 8px;
                    background-color: #f9f9f9;
                }

                .step-number {
                    width: 30px;
                    height: 30px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    background-color: #0072bf;
                    color: white;
                    font-weight: bold;
                    border-radius: 50%;
                    font-size: 16px;
                }

                .step-content {
                    flex: 1;
                }

                .btn-guide {
                    color: #00c3f4;
                    font-weight: bold;
                }
            </style>
            <div class="row">
                <div class="col-12 col-lg-4 sect_login sect_responsive_login">
                    <div class="content_crear_alumno"
                        style="padding: 20px; width: 950px; margin-left: 90px;max-height:500px;margin: 30px 30px 30px 30px;">
                        <h4 class="text-primary">Guía de Registro para crear tu cuenta</h4>
                        <div class="step-guide">
                            <div class="step-item">
                                <div class="step-number">1</div>
                                <div class="step-content">
                                    <strong>DNI:</strong> Ingresa tu número de DNI y presiona <span
                                        class="btn-guide">"Buscar"</span>.
                                </div>
                            </div>
                            <div class="step-item">
                                <div class="step-number">2</div>
                                <div class="step-content">
                                    <strong>Nombres y Apellidos:</strong> Se completarán automáticamente después de buscar
                                    tu
                                    DNI.
                                </div>
                            </div>
                            <div class="step-item">
                                <div class="step-number">3</div>
                                <div class="step-content">
                                    <strong>Teléfono:</strong> Ingresa un número válido de 9 dígitos.
                                </div>
                            </div>
                            <div class="step-item">
                                <div class="step-number">4</div>
                                <div class="step-content">
                                    <strong>Correo Electrónico:</strong> Asegúrate de ingresar un correo válido.
                                </div>
                            </div>
                            <div class="step-item">
                                <div class="step-number">5</div>
                                <div class="step-content">
                                    <strong>Fecha de Nacimiento:</strong> Se completará automáticamente al buscar tu DNI.
                                </div>
                            </div>
                            <div class="step-item">
                                <div class="step-number">6</div>
                                <div class="step-content">
                                    <strong>Ubicación:</strong> Selecciona tu departamento y distrito.
                                </div>
                            </div>
                            <div class="step-item">
                                <div class="step-number">7</div>
                                <div class="step-content">
                                    <strong>Programa de Estudio:</strong> Elige tu carrera.
                                </div>
                            </div>
                            <div class="step-item">
                                <div class="step-number">8</div>
                                <div class="step-content">
                                    <strong>Grado Académico:</strong> Indica si eres estudiante, egresado o titulado.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-8 sect_login sect_responsive_login">
                    <div class="content_crear_alumno">
                        <div class="content_titulo_login">
                            <img src="{{ asset('app/img/logo_ial.png') }}" alt=""><br><br>
                            <span>CREAR MI CUENTA</span>
                            <p class="title_">BOLSA DE TRABAJO IAL</p>
                        </div>
                        <div class="section_page_login">
                            <a href="{{ route('index') }}" class="active-line-bottom"
                                style="padding:22px !important">Alumno</a>
                        </div>
                        <form enctype="multipart/form-data" action="{{ route('alumno.registrar_alumno.post') }}"
                            class="form-login" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="input-group">
                                        <input type="text" autocomplete="off"
                                            style="border:2px solid #0072bf !important;" maxlength="11"
                                            class="form-control {{ $errors->has('dni') ? ' is-invalid' : '' }}"
                                            value="{{ old('dni') }}" name="dni" id="dni"
                                            onkeypress="return isNumberKey(event)" placeholder="Ingrese su DNI" required>
                                        <div class="input-group-append">
                                            <a href="javascript:void(0);" class="btn btn-success px-3"
                                                id="buscar_dni_alumno">Buscar</a>
                                        </div>
                                    </div>

                                    <!-- Mostrar el mensaje de error debajo del campo -->
                                    @if ($errors->has('dni'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('dni') }}</strong>
                                        </div>
                                    @endif


                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="text" placeholder="Nombres"
                                        class="form-control-m {{ $errors->has('nombres') ? ' is-invalid' : '' }}"
                                        value="{{ old('nombres') }}" name="nombres" id="nombres" readonly>
                                    @if ($errors->has('nombres'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nombres') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="text" placeholder="Apellidos"
                                        class="form-control-m {{ $errors->has('apellidos') ? ' is-invalid' : '' }}"
                                        value="{{ old('apellidos') }}" name="apellidos" id="apellidos" readonly>
                                    @if ($errors->has('apellidos'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('apellidos') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="text" placeholder="Teléfono"
                                        class="form-control-m {{ $errors->has('telefono') ? ' is-invalid' : '' }}"
                                        value="{{ old('telefono') }}" name="telefono" id="telefono" minlength="9"
                                        maxlength="9" onkeypress="return isNumberKey(event)" readonly>
                                    @if ($errors->has('telefono'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('telefono') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="email" placeholder="Correo Electronico" autocomplete="off"
                                        class="form-control-m {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                        value="{{ old('email') }}" name="email" id="email" required>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="text" placeholder="Fecha de Nacimiento"
                                        class="form-control-m {{ $errors->has('fecha_nacimiento') ? ' is-invalid' : '' }}"
                                        name="fecha_nacimiento" id="fecha_nacimiento"
                                        value="{{ old('fecha_nacimiento') }}" autocomplete="off" readonly>
                                    @if ($errors->has('fecha_nacimiento'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('fecha_nacimiento') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 mb-3">
                                    <select name="provincia_id" id="provincia_id"
                                        class="form-control-m {{ $errors->has('provincia_id') ? ' is-invalid' : '' }}"
                                        required>
                                        <option value="" hidden>-- Departamento --</option>
                                        @foreach ($Provincias as $q)
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
                                    <select name="distrito_id" id="distrito_id"
                                        class="form-control-m {{ $errors->has('distrito_id') ? ' is-invalid' : '' }}"
                                        required>
                                        <option value="" hidden>-- Distrito --</option>
                                    </select>
                                    @if ($errors->has('distrito_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('distrito_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 mb-3">
                                    <select name="area_id" id="area_id"
                                        class="form-control-m {{ $errors->has('area_id') ? ' is-invalid' : '' }}"
                                        required>
                                        <option value="" hidden>-- Programa de Estudio --</option>
                                        @foreach ($Areas as $q)
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
        </div>
    </section>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('app/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app/plugins/datepicker/locales/bootstrap-datepicker.es.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app/plugins/datepicker/bootstrap-datepicker.config.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app/js/alumno/registrar.js') }}"></script>
@endsection
