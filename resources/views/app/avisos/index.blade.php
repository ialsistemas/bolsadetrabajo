@extends('app.index')

@section('styles')
    <link rel="stylesheet" href="{{ asset('app/css/avisos/index.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/plugins/daterangepicker/daterangepicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('app/css/avisos/indexV2.css') }}">
@endsection

@section('content')

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
                            <input type="text" id="name" name="name" class="form-input"
                                placeholder="Puesto o palabra clave">
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
                    <!-- Bloque de perfil del usuario -->
                    <div class="filter" style="margin-bottom: 20px;">
                        <div class="content-perfil text-center">
                            <div class="imagen-perfil" style="background-color: white;">
                                <img src="{{ $alumno != null && $alumno->foto != null
                                    ? '/uploads/alumnos/fotos/' . $alumno->foto
                                    : '/uploads/default.png' }}"
                                    class="img-responsive img-circle img-photo" alt="Editar Foto"
                                    style="">
                            </div>
                            <h5 class="name-alumno">{{ $alumno->nombres . ' ' . $alumno->apellidos }}
                            </h5>
                            <p class="description-carrera">
                                {{ $alumno->areas->nombre }}</p>

                            <input type="hidden" id="alumnoId" name="alumnoId" value="{{ $alumno->id }}">
                            <div class="progress-container">
                                <progress id="progress-bar" max="100" value="0"></progress>
                                <div class="progress-text" id="progress-text">0%</div>
                            </div>

                            @if (Auth::guard('alumnos')->check())
                                <a href="{{ route('alumno.perfil') }}" class="btn-perfil-estudiante">
                                    Mejora tu perfil profesional
                                </a>
                            @endif
                            <hr>
                            <a href="{{ route('alumno.postulaciones') }}" class="mis-postulacioones">
                                Ver todas mis postulaciones <i class="fa fa-angle-double-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Bloque de filtro existente -->
                    <div class="filter">
                        <form action="">
                            @if (Auth::guard('empresasw')->check())
                                <a href="{{ route('empresa.registrar_aviso') }}" class="button">Nueva oportunidad</a>
                                <a href="{{ route('empresa.listar_aviso') }}" class="button">Mis oportunidades</a>
                            @endif
                            <h5>Encuentra empleo hoy</h5>
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
                                        @foreach ($areas as $a)
                                            <option value="{{ $a->id }}">{{ $a->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <label for="area_filter_id">Carrera</label>
                                </div>
                                <div class="form-group">
                                    <select name="provincia_filter_idd" id="provincia_filter_idd" class="form-input"
                                        required>
                                        <option value="" hidden></option>
                                        @foreach ($provincias as $a)
                                            <option value="{{ $a->id }}">{{ $a->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <label for="provincia_filter_idd"><i class="fa fa-map-marker"></i>&nbsp; Ciudad</label>
                                </div>
                                <div class="form-group">
                                    <select name="distrito_filter_id" id="distrito_filter_id" class="form-input" required>
                                        <option value="" hidden></option>
                                    </select>
                                    <label for="distrito_filter_id"><i class="fa fa-location-arrow"></i>&nbsp;
                                        Distrito</label>
                                </div>
                                <div class="form-group">
                                    <select name="tipo_estudiante" id="tipo_estudiante" class="form-input" required>
                                        <option value="" hidden></option>
                                        @foreach ($grado_academico as $value)
                                            <option value="{{ $value->id }}">{{ $value->grado_estado }}</option>
                                        @endforeach
                                    </select>
                                    <label for="tipo_estudiante"><i class="fa fa-graduation-cap"></i>&nbsp; Tipo de
                                        Estudiante</label>
                                </div>
                                <div class="form-group" hidden>
                                    <select name="horario_filter_id" id="horario_filter_id" class="form-input" required>
                                        <option value=""></option>
                                        @foreach ($horarios as $a)
                                            <option value="{{ $a->id }}">{{ $a->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <label for="horario_filter_id">Tipo de puesto</label>
                                </div>
                                <div class="form-group" hidden>
                                    <select name="modalidad_filter_id" id="modalidad_filter_id" class="form-input" required>
                                        <option value=""></option>
                                        @foreach ($modalidades as $a)
                                            <option value="{{ $a->id }}">{{ $a->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <label for="modalidad_filter_id">Modalidad</label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="filter trainings">
                        <div class="form-group">
                            <select id="selectPrograma" class="form-input selct-template">
                                <option value="">MIS PROGRAMAS</option>
                                <option value="{{ route('alumno.capacitaciones', 'despega-360') }}">DESPEGA 360</option>
                                <option value="{{ route('alumno.capacitaciones', 'carrera-pro') }}">CARRERA PRO</option>
                                <option value="{{ route('alumno.capacitaciones', 'skills-to-work') }}">SKILLS TO WORK</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select id="selecTest" class="form-input selct-template">
                                <option value="">EVALÚA TU POTENCIAL</option>
                                <option value="{{ route('alumno.test-inteligencias-multiples') }}">INTELIGENCIAS MÚLTIPLES</option>
                                <option value="{{ route('alumno.test-fortalezas-personales') }}">FORTALEZAS PERSONALES</option>
                            </select>
                        </div>
                    </div>
                </div>
                {{-- Añadi esto para proponer --}}
                <div id="avisos" class="col-md-7 not-padding">
                    <!-- Mensaje de bloqueo en una posición fija -->
                    <hr>
                    <div id="block-message">
                        <i class="fa fa-exclamation-triangle"></i>
                        Usted se encuentra sancionado temporalmente.
                    </div>
                    <div id="cards-list" class="content avisos endless-pagination" data-next-page
                        style="margin-top: 20px;">
                        <!-- Contenido aquí -->
                    </div>
                </div>
                <div id="aviso-informacion hidden"></div>
                <div class="col-md-2 text-center">
                    <a href="https://wa.me/922611913?text=Hola, Vengo de la Bolsa de trabajo y quiero conocer más sobre los programas de empleabilidad. Información por favor 😊"
                        target="_blank">
                        <img src="{{ asset('app/img/banner2_janet.png') }}" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <button hidden type="button" class="btn btn-primary btn-lg btn_evento_bolsa" data-toggle="modal"
        data-target="#tuto">
    </button>
    <div class="modal fade"
        id="{{ $anuncio->isEmpty() ? '' : 'tuto' }}" tabindex="-1" role="dialog" aria-labelledby="tuto"
        data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true"><b>&times;</b></span></button>
                </div>
                <div class="modal-body">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel"
                        data-interval="3000">
                        <div class="carousel-inner">
                            @foreach ($anuncio as $key => $a)
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
            <span class="flechas" aria-hidden="true"> ◀ </span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="flechas" aria-hidden="true"> ▶ </span>
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
    <script>
        var routeProgreso = "{{ route('alumno.progreso') }}";
        var token = "{{ csrf_token() }}";
        var aprobado = "@json($alumno->aprobado)";
    </script>
    <script src="{{ asset('app/js/avisos/indexV2.js') }}"></script>
    <script>
        const PERFIL = {{ Auth::guard('alumnos')->user() != null ? 2 : 1 }};
    </script>
    <script type="text/javascript" src="{{ asset('app/js/avisos/index.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#selectPrograma').on('change', function () {
                var url = $(this).val();
                if (url) {
                    window.location.href = url;
                }
            });
            $('#selecTest').on('change', function () {
                var url = $(this).val();
                if (url) {
                    window.location.href = url;
                }
            });
        });
    </script>
@endsection
