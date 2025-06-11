@extends('app.index')

@section('styles')
    <link rel="stylesheet" href="{{ asset('app/css/avisos/index.min.css') }}">
    <link rel="stylesheet" href="{{ asset('app/css/empresa/perfil.css') }}">
@endsection

@section('content')
    <input type="hidden" id="tipo_de_persona" value="{{ Auth::guard('empresasw')->user()->tipo_persona }}">

    <div id="main">

        <div id="loading-avisos">
            <p>Cargando...</p>
        </div>

        <div class="head-section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3>Mi Perfil</h3>
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
                    <form enctype="multipart/form-data" id="actualizoPerfil" class="formulario"
                        data-ajax-failure="OnFailureActualizoPerfil">
                        @csrf
                        <div id="avisoPerfilEmpresa" class="card aviso">
                            <div class="mb-2">
                                <label><b class="title_data_nombre">Datos de la Empresa</b> </label>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input type="text" class="form-input" value="{{ $Empresa->razon_social }}"
                                        name="razon_social" id="razon_social" placeholder="Razón Social" required>
                                    <span data-valmsg-for="razon_social"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <input type="text" class="form-input" value="{{ $Empresa->nombre_comercial }}"
                                        name="nombre_comercial" id="nombre_comercial" placeholder="Nombre de la Empresa"
                                        required>
                                    <span data-valmsg-for="nombre_comercial"></span>
                                    <span data-valmsg-for="link"></span>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-input" value="{{ $Empresa->ruc }}" name="ruc"
                                        id="ruc" minlength="11" maxlength="11" onkeypress="return isNumberKey(event)"
                                        placeholder="RUC" disabled>
                                    <span data-valmsg-for="ruc"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <select class="form-input" name="actividad_economica" id="actividad_economica">
                                        <option value="" hidden>Actividad Económica</option>
                                        @foreach ($ActividadEconomica as $q)
                                            <option value="{{ $q->id }}"
                                                {{ $Empresa->actividad_economica_empresa == $q->id ? 'selected' : '' }}>
                                                {{ $q->codigo . ' / ' . $q->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-2 mt-2">
                                <label><b>Datos de la Ubicación</b></label>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <select name="distrito_id" id="distrito_id" class="form-input" required>
                                        <option value="">Distrito</option>
                                        @foreach ($Distritos as $q)
                                            <option value="{{ $q->id }}"
                                                {{ $Empresa->distrito_id == $q->id ? 'selected' : '' }}>{{ $q->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span data-valmsg-for="distrito_id"></span>
                                </div>
                                <div class="col-md-6">
                                    <select name="provincia_id" id="provincia_id" class="form-input" required>
                                        <option value="">Ciudad</option>
                                        @foreach ($Provincias as $q)
                                            <option value="{{ $q->id }}"
                                                {{ $Empresa->provincia_id == $q->id ? 'selected' : '' }}>
                                                {{ $q->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <span data-valmsg-for="provincia_id"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input type="text" class="form-input" value="{{ $Empresa->direccion }}"
                                        name="direccion" id="direccion" placeholder="Dirección" required>
                                    <span data-valmsg-for="direccion"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <input type="text" class="form-input" value="{{ $Empresa->telefono }}"
                                        name="telefono" id="telefono" minlength="9" maxlength="9"
                                        onkeypress="return isNumberKey(event)" placeholder="Teléfono" required>
                                    <span data-valmsg-for="telefono"></span>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-input" value="{{ $Empresa->pagina_web }}"
                                        name="pagina_web" id="pagina_web" placeholder="Página web">
                                    <span data-valmsg-for="pagina_web"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <input type="email" class="form-input" value="{{ $Empresa->email }}"
                                        name="email" id="email" placeholder="Correo electrónico">
                                    <span data-valmsg-for="email"></span>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-input" value="{{ $Empresa->referencia }}"
                                        name="referencia" id="referencia" placeholder="Referencia" required>
                                    <span data-valmsg-for="referencia"></span>
                                </div>
                            </div>
                            <div class="form-group row" hidden>
                                <div class="col-md-12">
                                    <textarea name="descripcion" id="descripcion" class="form-input" cols="30" rows="5"
                                        placeholder="Descripción">{{ $Empresa->descripcion }}</textarea>
                                    <span data-valmsg-for="descripcion"></span>
                                </div>
                            </div>
                            <div class="mb-2 mt-2">
                                <label><b>Datos del Contacto</b></label>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input type="text" name="nombre_contacto" id="nombre_contacto" class="form-input"
                                        value="{{ $Empresa->nombre_contacto }}"
                                        placeholder="Nombres y Apellidos del Contacto" required>
                                    <span data-valmsg-for="nombre_contacto"></span>
                                </div>
                                <div class="col-md-6" hidden>
                                    <input type="text" name="apellido_contacto" id="apellido_contacto"
                                        class="form-input" value="{{ $Empresa->apellido_contacto }}"
                                        placeholder="Apellido del contacto">
                                    <span data-valmsg-for="apellido_contacto"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <input type="text" name="telefono_contacto" id="telefono_contacto"
                                        value="{{ $Empresa->telefono_contacto }}" class="form-input" minlength="9"
                                        maxlength="9" onkeypress="return isNumberKey(event)"
                                        placeholder="Teléfono del contacto" required>
                                    <span data-valmsg-for="telefono_contacto"></span>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" name="email_contacto" id="email_contacto" class="form-input"
                                        value="{{ $Empresa->email_contacto }}"
                                        placeholder="Correo electrónico del contacto">
                                    <span data-valmsg-for="email_contacto"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <input type="text" name="cargo_contacto" id="cargo_contacto" class="form-input"
                                        value="{{ $Empresa->cargo_contacto }}" placeholder="Cargo del contacto">
                                    <span data-valmsg-for="cargo_contacto"></span>
                                </div>
                            </div>
                            <div class="mb-2 mt-2">
                                <label><b>Logo de la Empresa</b></label>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <input type="file" name="img_logo" id="img_logo" class="form-input" placeholder="Subir Imagen" accept="image/*"  @if ($Empresa->logo == null) required @endif>
                                    <span data-valmsg-for="logo"></span>
                                </div>
                                <div class="col-md-6 d-flex justify-content-center align-items-center" style="height: 200px; padding: 20px; overflow: hidden;">
                                    @if ($Empresa->logo != null)
                                    <img src="{{ asset('app/img/logo_empresas/'.$Empresa->logo) }}" id="imgLogo" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                    @else
                                        <img src="{{ asset('app/img/feria/notImagen.png') }}" id="imgLogo" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div id="containerButton" class="card aviso mt-2">
                            <button type="submit" class="btn btn-primary">
                                <i id="editEmpresa" class="fa fa-pencil"></i> Actualizar Empresa
                            </button>
                            <a href="{{ route('index') }}" class="text-uppercase">
                                <i class="fa fa-arrow-left"></i> Regresar
                            </a>
                        </div>
                    </form>
                </div>
                <div class="col-md-2 text-center">
                    <a href="https://wa.me/923001874?text=Hola,vengo%20de%20la%20bolsa%20de%20trabajo%20y%20deseo%20conocer%20más%20de%20los%20servicios%20gratuitos%20para%20las%20empresas%20aliadas."
                        target="_blank">
                        <img src="{{ asset('app/img/nuevaimagen.png') }}" alt="Logo de WhatsApp">
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('app/plugins/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('descripcion');
    </script>
    <script type="text/javascript">
        $(function() {
            $("form").on('submit', function(e) {
                for (var instanceName in CKEDITOR.instances) {
                    CKEDITOR.instances[instanceName].updateElement();
                }
            });
            $('#img_logo').on('change', function (event) {
                const file = event.target.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        $('#imgLogo').attr('src', e.target.result).fadeIn();
                    };
                    reader.readAsDataURL(file);
                } else {
                    $('#imgLogo').fadeOut().attr('src', '');
                }
            });
        });
    </script>
    <script type="text/javascript" src="{{ asset('app/js/empresas/index.js') }}"></script>
@endsection
