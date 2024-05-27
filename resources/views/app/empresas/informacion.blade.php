@extends('app.index')

@section('styles')
    <link rel="stylesheet" href="{{ asset('app/css/avisos/index.min.css') }}">
    <style>
        label{font-weight: 400;font-size: 14px;color: #666;}
        input{padding: 8px 15px 5px 15px !important;}
    </style>
@endsection

@section('content')

    <div id="main">

        <div id="loading-avisos">
            <p>Cargando...</p>
        </div>

        <div class="head-section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3>{{ $Empresa->nombre_comercial }}</h3>
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
                    <form enctype="multipart/form-data" id="actualizoPerfil" class="formulario" data-ajax-failure="OnFailureActualizoPerfil">
                        @csrf
                        <div class="card aviso">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="razon_social">Razón Social</label>
                                    <input type="text" class="form-input" value="{{ $Empresa->razon_social }}" name="razon_social" id="razon_social" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="nombre_comercial">Nombre Comercial</label>
                                    <input type="text" class="form-input" value="{{ $Empresa->nombre_comercial }}"  name="nombre_comercial" id="nombre_comercial" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="ruc">RUC</label>
                                    <input type="text" class="form-input" value="{{ $Empresa->ruc }}" name="ruc" id="ruc" readonly placeholder="RUC" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="distrito">Distrito</label>
                                    <input type="text" class="form-input" value="{{ $Empresa->distritos->nombre }}"  name="distrito" id="distrito" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="ciudad">Ciudad</label>
                                    <input type="text" class="form-input" value="{{ $Empresa->provincias->nombre }}"  name="ciudad" id="ciudad" readonly >
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="direccion">Dirección</label>
                                    <input type="text" class="form-input" value="{{ $Empresa->direccion }}" name="direccion" id="direccion" placeholder="Dirección" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="telefono">Teléfono</label>
                                    <input type="text" class="form-input" value="{{ $Empresa->telefono }}" name="telefono" id="telefono" readonly required>
                                </div>
                                <div class="col-md-6">
                                    <label for="pagina_web">Página web</label>
                                    <input type="text" class="form-input" value="{{ $Empresa->pagina_web }}" name="pagina_web" id="pagina_web" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="pagina_web">Correo electrónico</label>
                                    <input type="email" class="form-input" value="{{ $Empresa->email }}" name="email" id="email" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="perfil">Descripción</label>
                                    <p><?php echo $Empresa->descripcion ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="card aviso mt-2">
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

@endsection


