@extends('app.index')

@section('styles')
    <link rel="stylesheet" href="{{ asset('app/css/avisos/index.min.css') }}">
    <link rel="stylesheet" href="{{ asset('auth/plugins/datatable/datatables.min.css') }}">
    <style>
        #tableAviso_wrapper{
            padding: 25px 20px;
            background: #fff;
        }
        table th{
            font-size: 14px;
        }
        table td{
            font-weight: 100;
            font-size: 14px;
            padding: 0px 10px !important;
        }
        table button{
            padding: 0px 5px !important;
        }
        .content_pNatural p{
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
                <div class="col-md-3 filter-cont">
                    <div class="filter">
                        <form action="">
                            @if(Auth::guard('empresasw')->check())
                                @if (Auth::guard('empresasw')->user()->tipo_persona == 2)
                                    <div class="content_pNatural">
                                        <p>
                                            Nuestros asesores están listos para ayudarte a encontrar el talento adecuado. 
                                            Por favor, contáctanos para obtener asistencia personalizada en la publicación 
                                            de tu aviso.
                                        </p>
                                        <a href="https://wa.link/0q0eyc" target="_blank" class="btn btn-success w-100 p-3" >Contactar a un Asesor</a>
                                    </div>
                                @else
                                    <a href="{{ route('empresa.registrar_aviso') }}" class="button" >Nueva oportunidad</a>
                                @endif
                            @endif
                        </form>
                    </div>
                </div>
                <div class="col-md-7">
                    <table id="tableAviso" class="table table-bordered table-striped display nowrap margin-top-10 dataTable no-footer"></table>
                </div>
                <div class="col-md-2 text-center">
                    <a href="https://wa.link/wyggli" target="_blank">
                        <img src="{{ asset('app/img/banner_empresa.jpeg') }}" alt="">
                    </a>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/dataTables.config.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app/js/avisos/listar.js') }}"></script>
@endsection

