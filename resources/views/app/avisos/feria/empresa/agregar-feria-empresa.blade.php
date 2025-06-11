@extends('app.index')

@section('styles')
    <link rel="stylesheet" href="{{ asset('app/css/avisos/index.min.css') }}">
    <link rel="stylesheet" href="{{ asset('auth/plugins/datatable/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('app/css/empresa/style.css') }}">
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
                        <h3>Evento: {{ $feraExist->name }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10">
                    <div class="filter filter-add mt-4">
                        <div class="container-fluid">
                            <h2 class="text-center">Agregar Aviso</h2>
                            <form action="{{ route('empresa.store-agregar-feria-empresa') }}" method="POST" enctype="multipart/form-data" class="row">
                                @csrf
                                <input type="hidden" name="idFeria" value="{{ $feraExist->id }}">
                                <div class="col-lg-6 col-12">
                                    <br>
                                    <div class="custom-form-group">
                                        <label for="name" class="custom-label">Nombre del aviso:</label>
                                        <input type="text" class="custom-input" id="name" name="name" required>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <br>
                                    <div class="custom-form-group">
                                        <label for="url_zoom" class="custom-label">
                                            URL de zoom para Charla con Empresa: <small class="text-secondary">opcional</small>
                                        </label>
                                        <input type="text" class="custom-input" id="url_zoom" name="url_zoom">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12 mt-3">
                                    <div class="custom-form-group">
                                        <label for="description" class="custom-label">Descripción del aviso:</label>
                                        <textarea name="description" id="description" style="height: 300px;width: 100%;" class="form-input" placeholder="">
                                            <p><b>Descripción breve del trabajo: </b></p><br><br>
                                            <p><b>Funciones:</b></p><br><br>
                                            <p><b> Indispensable vivir en el distrito o aledaño: Si , No</b></p><br><br>
                                            <p><b>Otros:</b></p>
                                        </textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12 mt-3">
                                    <div class="custom-form-group">
                                        <label for="requisitos" class="custom-label">Requisitos del aviso:</label>
                                        <textarea name="requisitos" id="requisitos" style="height: 300px;width: 100%;" class="form-input" placeholder="">
                                            <p><b>Tiempo de Experiencia Minima: </b></p><br><br>
                                            <p><b>Beneficios:</b></p><br><br>
                                            <p><b>Horario:</b></p><br><br>
                                            <p><b>Sueldo:</b></p>
                                        </textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-12">
                                    @if (session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    <br>
                                    <button type="submit" class="btn btn-block btn-primary">Agregar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 text-center">
                    <a href="https://wa.me/948536701?text=Hola,vengo%20de%20la%20bolsa%20de%20trabajo%20y%20deseo%20conocer%20más%20de%20los%20servicios%20gratuitos%20para%20las%20empresas%20aliadas." target="_blank">
                        <img src="{{ asset('app/img/nuevaimagen2.png') }}" alt="Logo de WhatsApp">
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app/plugins/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('app/js/empresas/feria.js') }}"></script>
@endsection
