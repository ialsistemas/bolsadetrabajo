@extends('app.index')

@section('styles')
    <link rel="stylesheet" href="{{ asset('app/css/avisos/index.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/plugins/daterangepicker/daterangepicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('app/css/avisos/indexV2.css') }}">
    <link rel="stylesheet" href="{{ asset('app/css/avisos/alumno.css') }}">
    <link rel="stylesheet" href="{{ asset('app/css/avisos/feria.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz,wght@8..144,100..1000&display=swap" rel="stylesheet">
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
                        <h3>Módulo Asesorías Express – Feria Laboral Virtual</h3>
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <div class="card-feria asesoria bg-white">
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <div class="card-body-feria">
                                                <div class="bg-secondary-asesora p-3">
                                                    <img src="{{ asset('app/img/feria/asesora/'.$asesoraData->img) }}" alt="{{ $asesoraData->name }}">
                                                    <br><br>
                                                    <p class="title-asesoria text-center">{{ $asesoraData->area }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12 pt-4 text-font-asesora">
                                            <p class="text-black">{{ $asesoraData->descripcion }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-12 mt-4">
                                <div class="row" style="margin-top: 20px;">
                                    <div class="col-lg-6 col-12">
                                        <div class="calendario-box">
                                            <h4 class="text-center">JUNIO 2025</h4>
                                            <table class="table calendario">
                                                <thead>
                                                    <tr>
                                                    <th>LU</th><th>MA</th><th>MI</th><th>JU</th><th>VI</th><th>SÁ</th><th>DO</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="cuerpo-calendario">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="hora-box">
                                            <h4 class="text-center">Selecciona una hora</h4>
                                            <div id="horas-disponibles" class="text-center">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-lg-4 col-12">
                                                <div class="form-group">
                                                    <label for="motivo">Motivo de la asesoria:</label>
                                                    <select class="form-control" id="motivo" name="motivo">
                                                        <option>Asesoría de CV</option>
                                                        <option>Preparación para una entrevista de trabajo</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-12">
                                                <div class="form-group">
                                                    <label for="credencialesAlumno">Credenciales del Alumno:</label>
                                                    <input type="text" class="form-control" id="credencialesAlumno" name="credencialesAlumno" value="{{ $alumno->dni }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-12">
                                                <div class="form-group">
                                                    <label for="phone">Número de celular:</label>
                                                    <input type="tel" class="form-control" id="phone" name="phone"
                                                        pattern="[0-9]*" inputmode="numeric" maxlength="9"
                                                        placeholder="Solo números" />
                                                </div>
                                            </div>
                                            <div class="col-12 text-center">
                                                <input type="hidden" name="idAsesora" value="{{ $asesoraData->id }}" id="idAsesora">
                                                <button class="btn btn-primary" id="sendCita">Solicitar</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <br>
                                        <div class="alert alert-info text-center" role="alert">
                                            ¿Tienes inconvenientes o no sabes qué hacer? 
                                            <strong>Haz clic aquí para recibir asesoría vía WhatsApp:</strong>
                                            <a href="https://wa.me/51948536701?text=Hola%2C%20necesito%20asesor%C3%ADa" target="_blank" style="margin-left: 5px;">
                                                <img src="{{ asset('app/img/feria/whatsapp.png') }}" alt="WhatsApp" style="width: 30px; vertical-align: middle;">
                                            </a>
                                        </div>
                                    </div>
                                </div>
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
        const urlDateCita = "{{ route('alumno.alumno-sacar-cita') }}";
        const urlRegistraCita = "{{ route('alumno.store-alumno-sacar-cita') }}";
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('app/js/avisos/indexV2.js') }}"></script>
    <script src="{{ asset('app/js/avisos/calendario.js') }}"></script>
@endsection
