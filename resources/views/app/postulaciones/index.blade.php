@extends('app.index')

@section('styles')
    <link rel="stylesheet" href="{{ asset('app/css/avisos/index.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/plugins/daterangepicker/daterangepicker.css') }}" />
@endsection
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .cuadro{
            cursor: pointer;
            background: #fff;
            padding: 30px;
            margin-bottom: 20px;
            border: 1px solid #bbbcbd8b;
            transition: all 0.3s;
        }
        .cuadro:hover{
            border: 1px solid #2a527a8b;
            /* box-shadow: 0px 0px 33px 2px #2a527a8b inset; */
        }
        .cuadro .titulo_postulacions{
            color: #00528f;
            text-transform: uppercase;
        }
    </style>
    <div id="main">

        <div id="loading-avisos">
            <p>Cargando...</p>
        </div>

        <div class="head-section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3>Mis Postulaciones</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- {{ $Alumno->id }}
        {{ $postulaciones }} --}}
        
        <div class="container-fluid">
            <div class="row mt-3">

                <div class="col-lg-4 mb-4">
                    <div class="cuadro m-auto">
                        <div class="w-75 d-flex justify-content-center text-center">
                            <img src="{{ asset('app/img/img_postulaciones_v.png') }}" width="100%" alt="">
                        </div>
                        <p><b>AVISOS POSTULADOS :</b> {{ $postulaciones_count }}</p>
                    </div>
                </div>
                <div class="col-lg-8 row col-sm-12 col-12">
                    @foreach ($postulaciones as $value)
                        <div class="col-lg-6 px-3 col-12 col-sm-12">
                            <div class="row cuadro">
                                <div class="col-md-6 not-padding text-left"><small>{{ $value->nombre_comercial }}</small></div>
                                <div class="col-md-6 not-padding text-right"><a>Postulado el {{ $value->fecha_postulacion }}</a></div>
                                <div class="col-md-12 not-padding titulo_postulacions">
                                    <p>{{ $value->titulo }}</p>

                                    @if (strtotime(date("Y-m-d", strtotime($value->periodo_vigencia . " +1 month"))) < time())
                                        <p class="text-danger">Aviso Finalizado</p>
                                    @else
                                        @if (strtotime($value->periodo_vigencia) < time())
                                            <p class="text-warning">En proceso de selección</p>
                                        @else
                                            <p class="text-info">Vacantes Abiertas</p>
                                        @endif
                                    @endif



                                </div>
                                <div class="col-md-6 not-padding text-left">
                                    <small class="text-success">{{ $value->estado_postulacion }}</small>
                                </div>
                                <div class="col-md-6 not-padding text-right"><small>Públicado el {{ $value->fecha_publicacion }}</small></div>                        
                            </div>
                        </div>
                    @endforeach

                </div>

            </div>
        </div>

        
    </div>
 
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('auth/plugins/moment/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/plugins/moment/moment-with-locales.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/plugins/daterangepicker/daterangepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/auth/plugins/inputmask/dist/min/jquery.inputmask.bundle.min.js') }}"></script>
    <script>const PERFIL = {{ Auth::guard('alumnos')->user() != null ? 2 : 1 }}</script>
@endsection

