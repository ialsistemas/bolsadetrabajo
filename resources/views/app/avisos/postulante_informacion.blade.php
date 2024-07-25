@extends('app.index')

@section('styles')
    <link rel="stylesheet" href="{{ asset('app/css/avisos/index.css') }}">
@endsection

@section('content')
    <div id="main">

        <div class="head-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Evaluación de postulantes</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid mt-3">
            <div class="row">
                <div class="row justify-content-center mt-4 col-md-12 filter-cont">
                    <div class="col-lg-12">
                        <div class="alert alert-success" role="alert">
                            <span class="fa fa-check-circle"></span>
                            Genial, ahora estas evaluando a {{ $alumno->nombres . ' ' . $alumno->apellidos }}!, No te olvides de calificar al postulante por favor.
                        </div>
                    </div>
                </div>
                <div class="col-md-3 filter-cont">
                    <div class="filter">
                        <div class="info-group">
                            <p> Postulantes <br> <span
                                    id="count_postulantes">{{ count($alumnosAvisos->where('estado_id', \BolsaTrabajo\App::$ESTADO_POSTULANTES)->pluck('aviso_id')->toArray()) }}</span>
                            </p>
                            <p> Evaluando <br> <span
                                    id="count_evaluados">{{ count($alumnosAvisos->where('estado_id', \BolsaTrabajo\App::$ESTADO_EVALUANDO)->pluck('aviso_id')->toArray()) }}</span>
                            </p>
                            {{-- <p> Seleccionados <br> <span id="count_seleccionados">{{ count($alumnosAvisos->where('estado_id', \BolsaTrabajo\App::$ESTADO_SELECCIONADOS)->pluck('aviso_id')->toArray()) }}</span> </p> --}}
                            <p> Aceptados <br> <span
                                    id="count_aceptados">{{ count($alumnosAvisos->where('estado_id', \BolsaTrabajo\App::$ESTADO_ACEPTADOS)->pluck('aviso_id')->toArray()) }}</span>
                            </p>
                            <p> Desacartados <br> <span
                                    id="count_descartados">{{ count($alumnosAvisos->where('estado_id', \BolsaTrabajo\App::$ESTADO_DESCARTADOS)->pluck('aviso_id')->toArray()) }}</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    @csrf
                    <div id="postulante_informacion" class="card aviso">
                        <h5><b>{{ $alumno->nombres . ' ' . $alumno->apellidos }} | </b> {{ $aviso->titulo }}</h5>
                        <p><b>Email:</b> {{ $alumno->email }}</p>
                        <p><b>Teléfono:</b> {{ $alumno->telefono }}</p>
                        <p><b>DNI:</b> {{ $alumno->dni }}</p>
                        {{-- <p><b>Dirección:</b> {{ $alumno->direccion }}</p> --}}
                        <p><b>Provincia:</b> {{ $alumno->provincias != null ? $alumno->provincias->nombre : '-' }}</p>
                        <p><b>Distrito:</b> {{ $alumno->distritos != null ? $alumno->distritos->nombre : '-' }}</p>

                        <div class="mt-3">
                            <h5>Perfil</h5>
                            <p> @php echo $alumno->perfil_profesional; @endphp </p>
                        </div>

                        <div class="mt-3">
                            <h5>Experiencia Laboral</h5>
                            @foreach ($alumno->experiencias as $q)
                                <div>
                                    <p><b>Puesto:</b> {{ $q->puesto }}</p>
                                    <p><b>Empresa:</b> {{ $q->empresa }}</p>
                                    <p><b>Sector:</b> {{ $q->sector }}</p>
                                    @if ($q->estado != null || $q->estado != '')
                                        <p><b>Estado:</b> {{ $q->estado }}</p>
                                    @endif
                                    {{-- <p><b>Área:</b> {{ $q->areas != null ? $q->areas->nombre : "-"}}</p> --}}
                                    <p><b>Inicio Laburo:</b> {{ $q->inicio_laburo }}</p>
                                    @if ($q->fin_laburo != null || $q->fin_laburo != '')
                                        <p><b>Fin Laburo:</b> {{ $q->fin_laburo }}</p>
                                    @endif
                                    <hr>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-3">
                            <h5>Educación y Formación</h5>
                            @foreach ($educaciones as $item)
                                <div>
                                    <p><b>Institución:</b> {{ $item->institucion }}</p>
                                    @foreach ($area as $q)
                                        @php
                                            if ($item->area_id == $q->id) {
                                                echo '<p><b>Área:</b> ' . $q->nombre . ' </p>';
                                            }
                                        @endphp
                                    @endforeach
                                    <p><b>Grado Academico:</b> {{ $item->estado }}</p>
                                    @if ($item->estado == 'Estudiante')
                                        <p><b>Inicio de Estudio:</b> {{ $item->estudio_inicio }}</p>
                                        <p><b>Ciclo de Estudio:</b> {{ $item->ciclo }}</p>
                                    @else
                                        <p><b>Inicio de Estudio:</b> {{ $item->estudio_inicio }}</p>
                                        <p><b>Fin de Estudio:</b> {{ $item->estudio_fin }}</p>
                                    @endif
                                    <hr>
                                </div>
                            @endforeach
                        </div>

                        {{-- <div class="mt-3">
                            <h5>Referencias Laborales</h5>
                            @foreach ($alumno->referencias as $q)
                                <div class="mt-3">
                                    <p><b>Nombre:</b> {{ $q->nombre }}</p>
                                    <p><b>Empresa:</b> {{ $q->empresa }}</p>
                                    <p><b>Cargo:</b> {{ $q->cargo }}</p>
                                    <p><b>Teléfono:</b> {{ $q->telefono }}</p>
                                </div>
                            @endforeach
                        </div> --}}

                        <div class="mt-3">
                            <h5>Cursos, Talleres y Conferencias académicas</h5>
                            @foreach ($alumno->referencias as $q)
                                <div>
                                    <p><b>Nombre del Curso:</b> {{ $q->name_curso }}</p>
                                    <p><b>Institución:</b> {{ $q->institucion }}</p>
                                    @if ($q->estado != null || $q->estado != '')
                                        <p><b>Estado:</b> {{ $q->estado }}</p>
                                    @endif
                                    <p><b>Inicio del Curso:</b> {{ $q->inicio_curso }}</p>
                                    @if ($q->fin_curso != null || $q->fin_curso != '')
                                        <p><b>Fin del Curso:</b> {{ $q->fin_curso }}</p>
                                    @endif
                                    <br>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-3">
                            <h5 style="display:{{ strlen($alumno->referentes_carrera) >= 1 ? 'block' : 'none' }}">
                                Habilidades y Conocimientos</h5>
                            <p> @php echo $alumno->referentes_carrera @endphp </p>
                            {{-- <p>{{ $alumno->referentes_carrera }}</p> --}}
                        </div>

                        {{-- @if ($alumno->hoja_de_vida != null && $alumno->hoja_de_vida != '')
                        <div class="mt-3">
                            <a href="/uploads/alumnos/archivos/{{ $alumno->hoja_de_vida }}" target="_blank">Cv{{ str_replace(' ', '', $alumno->nombres." ".$alumno->apellidos ) }}</a>
                        </div>
                        @endif --}}
                        <style>
                            .btn_cv_emp {
                                width: 60% !important;
                                text-transform: uppercase;
                                text-align: center;
                                padding: 12px 20px;
                                margin: 10px auto;
                                font-size: 17px;
                                font-weight: 400;
                                color: #fff !important;
                                border: 0;
                                outline: 0;
                                transition: 0.5s ease;
                                background-color: #00C853;
                                text-decoration: none !important;
                            }
                        </style>

                        <div class="mt-3 text-center">
                            {{-- <a class="btn_cv_emp" href="{{ route('empresa.cv_postulante', ['empresa' =>  $aviso->empresas->link, 'slug' =>  $aviso->link, 'alumno' => $postulante->alumno_id ]) }}" target="_blank"> Descargar CV del Postulante</a> --}}
                            <a class="btn_cv_emp"
                                href="{{ route('empresa.cv_postulante', ['empresa' => $aviso->empresas->id, 'slug' => $aviso->id, 'alumno' => $postulante->alumno_id]) }}"
                                target="_blank"> Descargar CV del Postulante</a>
                        </div>

                    </div>

                    <div class="card aviso mt-2">
                        {{-- <a href="{{ route('empresa.postulantes', ['empresa' => $aviso->empresas->link, 'slug' => $aviso->link]) }}" class="text-uppercase">Regresar</a> --}}
                        <a href="{{ route('empresa.postulantes', ['empresa' => $aviso->empresas->id, 'slug' => $aviso->id]) }}"
                            class="text-uppercase">Regresar</a>

                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card empresa">
                        <h5>Calificar</h5>
                        <div class="form-group">
                            <div class="formulario">
                                <select id="clasificacion_id" name="clasificacion_id" class="form-input">
                                    @foreach ($estados as $q)
                                        <option value="{{ $q->id }}"
                                            {{ $postulante != null && $postulante->estado_id == $q->id ? 'selected' : '' }}>
                                            {{ $q->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-5">
                            <h5>Detalles</h5>
                            <p>Públicado: {{ \Carbon\Carbon::parse($aviso->created_at)->format('d-m-Y') }}</p>
                            <p>{{ ($aviso->provincias != null ? $aviso->provincias->nombre : '') . ($aviso->distritos != null ? '' . $aviso->distritos->nombre : '') }}
                            </p>
                            <p>{{ $aviso->areas != null ? $aviso->areas->nombre : '-' }}</p>
                            <p>{{ $aviso->salario }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 text-center">
                    <a href="https://wa.me/923001874?text=Hola,vengo%20de%20la%20bolsa%20de%20trabajo%20y%20deseo%20conocer%20más%20de%20los%20servicios%20gratuitos%20para%20las%20empresas%20aliadas."
                        target="_blank">
                        <img src="{{ asset('app/img/nuevaimagen.png') }}" alt="Logo de WhatsApp">
                    </a>
                    <!-- Modal de advertencia -->
                    <div class="modal fade" id="modalAdvertencia" tabindex="-1" role="dialog"
                        aria-labelledby="modalAdvertenciaLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalAdvertenciaLabel">
                                        <i class="fa fa-exclamation-circle text-warning mr-2"></i>¡Atención!
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Por favor, asegúrate de calificar al postulante antes de continuar.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Entendido</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- FIN MODAL --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        const POSTULANTE = {{ $postulante->alumno_id }}
        const AVISO = {{ $postulante->aviso_id }}
    </script>
    <script type="text/javascript" src="{{ asset('app/js/avisos/postulante_informacion.js') }}"></script>
@endsection
