@extends('app.index')

@section('styles')
    <link rel="stylesheet" href="{{ asset('app/css/avisos/index.min.css') }}">
    <link rel="stylesheet" href="{{ asset('auth/plugins/datatable/datatables.min.css') }}">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
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
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-md-10 container-filter">
                    <div class="filter">
                        <div class="text-center my-10 welcome-container">
                            <video class="img-fluid welcome-video" style="max-width: 400px;" autoplay muted loop playsinline>
                                <source src="{{ asset('app/img/feria/video-feria.mp4') }}" type="video/mp4">
                                Tu navegador no soporta la reproducción de video.
                            </video>
                        </div>
                        <br>
                        <div class="container-fluid mt-5">
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    @if (session('success'))
                                        <div id="successAlert" class="alert alert-success text-center" style="position: relative;">
                                            {{ session('success') }}
                                        </div>
                                        <br>
                                    @endif
                                    <h2 class="text-center">Lista de Avisos</h2>
                                </div>
                                <div class="col-lg-6 col-12 text-center">
                                    <a href="{{ route('empresa.agregar-feria-empresa', $feraExist->route) }}" class="btn btn-info">Agregar Aviso</a>
                                </div>
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table id="tableAviso" class="table table-striped">
                                            <thead class="bg-loayza">
                                                <th>Nombre del Aviso</th>
                                                <th>Url Zoom</th>
                                                <th>Acciones</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($avisoEmpresaFeriaData as $avisoEmpresaFeria)
                                                    <tr>
                                                        <td class="text-center align-middle">{{ $avisoEmpresaFeria->name }}</td>
                                                        <td class="text-center align-middle">
                                                            <a href="{{ $avisoEmpresaFeria->url_zoom ?? '#' }}" 
                                                                class="btn btn-info {{ $avisoEmpresaFeria->url_zoom ? '' : 'disabled' }}" 
                                                                target="_blank">Link del Zoom</a>
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            <a href="{{ route('empresa.eliminar-feria-empresa', $avisoEmpresaFeria->route) }}" class="btn btn-danger">
                                                                <i class="icon-trash"></i>
                                                            </a>
                                                            <a href="{{ route('empresa.postulante-feria-empresa', $avisoEmpresaFeria->route) }}" class="btn btn-info">
                                                                <i class="icon-user"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
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
    <script src="{{ asset('app/js/empresas/feria.js') }}"></script>
@endsection
