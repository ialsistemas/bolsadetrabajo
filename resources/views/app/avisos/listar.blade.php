@extends('app.index')

@section('styles')
    <link rel="stylesheet" href="{{ asset('app/css/avisos/index.min.css') }}">
    <link rel="stylesheet" href="{{ asset('auth/plugins/datatable/datatables.min.css') }}">
    <style>
        #tableAviso_wrapper {
            padding: 25px 20px;
            background: #fff;
        }

        table th {
            font-size: 14px;
        }

        table td {
            font-weight: 100;
            font-size: 14px;
            padding: 0px 10px !important;
        }

        table button {
            padding: 0px 5px !important;
        }

        .content_pNatural p {
            color: #6b7280;
            text-align: justify;
        }
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
                        <h3>Mis Oportunidades</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-md-3 filter-cont" style="height: 50% !important">
                    <div class="filter">
                        <form action="" method="GET">
                            {{-- Codigo Sebastian, para que se ve mas llamativo --}}
                            <style>
                                @keyframes zoomButton {
                                    0% {
                                        transform: scale(1);
                                    }
                                    50% {
                                        transform: scale(1.05);
                                    }
                                    100% {
                                        transform: scale(1);
                                    }
                                }
                            
                                .button {
                                    display: inline-block;
                                    padding: 12px 24px;
                                    border-radius: 10px;
                                    background-color: #4CAF50;
                                    color: white;
                                    text-decoration: none;
                                    font-size: 18px;
                                    border: 2px solid #4CAF50;
                                    transition: transform 0.2s ease;
                                    animation: zoomButton 2s ease-in-out infinite;
                                }
                            
                                .button:hover {
                                    transform: scale(1.2);
                                }
                            </style>
                            {{-- Fin Style --}}
                            @if (Auth::guard('empresasw')->check())
                                @if (Auth::guard('empresasw')->user()->tipo_persona == 2)
                                    <div class="content_pNatural">
                                        <p>
                                            Nuestros asesores están listos para ayudarte a encontrar el talento adecuado.
                                            Por favor, contáctanos para obtener asistencia personalizada en la publicación
                                            de tu aviso.
                                        </p>
                                        <a href="https://wa.link/0q0eyc" target="_blank" class="btn btn-success w-100 p-3 button"
                                            style="border-radius: 15px;background-color: #2ecc71 !important;
                                            border-color: #28a745 !important;"><i class="fa fa-whatsapp"></i> Contactar a un Asesor</a>
                                    </div>
                                @else
                                

                                
                                <a href="{{ route('empresa.registrar_aviso') }}" class="button">
                                    <span class="icon"><i class="fa fa-plus-circle"></i></span> Nueva oportunidad
                                </a>
                                
                                @endif
                            @endif

                            <div class="form-group">
                                <label for="fecha_desde">Desde:</label>
                                <br>
                                <hr>
                                <input type="date" id="fecha_desde"
                                    value="{{ request()->input('fecha_desde', date('2000-01-01')) }}" name="fecha_desde"
                                    class="form-control" style="padding: 10px 5px 5px 10px; background:#edfaff;">
                                @error('fecha_desde')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="fecha_hasta">Hasta:</label>
                                <br>
                                <hr>
                                <input type="date" id="fecha_hasta"
                                    value="{{ request()->input('fecha_hasta', date('Y-m-d')) }}" name="fecha_hasta"
                                    class="form-control" style="padding: 10px 5px 5px 10px; background:#edfaff;">
                                @error('fecha_hasta')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <br>
                            <button type="submit" id="filtro-submit" class="btn btn-primary btn-sm"
                                onclick="consultarEmpleador()"
                                style="border-color: #2ecc71; background: #2ecc71; border-radius: 5px;">Aplicar
                            Filtro</button>
                           

                        </form>

                    </div>
                </div>

                <div class="col-md-7">
                    <div class="row justify-content-center mt-4">
                        <div class="col-lg-12">
                            <div class="alert alert-success" role="alert">
                                <span class="fa fa-check-circle"></span>
                                Aplique filtros de fecha para ver sus avisos actualizados según lo que requiera.
                            </div>
                        </div>
                    </div>
                    <table id="tableAviso"
                        class="table table-bordered table-striped display nowrap margin-top-10 dataTable no-footer"></table>
                </div>
                <div class="col-md-2 text-center">
                    <a href="https://wa.me/923001874?text=Hola,vengo%20de%20la%20bolsa%20de%20trabajo%20y%20deseo%20conocer%20más%20de%20los%20servicios%20gratuitos%20para%20las%20empresas%20aliadas." target="_blank">
                        <img src="{{ asset('app/img/nuevaimagen.png') }}" alt="Logo de WhatsApp">
                    </a>
                    
                </div>
            </div>
        </div>


        {{-- Codigo Nuevo Sebastian para las empresas anuncios --}}
        <button hidden type="button" class="btn btn-primary btn-lg btn_evento_bolsa" data-toggle="modal"
            data-target="#tuto"></button>

        <button hidden type="button" class="btn btn-primary btn-lg btn_evento_bolsa" data-toggle="modal"
            data-target="#tuto">
        </button>
        <div class="modal fade" style="background: rgba(7, 7, 7, 0.89) !important;"
            id="{{ $anuncios->isEmpty() ? '' : 'tuto' }}" tabindex="-1" role="dialog" aria-labelledby="tuto"
            data-backdrop="static">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content" style="background-color: #ffffff00 !important;">
                    <div class="modal-header" style="border-bottom: 1px solid #dee2e600 !important;">
                        <button type="button"
                            style="z-index:999; color:rgb(255, 255, 255) !important; border:none; font-size:40px; font-weight:900;"
                            class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true"><b>&times;</b></span></button>
                    </div>
                    <div class="modal-body">

                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel"
                            data-interval="3000">
                            <div class="carousel-inner">
                                @foreach ($anuncios as $key => $a)
                                    <a href="{{ $a->enlace != null ? $a->enlace : 'javascript:void(0)' }}"
                                        target="{{ $a->enlace != null ? '_blank' : '' }}"
                                        class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                        <img class="d-block w-100" src="{{ asset($a->banner) }}">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span style="color:#fff; font-size:40px !important;" class="" aria-hidden="true"> ◀ </span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span style="color:#fff; font-size:40px !important;" class="" aria-hidden="true"> ▶ </span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        {{-- Fin Codigo --}}


    </div>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/dataTables.config.min.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('app/js/avisos/index.js') }}"></script> --}}
    <script type="text/javascript" src="{{ asset('app/js/avisos/listar.js') }}"></script>
@endsection
