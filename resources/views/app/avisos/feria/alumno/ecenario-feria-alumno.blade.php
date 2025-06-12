@extends('app.index')

@section('styles')
    <link rel="stylesheet" href="{{ asset('app/css/avisos/index.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/plugins/daterangepicker/daterangepicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('app/css/avisos/indexV2.css') }}">
    <link rel="stylesheet" href="{{ asset('app/css/avisos/alumno.css') }}">
    <link rel="stylesheet" href="{{ asset('app/css/avisos/feria-ecenario.css') }}">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
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
                </div>
                <div class="col-md-7 not-padding">
                    <div class="filter p-4">
                        <div class="row">
                            <div class="col-lg-12 col-12 image-container" id="ecenario">
                                <img src="{{ asset('app/img/feria/fondo-alumno-feria.jpg') }}" alt="fondo-alumno-feria" class="background-image">
                                <img src="{{ asset('app/img/logo_empresas/'.$empresaExist->logo) }}" alt="{{ $empresaExist->nombre_comercial }}" class="logo-image">
                                <img src="{{ asset('app/img/feria/zoom-fondo.jpg') }}" alt="zoom" class="logo-zoom">
                                <div class="card-container">
                                    @php
                                        $avisosConZoom = $avisoAlumnoFeriaData->filter(function($item) {
                                            return !empty($item->urlZoomAvisoEmpresaFeria);
                                        })->take(3);
                                    @endphp

                                    @foreach ($avisosConZoom as $index => $aviso)
                                        <div class="conference-card">
                                            Conferencia {{ $index + 1 }}
                                            <a href="{{ $aviso->urlZoomAvisoEmpresaFeria }}" class="btn btn-info btn-sm mt-2" target="_blank">Unirse</a>
                                        </div>
                                    @endforeach
                                </div>
                                <a href="{{ route('alumno.feria-aviso-alumno-empresa', $empresaExist->link) }}">
                                    <img src="{{ asset('app/img/feria/feria-laboral-online-largo.jpg') }}" alt="fondo-lista-aviso" class="logo-aviso">
                                </a>
                            </div>
                            <div class="col-lg-12 col-12 mt-2 container-escenario">
                                <div class="fondo-zoom-mobile">
                                    <h4 class="text-center">Lista de Conferencia</h4>
                                    <br>
                                    @php
                                        $avisosConZoom = $avisoAlumnoFeriaData->filter(function($item) {
                                            return !empty($item->urlZoomAvisoEmpresaFeria);
                                        })->take(3);
                                    @endphp
                                    @foreach ($avisosConZoom as $index => $aviso)
                                        <div class="conference-card">
                                            Conferencia {{ $index + 1 }}
                                            <a href="{{ $aviso->urlZoomAvisoEmpresaFeria }}" class="btn btn-info btn-sm mt-2" target="_blank">Unirse</a>
                                        </div>
                                        <br>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-12 col-12 mt-2 container-escenario">
                                <a href="{{ route('alumno.feria-aviso-alumno-empresa', $empresaExist->link) }}">
                                    <div class="fondo-aviso-mobile"></div>
                                </a>
                            </div>
                        </div>
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
        const PERFIL = {{ Auth::guard('alumnos')->user() != null ? 2 : 1 }};
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('app/js/avisos/indexV2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app/js/avisos/index.js') }}"></script>
    <script src="{{ asset('app/js/avisos/feria.js') }}"></script>
@endsection
