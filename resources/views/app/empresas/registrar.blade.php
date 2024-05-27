@extends('app.index')

@section('styles')
    <link rel="stylesheet" href="{{ asset('app/css/avisos/index.min.css') }}">
@endsection

<style>
    .btn_registro{ 
        font-size: 20px !important;
    }
    .cajita_btn{
        margin-bottom: 20px;
    }

    @media screen and (max-width:767px){
        .img_de_cv{
            display: none !important;
        }
    }
    .caja_img_espera{
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        margin: 0 auto;
    }
    .item_img_espera{
        width: 70%;
        margin: 0 auto;
        text-align: center;
    }

</style>

@section('content')

    {{-- <div id="main">

        <div id="loading-avisos">
            <p>Cargando...</p>
        </div>

        <div class="head-section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3>Ficha de Registro</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-md-2 filter-cont">
                    <div class="filter"></div>
                </div>
                <div class="col-md-8">


                    <div class="mt-3 mb-3">
                        <label for="">Registrarse Como:</label>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-4 col-sm-6 cajita_btn">
                            <button class="btn btn-success w-100 btn_registro btn_persona_juridica">Persona Juridica</button>
                        </div>
                        <div class="col-12 col-lg-4 col-sm-6 cajita_btn">
                            <button class="btn btn-success w-100 btn_registro btn_persona_natural">Persona Natural</button>
                        </div>
                        <div class="col-12 col-lg-4 col-sm-12 cajita_btn">
                            <button class="btn btn-success w-100 btn_registro btn_persona_natural_empresa">Persona Natural con Negocio</button>
                        </div>
                    </div>
                    
                    <div class="caja_img_espera mt-5 pt-5">
                        <div class="item_img_espera">
                            <object data="{{ asset('app/img/lupa.svg') }}" type=""></object>
                        </div>
                    </div>

                    <form id="registro_empresas" enctype="multipart/form-data" action="{{ route('empresa.registrar_empresa.post') }}" class="formulario" method="post" hidden>
                        @csrf
                        <div class="card aviso">
                            <h4 class="mt-1 mb-3 tipo_persona"></h4>

                            <div class="mt-2">
                                <label for=""><b class="primera_data_label"></b></label>
                            </div>

                            <input type="hidden" id="tipo_persona_id" name="tipo_persona" value="" required>

                            <div class="form-group row">
                                <div class="col-md-6 mt-2">
                                    <input autocomplete="off" type="text" class="form-input" name="" id="dni" minlength="7" maxlength="9" onkeypress="return isNumberKey(event)" placeholder="Escriba su DNI para autocompletar los datos" required>
                                    <input autocomplete="off" type="text" class="form-input {{ $errors->has('ruc') ? ' is-invalid' : '' }}" value="{{ old('ruc') }}" name="" id="ruc" minlength="10" maxlength="12" onkeypress="return isNumberKey(event)" placeholder="" required>
                                    @if ($errors->has('ruc'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('ruc') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-6 mt-2">
                                    <input type="text" class="form-input {{ ($errors->has('nombre_comercial') || $errors->has('link')) ? ' is-invalid' : '' }}" value="{{ old('nombre_comercial') }}"  name="nombre_comercial" id="nombre_comercial" placeholder="Nombre de la empresa" required>
                                    @if ($errors->has('nombre_comercial'))
                                    <span class="invalid-feedback" role="alert">
                                      <strong>{{ $errors->first('nombre_comercial') }}</strong>
                                    </span>
                                    @endif
                                    @if($errors->has('link'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('link') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 mt-2">
                                    <input type="text" class="form-input" value="" name="name_comercio" id="name_comercio"  placeholder="Nombre Comercial" required>
                                </div>
    
                                <div class="col-md-6 mt-2">
                                    <input type="text" class="form-input {{ $errors->has('razon_social') ? ' is-invalid' : '' }}" value="{{ old('razon_social') }}" name="razon_social" id="razon_social"
                                           placeholder="Razón Social" required>
                                    @if ($errors->has('razon_social'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('razon_social') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <select class="form-input" name="actividad_economica_empresa" id="actividad_economica_empresa" required>
                                        <option value="" hidden>Actividad Económica de la Empresa</option>
                                        @foreach($ActividadEconomica as $q)
                                            <option value="{{$q->id }}">{{ $q->codigo }} / {{$q->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6" id="caja_logo_item">
                                    <label for="logo" class="logo_name">Importar Logo</label>
                                    <input type="file" class="form-input" name="logo" id="logo" >
                                </div>
                            </div>

                            <div class="mt-2">
                                <label for=""><b>Datos de la Ubicación</b></label>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <input type="text" class="form-input {{ $errors->has('direccion') ? ' is-invalid' : '' }}" value="{{ old('direccion') }}" name="direccion" id="direccion" placeholder="Dirección exacta de la empresa" required>
                                    @if ($errors->has('direccion'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('direccion') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-input" name="referencia" id="referencia" placeholder="Referencia" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <select name="provincia_id" id="provincia_id" class="form-input {{ $errors->has('provincia_id') ? ' is-invalid' : '' }}" required>
                                        <option value="">Ciudad</option>
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
                                    <input type="text" class="form-input {{ $errors->has('telefono') ? ' is-invalid' : '' }}" value="{{ old('telefono') }}" name="telefono" id="telefono" minlength="9" maxlength="9" onkeypress="return isNumberKey(event)" placeholder="Teléfono de la Empresa" required>
                                    @if ($errors->has('telefono'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('telefono') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="form-input {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" name="email" id="email" placeholder="Correo electrónico">
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6" hidden>
                                    <input type="text" class="form-input {{ $errors->has('pagina_web') ? ' is-invalid' : '' }}" value="{{ old('pagina_web') }}" name="pagina_web" id="pagina_web" placeholder="Página web">
                                </div>
                            </div>
                            <div class="form-group row">
                            </div>

                            <div class="form-group row" id="caja_descripcion_item">
                                <div class="col-md-12">
                                    <textarea name="descripcion" id="descripcion" class="form-input {{ $errors->has('descripcion') ? ' is-invalid' : '' }}" value="{{ old('descripcion') }}" cols="30" rows="5" placeholder="Descripción"></textarea>
                                    @if ($errors->has('descripcion'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('descripcion') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-2">
                                <label for=""><b>Datos del Contacto</b></label>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 mt-2" id="cajita_nombre_contacto">
                                    <input type="text" name="nombre_contacto" id="nombre_contacto"  class="form-input {{ $errors->has('nombre_contacto') ? ' is-invalid' : '' }}" value="{{ old('nombre_contacto') }}"  placeholder="Nombres y Apellidos del contacto">
                                    @if ($errors->has('nombre_contacto'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nombre_contacto') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 mt-2" hidden>
                                    <input type="text" name="apellido_contacto" id="apellido_contacto"  class="form-input {{ $errors->has('apellido_contacto') ? ' is-invalid' : '' }}" value="{{ old('apellido_contacto') }}" placeholder="Apellido del contacto">
                                    @if ($errors->has('apellido_contacto'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('apellido_contacto') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 mt-2" id="caja_cargo_contacto_item">
                                    <input type="text" name="cargo_contacto" id="cargo_contacto"  class="form-input {{ $errors->has('cargo_contacto') ? ' is-invalid' : '' }}" value="{{ old('cargo_contacto') }}" placeholder="Cargo del contacto" required>
                                    @if ($errors->has('cargo_contacto'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('cargo_contacto') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 mt-2">
                                    <input type="text" name="telefono_contacto" id="telefono_contacto" value="{{ old('telefono_contacto') }}" minlength="9" maxlength="9" onkeypress="return isNumberKey(event)" class="form-input {{ $errors->has('telefono_contacto') ? ' is-invalid' : '' }}" placeholder="Teléfono del contacto">
                                    @if ($errors->has('telefono_contacto'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('telefono_contacto') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 mt-2">
                                    <input type="email" name="email_contacto" id="email_contacto"  class="form-input {{ $errors->has('email_contacto') ? ' is-invalid' : '' }}" value="{{ old('email_contacto') }}" placeholder="Correo electrónico del contacto">
                                    @if ($errors->has('email_contacto'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email_contacto') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div id="datos_del_paciente" hidden>
                                <div class="mt-2">
                                    <label for=""><b>Datos del Paciente</b></label>
                                </div>             
                                
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <input type="text" name="nombre_paciente" id="nombre_paciente"  class="form-input"  placeholder="Nombre del Paciente">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="enfermedad_paciente" id="enfermedad_paciente"  class="form-input"  placeholder="Indique la Enfermedad o Discapacidad">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12" id="">
                                        <label class=""><b>Cargar Evidencias :</b>  Ingrese al siguiente <b><a href="https://forms.gle/DNDe5ZXxK7HJK1L76" target="_blank" style="display: inline;">Enlace</a></b> para que pueda archivar las evidencias del paciente.</label>
                                        <input type="text" class="form-input" name="evidencias_paciente" id="evidencias_paciente" placeholder="Ingrese el link de su archivo pdf o img de la evidencia del paciente." hidden>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group row">
                            </div>
                        </div>

                        <div class="card aviso mt-2">
                            <button type="submit" id="btn_btn_registrar_empresa">Registrar</button>
                            <a href="{{ route('index') }}" class="text-uppercase">Regresar</a>
                        </div>
                    </form>

                </div>

                <div class="col-md-2 text-center img_de_cv">
                    <a href="javascript:void(0)">
                        <img src="{{ asset('app/img/banner-cv.jpg') }}" alt="">
                    </a>
                </div>
            </div>
        </div>

    </div> --}}


    <script src="https://kit.fontawesome.com/6f8129a9b1.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('app/css/home/login.css') }}">
    <section class="section_login ">
        <div class="content_view_login">
            <div class="sect_login flex_wrap sect_responsive_login">

                <div class="content_login content_responsive_empleador">
                    <div class="content_titulo_login">
                        <img src="{{ asset('app/img/logo_ial.png') }}" alt=""><br><br>
                        <span>CREAR MI CUENTA</span>
                        <p class="title_">BOLSA DE TRABAJO IAL</p>
                    </div>
                    <div class="section_page_login">
                        <a href="{{ route('loginEmpresa') }}" class="active-line-bottom" style="padding:22px !important">Empleador</a>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <button class="btn_eleccion_empleador btn_eleccion_empleador_active btn_persona_juridica">Persona Jurídica</button>
                        </div>
                        <div class="col-md-12 mb-3">
                            <button class="btn_eleccion_empleador btn_persona_natural">Persona Natural</button>
                        </div>
                        <div class="col-md-12 mb-3">
                            <button class="btn_eleccion_empleador btn_persona_natural_empresa">Persona Natural con Negocio</button>
                        </div>

                    </div>

                </div>

                <div class="content_crear_empleador">
                    <form id="registro_empresas" enctype="multipart/form-data" action="{{ route('empresa.registrar_empresa.post') }}" class="formulario" method="post" hidden>
                        @csrf
                        <div class="aviso">
                            <h4 class="mt-1 mb-3 tipo_persona" style="color:#0072bf"></h4>

                            <div class="my-2" style="color:#0072bf">
                                <label for=""><b class="primera_data_label"></b></label>
                            </div>

                            <input type="hidden" id="tipo_persona_id" name="tipo_persona" value="" required>

                            <div class="form-group row">
                                <div class="col-lg-4 col-md-6 mb-2">
                                    <div class="input-group">
                                        <input autocomplete="off" type="text" style="border:2px solid #0072bf !important;" class="form-control" name="" id="dni" maxlength="8" onkeypress="return isNumberKey(event)" placeholder="Escriba su DNI" required>
                                        <input autocomplete="off" type="text" style="border:2px solid #0072bf !important;" class="form-control {{ $errors->has('ruc') ? ' is-invalid' : '' }}" value="{{ old('ruc') }}" name="" id="ruc" minlength="10" maxlength="13" onkeypress="return isNumberKey(event)" placeholder="" required>
                                        <div class="input-group-append">
                                            <a href="javascript:void(0);" class="btn btn-success px-3" id="buscar_empleador">Buscar</a>
                                        </div>
                                        @if ($errors->has('ruc'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('ruc') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 mb-2">
                                    <input type="text" class="form-control-m {{ ($errors->has('nombre_comercial') || $errors->has('link')) ? ' is-invalid' : '' }}" value="{{ old('nombre_comercial') }}"  name="nombre_comercial" id="nombre_comercial" placeholder="Nombre de la empresa" required>
                                    @if ($errors->has('nombre_comercial'))
                                    <span class="invalid-feedback" role="alert">
                                      <strong>{{ $errors->first('nombre_comercial') }}</strong>
                                    </span>
                                    @endif
                                    @if($errors->has('link'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('link') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-lg-4 col-md-6 mb-2">
                                    <input type="text" class="form-control-m" value="" name="name_comercio" id="name_comercio"  placeholder="Nombre Comercial" required>
                                </div>
    
                                <div class="col-lg-4 col-md-6 mb-2">
                                    <input type="text" class="form-control-m {{ $errors->has('razon_social') ? ' is-invalid' : '' }}" value="{{ old('razon_social') }}" name="razon_social" id="razon_social"
                                           placeholder="Razón Social" required>
                                    @if ($errors->has('razon_social'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('razon_social') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 mb-2">
                                    <select class="form-control-m" name="actividad_economica_empresa" id="actividad_economica_empresa" required>
                                        <option value="" hidden>Actividad Económica de la Empresa</option>
                                        @foreach($ActividadEconomica as $q)
                                            <option value="{{$q->id }}">{{ $q->codigo }} / {{$q->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6" id="caja_logo_item">
                                    <label for="logo" class="logo_name" style="color:#0072bf">Importar Logo</label>
                                    <input type="file" class="form-control-m" name="logo" id="logo" >
                                </div>
                            </div>

                            <div class="my-2" style="color:#0072bf">
                                <label for=""><b>Datos de la Ubicación</b></label>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-4 col-md-6 mb-2">
                                    <input type="text" class="form-control-m {{ $errors->has('direccion') ? ' is-invalid' : '' }}" value="{{ old('direccion') }}" name="direccion" id="direccion" placeholder="Dirección exacta de la empresa" required>
                                    @if ($errors->has('direccion'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('direccion') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-lg-4 col-md-6 mb-2">
                                    <input type="text" class="form-control-m" name="referencia" id="referencia" placeholder="Referencia" required>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-2">
                                    <select name="provincia_id" id="provincia_id" class="form-control-m {{ $errors->has('provincia_id') ? ' is-invalid' : '' }}" required>
                                        <option value="">Ciudad</option>
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
                                <div class="col-lg-4 col-md-6 mb-2">
                                    <select name="distrito_id" id="distrito_id" class="form-control-m {{ $errors->has('distrito_id') ? ' is-invalid' : '' }}" required>
                                        <option value="">Distrito</option>
                                    </select>
                                    @if ($errors->has('distrito_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('distrito_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-lg-4 col-md-6 mb-2">
                                    <input type="text" class="form-control-m {{ $errors->has('telefono') ? ' is-invalid' : '' }}" value="{{ old('telefono') }}" name="telefono" id="telefono" minlength="9" maxlength="9" onkeypress="return isNumberKey(event)" placeholder="Teléfono de la Empresa" required>
                                    @if ($errors->has('telefono'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('telefono') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-lg-4 col-md-6 mb-2">
                                    <input type="email" class="form-control-m {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" name="email" id="email" placeholder="Correo electrónico">
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-lg-4 col-md-6 mb-2" hidden>
                                    <input type="text" class="form-control-m {{ $errors->has('pagina_web') ? ' is-invalid' : '' }}" value="{{ old('pagina_web') }}" name="pagina_web" id="pagina_web" placeholder="Página web">
                                </div>
                            </div>
                            <div class="form-group row" id="caja_descripcion_item">
                                <div class="col-md-12">
                                    <textarea name="descripcion" id="descripcion" class="form-control-m {{ $errors->has('descripcion') ? ' is-invalid' : '' }}" value="{{ old('descripcion') }}" cols="30" rows="5" placeholder="Descripción"></textarea>
                                    @if ($errors->has('descripcion'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('descripcion') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="my-2" style="color:#0072bf">
                                <label for=""><b>Datos del Contacto</b></label>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 mt-2" id="cajita_nombre_contacto">
                                    <input type="text" name="nombre_contacto" id="nombre_contacto"  class="form-control-m {{ $errors->has('nombre_contacto') ? ' is-invalid' : '' }}" value="{{ old('nombre_contacto') }}"  placeholder="Nombres y Apellidos del contacto">
                                    @if ($errors->has('nombre_contacto'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nombre_contacto') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 mt-2" hidden>
                                    <input type="text" name="apellido_contacto" id="apellido_contacto"  class="form-control-m {{ $errors->has('apellido_contacto') ? ' is-invalid' : '' }}" value="{{ old('apellido_contacto') }}" placeholder="Apellido del contacto">
                                    @if ($errors->has('apellido_contacto'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('apellido_contacto') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 mt-2" id="caja_cargo_contacto_item">
                                    <input type="text" name="cargo_contacto" id="cargo_contacto"  class="form-control-m {{ $errors->has('cargo_contacto') ? ' is-invalid' : '' }}" value="{{ old('cargo_contacto') }}" placeholder="Cargo del contacto" required>
                                    @if ($errors->has('cargo_contacto'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('cargo_contacto') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 mt-2">
                                    <input type="text" name="telefono_contacto" id="telefono_contacto" value="{{ old('telefono_contacto') }}" minlength="9" maxlength="9" onkeypress="return isNumberKey(event)" class="form-control-m {{ $errors->has('telefono_contacto') ? ' is-invalid' : '' }}" placeholder="Teléfono del contacto">
                                    @if ($errors->has('telefono_contacto'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('telefono_contacto') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 mt-2">
                                    <input type="email" name="email_contacto" id="email_contacto"  class="form-control-m {{ $errors->has('email_contacto') ? ' is-invalid' : '' }}" value="{{ old('email_contacto') }}" placeholder="Correo electrónico del contacto">
                                    @if ($errors->has('email_contacto'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email_contacto') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div id="datos_del_paciente" hidden>
                                <div class="my-2" style="color:#0072bf">
                                    <label for=""><b>Datos del Paciente</b></label>
                                </div>             
                                
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <input type="text" name="nombre_paciente" id="nombre_paciente"  class="form-control-m"  placeholder="Nombre del Paciente">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="enfermedad_paciente" id="enfermedad_paciente"  class="form-control-m"  placeholder="Indique la Enfermedad o Discapacidad">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12" id="">
                                        <label class=""><b style="color:#0072bf">Cargar Evidencias :</b>  Ingrese al siguiente <b><a href="https://forms.gle/DNDe5ZXxK7HJK1L76" target="_blank" style="display: inline;">Enlace</a></b> para que pueda archivar las evidencias del paciente.</label>
                                        <input type="text" class="form-control-m" name="evidencias_paciente" id="evidencias_paciente" placeholder="Ingrese el link de su archivo pdf o img de la evidencia del paciente." hidden>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="mt-2 text-center">
                            <button type="submit" class="mb-2 btn-m btn-primary-gradient" id="btn_btn_registrar_empresa">Registrar</button>
                        </div>
                        <div class="text-center text-primary">
                            <a href="{{ route('loginEmpresa') }}" style="color:#00c3f4">Regresar</a>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </section>



@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('app/plugins/ckeditor/ckeditor.js') }}"></script>
    <script>
        // CKEDITOR.replace( 'descripcion' );
        // CKEDITOR.replace( 'evidencias' );
    </script>
    <script type="text/javascript">
        $(function(){
            $("form").on('submit', function (e) {
                for (var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances[instanceName].updateElement();
                }
            });

            $("#logo").change(function() {
                const file = this.files[0];
                if(file != null)
                    $(".logo_name").text(file.name);
                else
                    $(".logo_name").text("Importar Logo");
            });
        });
    </script>
    <script src="{{ asset('app/js/empresas/registro.persona.js') }}"></script>
@endsection

