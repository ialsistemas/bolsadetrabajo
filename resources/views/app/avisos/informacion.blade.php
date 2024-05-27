@extends('app.index')

@section('styles')
    <link rel="stylesheet" href="{{ asset('app/css/avisos/index.css') }}">
@endsection

@section('content')

    <div id="main">

        <div class="head-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Listado de postulantes</h3>
                    </div>
                    @if(Auth::guard('empresasw')->user())
                        <div class="col-md-6">
                            <a href="{{ route('empresa.registrar_aviso') }}" class="pull-right">Nueva oportunidad</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-md-3 filter-cont">
                    <div class="filter">
                        @if(Auth::guard('empresasw')->check())
                            <div class="info-group">
                                <p> Postulantes <br> <span>{{ count($alumnosAvisos->where('estado_id', \BolsaTrabajo\App::$ESTADO_POSTULANTES)->pluck('aviso_id')->toArray()) }}</span> </p>
                                <p> Evaluandos <br> <span>{{ count($alumnosAvisos->where('estado_id', \BolsaTrabajo\App::$ESTADO_EVALUANDO)->pluck('aviso_id')->toArray()) }}</span> </p>
                                {{-- <p> Seleccionados <br> <span>{{ count($alumnosAvisos->where('estado_id', \BolsaTrabajo\App::$ESTADO_SELECCIONADOS)->pluck('aviso_id')->toArray()) }}</span> </p> --}}
                                <p> Aceptados <br> <span>{{ count($alumnosAvisos->where('estado_id', \BolsaTrabajo\App::$ESTADO_ACEPTADOS)->pluck('aviso_id')->toArray()) }}</span> </p>
                                <p> Descartados <br> <span>{{ count($alumnosAvisos->where('estado_id', \BolsaTrabajo\App::$ESTADO_DESCARTADOS)->pluck('aviso_id')->toArray()) }}</span> </p>
                                <div class="mt-5">
                                    {{-- <a href="{{ route('empresa.postulantes', ['empresa' => $aviso->empresas->link, 'slug' => $aviso->link ])  }}" class="text-uppercase"> --}}
                                    <a href="{{ route('empresa.postulantes', ['empresa' => $aviso->empresas->id, 'slug' => $aviso->id ])  }}" class="text-uppercase">
                                        Ver Postulantes
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="content-card-user-info">
                                <div class="sub-title text-center">
                                    <h5>Evaluación Progresiva</h5>
                                </div>
                                @if($alumnoAviso != null && !in_array($alumnoAviso->estado_id, [\BolsaTrabajo\App::$ESTADO_DESCARTADOS]))
                                <div class="row">
                                    <div class="col-md-3"><div class="progress-line {{ $alumnoAviso != null && in_array($alumnoAviso->estado_id, [\BolsaTrabajo\App::$ESTADO_POSTULANTES, \BolsaTrabajo\App::$ESTADO_EVALUANDO, \BolsaTrabajo\App::$ESTADO_SELECCIONADOS, \BolsaTrabajo\App::$ESTADO_ACEPTADOS]) ? "active" : "" }}"></div></div>
                                    <div class="col-md-3"><div class="progress-line {{ $alumnoAviso != null && in_array($alumnoAviso->estado_id, [\BolsaTrabajo\App::$ESTADO_EVALUANDO, \BolsaTrabajo\App::$ESTADO_SELECCIONADOS, \BolsaTrabajo\App::$ESTADO_ACEPTADOS]) ? "active" : "" }}"></div></div>
                                    <div class="col-md-3"><div class="progress-line {{ $alumnoAviso != null && in_array($alumnoAviso->estado_id, [\BolsaTrabajo\App::$ESTADO_SELECCIONADOS, \BolsaTrabajo\App::$ESTADO_ACEPTADOS]) ? "active" : "" }}"></div></div>
                                    <div class="col-md-3"><div class="progress-line {{ $alumnoAviso != null && in_array($alumnoAviso->estado_id, [\BolsaTrabajo\App::$ESTADO_ACEPTADOS]) ? "active" : "" }}"></div></div>
                                </div>
                                @else
                                    <div class="row">
                                        <div class="col-md-3"><div class="progress-line {{ $alumnoAviso != null ? "descarte" : "" }}"></div></div>
                                        <div class="col-md-3"><div class="progress-line {{ $alumnoAviso != null ? "descarte" : "" }}"></div></div>
                                        <div class="col-md-3"><div class="progress-line {{ $alumnoAviso != null ? "descarte" : "" }}"></div></div>
                                        <div class="col-md-3"><div class="progress-line {{ $alumnoAviso != null ? "descarte" : "" }}"></div></div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card aviso">
                        <h5>{{ $aviso->titulo }}</h5>
                        <p><?php echo $aviso->descripcion  ?></p>
                    </div>
                    <div class="card aviso mt-2">
                        @if(Auth::guard('alumnos')->user())
                            <button id="postular" type="button" data-info="{{ $aviso->id }}" class="{{ $alumnoAviso ? "postulaste" : "" }}" {{ $alumnoAviso ? "disabled" : "" }}>{{ $alumnoAviso ? "Ya estas postulando" : "Postularme" }}</button>
                        @endif

                        @if (Auth::guard('empresasw')->check())
                            <a href="{{ Auth::guard('alumnos')->user() ? route('alumno.avisos') : route('empresa.avisos') }}" class="text-uppercase">Regresar</a> 
                        @else
                            <a href="javascript:void(0);" class="text-uppercase" onclick="regresar()">Regresar</a>
                        @endif

                        
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card empresa">
                        <h5><a style="font-size: 1rem; !important;font-weight: 600" href="{{ route('alumno.empresa_informacion', ['empresa' => $aviso->empresas->link]) }}">{{ $aviso->empresas != null ? $aviso->empresas->nombre_comercial : "-" }}</a></h5>
                        <p>Públicado: {{ \Carbon\Carbon::parse($aviso->created_at)->format('d-m-Y') }}</p>
                        <p>{{ ($aviso->distritos != null ? $aviso->distritos->nombre: "-") }}</p>
                        {{-- <p>{{ $aviso->horarios != null ? $aviso->horarios->nombre : "-" }}</p>
                        <p>{{ $aviso->modalidades != null ? $aviso->modalidades->nombre : "-" }}</p> --}}
                        <p>{{ $aviso->areas != null ? $aviso->areas->nombre : "-" }}</p>
                        <p>{{ $aviso->salario }}</p>
                    </div>
                </div>
                <div class="col-md-2 text-center">
                    @if (Auth::guard('empresasw')->check())
                        <a href="https://wa.link/wyggli" target="_blank">
                            <img src="{{ asset('app/img/banner_empresa.jpeg') }}" alt="">
                        </a>
                    @else
                        <a href="https://wa.me/922611913?text=Hola, Vengo de la Bolsa de trabajo y quiero conocer más sobre los programas de empleabilidad. Información por favor 😊" target="_blank">
                            <img src="{{ asset('app/img/banner2_janet.png') }}" alt="">
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('app/js/avisos/informacion.min.js') }}"></script>
    <script>
        function regresar(){
            window.history.back();
        }
    </script>
@endsection
