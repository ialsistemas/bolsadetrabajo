@extends('app.index')

@section('styles')
    <link rel="stylesheet" href="{{ asset('app/css/avisos/index.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/plugins/daterangepicker/daterangepicker.css') }}" />
    {{-- <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet"> --}}
@endsection

@section('content')

    <style>
        .content_cuadros_banner{
           /*  background: #afaa0f !important; */
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-evenly;
            align-content: center;
            align-items: center;
        }
        .content_img_banner_va{
            width: 38%;
        }
        ..content_img_banner_va img{
            width: 100%;
        }
        .content_divs_banner_va{
            width: 50%;
        }
        .content_divs_banner_va .cabezera_vale{
            margin-bottom: 30px;
        }
        .container_btn_banne {
            cursor: pointer;
            position: relative;
            width: 90%;
            height: 100px;
            margin-bottom: 25px;
        }

        .content_btn_azul,
        .content_btn_celeste {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .content_btn_azul {
            background-color: #094a90;
            clip-path: polygon(100% 0, 100% 100%, 0% 100%, 12% 50%, 0% 0%);
        }

        .content_btn_celeste {
            bottom: -10%;
            left: 2%;
            background-color: #22bdff;
            clip-path: polygon(100% 0, 100% 100%, 0% 100%, 12% 50%, 0% 0%);
            text-align: center;
            padding: 10px 0px 10px 40px;
            color: #fff;
            transition: 0.3s all;
        }
        .content_btn_celeste:hover{
            background: #1a99cf;
        }

        @media only screen and (max-width: 991px) {
            .container_btn_banne {
                position: relative;
                width: 90%;
                height: 70px;
                margin-bottom: 25px;
            }
            .content_btn_celeste{
                font-size:10px;
            }
            .content_btn_celeste {
                bottom: -10%;
                left: 2%;
                padding: 10px 0px 10px 17px;
            }
        }	
        @media only screen and (max-width: 448px) {
            .container_btn_banne {
                position: relative;
                width: 100%;
                height: 100px;
                margin-bottom: 25px;
            }
            .content_btn_celeste{
                font-size:10px;
            }
            .content_btn_celeste {
                bottom: -10%;
                left: 2%;
                padding: 10px 0px 10px 17px;
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                align-content: center;
                align-items: center;
            }
        }
        .carousel-control-prev{
            margin-left:16%;
        }
        .carousel-control-next{
            margin-right:16%;
        }
        @media screen and (max-width:1669px){
            .carousel-control-prev{
                margin-left:7% !important;
            }
            .carousel-control-next{
                margin-right:7% !important;
            }
        }	
        @media screen and (max-width:1243px){
            .carousel-control-prev{
                margin-left:0% !important;
            }
            .carousel-control-next{
                margin-right:0% !important;
            }
        }	
        @media screen and (max-width:679px){
            .carousel-control-prev{
                margin-top: 90% !important
            }
            .carousel-control-next{
                margin-top: 90% !important;
            }
        }	

    </style>

    <!--sweet alert-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div id="main">

        <div id="loading-avisos">
            <p>Cargando...</p>
        </div>

        <div class="head-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form">
                            <input type="text" id="name" name="name" class="form-input" placeholder="Puesto o palabra clave">
                            <button type="button" class="filterSearch" style="background-color: #00000052;">
                                <i class="fa fa-search"></i> Buscar</button>
                        </div>
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
                                <a href="{{ route('empresa.registrar_aviso') }}" class="button" >Nueva oportunidad</a>
                                <a href="{{ route('empresa.listar_aviso') }}" class="button" >Mis oportunidades</a>
                            @endif
                            <h5>Filtros</h5>
                            <div class="form-content">
                                <div class="form-group">
                                    <div id="reportrange" class="text-capitalize" style="">
                                        <i class="fa fa-calendar"></i>&nbsp;
                                        <span></span> <i class="fa fa-angle-down"></i>
                                    </div>
                                </div>
                                <div class="form-group" hidden>
                                    <select name="area_filter_id" id="area_filter_id" class="form-input" required>
                                        <option value="" hidden></option>
                                    @foreach($areas as $a)
                                        <option value="{{ $a->id }}">{{ $a->nombre }}</option>
                                    @endforeach
                                    </select>
                                    <label for="area_filter_id">Carrera</label>
                                </div>
                                <div class="form-group">
                                    <select name="provincia_filter_idd" id="provincia_filter_idd" class="form-input" required>
                                        <option value="" hidden></option>
                                        @foreach($provincias as $a)
                                            <option value="{{ $a->id }}">{{ $a->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <label for="provincia_filter_id">Ciudad</label>
                                </div>
                                <div class="form-group">
                                    <select name="distrito_filter_id" id="distrito_filter_id" class="form-input" required>
                                        <option value="" hidden></option>
                                    </select>
                                    <label for="distrito_filter_id">Distrito</label>
                                </div>

                                <div class="form-group">
                                    <select name="tipo_estudiante" id="tipo_estudiante" class="form-input" required>
                                        <option value="" hidden></option>
                                        @foreach ($grado_academico as $value)
                                            <option value="{{ $value->id }}">{{ $value->grado_estado }}</option>
                                        @endforeach
                                    </select>
                                    <label for="tipo_estudiante">Tipo de Estudiante</label>
                                </div>

                                <div class="form-group" hidden>
                                    <select name="horario_filter_id" id="horario_filter_id" class="form-input" required>
                                        <option value=""></option>
                                        @foreach($horarios as $a)
                                            <option value="{{ $a->id }}">{{ $a->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <label for="horario_filter_id">Tipo de puesto</label>
                                </div>
                                <div class="form-group" hidden>
                                    <select name="modalidad_filter_id" id="modalidad_filter_id" class="form-input" required>
                                        <option value=""></option>
                                        @foreach($modalidades as $a)
                                            <option value="{{ $a->id }}">{{ $a->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <label for="modalidad_filter_id">Modalidad</label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                    {{-- Añadi esto para proponer --}}
                <div id="avisos" class="col-md-7 not-padding">
                    {{-- <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($anuncio as $key => $a)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <a href="{{ $a->enlace != null ? $a->enlace : 'javascript:void(0)' }}" 
                                       target="{{ $a->enlace != null ? '_blank' : '' }}">
                                        <img class="d-block w-100" src="{{ asset($a->banner) }}" alt="Banner {{ $key + 1 }}">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div> --}}
                    {{-- Fin --}}
                    {{-- Aqui añadi margin-top --}}
                    <!-- Mensaje de bloqueo en una posición fija -->
                    <hr>
                    <div id="block-message" style="display: none; position: relative; top: 0; left: 0; right: 0; background-color: rgba(255, 0, 0, 0.8); color: white; text-align: center; padding: 10px; font-weight: bold; z-index: 1000;">
                        <i class="fa fa-exclamation-triangle" style="font-size: 15px; margin-right: 5px;"></i>
                        Usted se encuentra sancionado temporalmente. 
                        <a href="#" id="view-reason" style="color: yellow; text-decoration: underline; font-size:12px;">Ver motivo</a>
                    </div>
                    
                    <!-- Modal or popup to show the reason -->
                   {{--  <div id="reason-popup" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; color: black; padding: 20px; border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); z-index: 1001;">
                        <h2>Motivo del Bloqueo</h2>
                        <p>Aquí puede proporcionar detalles sobre el motivo del bloqueo. Por ejemplo, puede ser debido a múltiples intentos fallidos de inicio de sesión, violaciones de políticas, etc.</p>
                        <button id="close-popup" style="padding: 5px 10px; background-color: #007bff; color: white; border: none; cursor: pointer;">Cerrar</button>
                    </div>
                    
                    <script>
                    document.getElementById('view-reason').addEventListener('click', function(event) {
                        event.preventDefault();
                        document.getElementById('reason-popup').style.display = 'block';
                    });
                    
                    document.getElementById('close-popup').addEventListener('click', function() {
                        document.getElementById('reason-popup').style.display = 'none';
                    });
                    </script> --}}
                    
                    <div id="cards-list" class="content avisos endless-pagination" data-next-page style="margin-top: 20px;">
                        <!-- Contenido aquí -->
                    </div>
                    
                    
                    
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            // Obtener el valor de aprobado
                            var aprobado = @json($alumno->aprobado);
                    
                            // Obtener los elementos div
                            var cardsListDiv = document.getElementById('cards-list');
                            var blockMessageDiv = document.getElementById('block-message');
                    
                            // Verificar el valor y aplicar estilos si es igual a 3
                            if (aprobado === 3) {
                                cardsListDiv.style.pointerEvents = 'none'; // Desactiva los eventos de ratón
                                cardsListDiv.style.opacity = '0.5'; // Opcional: hacer que el div se vea desactivado
                                blockMessageDiv.style.display = 'block'; // Muestra el mensaje de bloqueo
                            }
                        });
                    </script>
                    
                </div>

                <div id="aviso-informacion hidden"></div>

                <div class="col-md-2 text-center">
                    <a href="https://wa.me/922611913?text=Hola, Vengo de la Bolsa de trabajo y quiero conocer más sobre los programas de empleabilidad. Información por favor 😊" target="_blank">
                        <img src="{{ asset('app/img/banner2_janet.png') }}" alt="">
                    </a>
                </div>
            </div>
        </div>

    </div>

    <button hidden type="button" class="btn btn-primary btn-lg btn_evento_bolsa" data-toggle="modal" data-target="#tuto">
    </button>
    <div class="modal fade" style="background: rgba(7, 7, 7, 0.89) !important;" id="{{ $anuncio->isEmpty() ? '' : 'tuto' }}" tabindex="-1" role="dialog" aria-labelledby="tuto" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" style="z-index:999; color:red !important; border:none; font-size:40px; font-weight:900;" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><b>&times;</b></span></button>
                </div>
                <div class="modal-body">

                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="3000">
                        <div class="carousel-inner">
                            @foreach($anuncio as $key => $a)
                                <a href="{{ $a->enlace != null ? $a->enlace : 'javascript:void(0)' }}" target="{{ $a->enlace != null ? '_blank' : '' }}" class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <img class="d-block w-100" src="{{ asset($a->banner) }}">
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span style="color:#fff; font-size:60px !important;" class="" aria-hidden="true"> ◀ </span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span style="color:#fff; font-size:60px !important;" class="" aria-hidden="true"> ▶ </span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    

@endsection

@section('scripts')
    {{-- <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script> --}}
    <script type="text/javascript" src="{{ asset('auth/plugins/moment/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/plugins/moment/moment-with-locales.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/plugins/daterangepicker/daterangepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/auth/plugins/inputmask/dist/min/jquery.inputmask.bundle.min.js') }}"></script>
    <script>const PERFIL = {{ Auth::guard('alumnos')->user() != null ? 2 : 1 }}</script>
    <script type="text/javascript" src="{{ asset('app/js/avisos/index.js') }}"></script>
@endsection
