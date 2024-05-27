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
                    <div class="col-md-6">
                        <a href="{{ route('empresa.registrar_aviso') }}" class="pull-right">Nueva oportunidad</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-md-3 filter-cont">
                    <div class="filter">
                        <div class="info-group">
                            <p> Postulantes <br> <span>{{ count($alumnosAvisos->where('estado_id', \BolsaTrabajo\App::$ESTADO_POSTULANTES)->pluck('aviso_id')->toArray()) }}</span> </p>
                            <p> Evaluandos <br> <span>{{ count($alumnosAvisos->where('estado_id', \BolsaTrabajo\App::$ESTADO_EVALUANDO)->pluck('aviso_id')->toArray()) }}</span> </p>
                            {{-- <p> Seleccionados <br> <span>{{ count($alumnosAvisos->where('estado_id', \BolsaTrabajo\App::$ESTADO_SELECCIONADOS)->pluck('aviso_id')->toArray()) }}</span> </p> --}}
                            <p> Aceptados <br> <span>{{ count($alumnosAvisos->where('estado_id', \BolsaTrabajo\App::$ESTADO_ACEPTADOS)->pluck('aviso_id')->toArray()) }}</span> </p>
                            <p> Descartados <br> <span>{{ count($alumnosAvisos->where('estado_id', \BolsaTrabajo\App::$ESTADO_DESCARTADOS)->pluck('aviso_id')->toArray()) }}</span> </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">

                    <div id="postulantes">
                        <div id="cards-list" class="content avisos endless-pagination" data-next-page>
                           <div class="col-md-12">
                               @foreach($postulantes as $q)
                                   <div class="row">
                                       <div class="card aviso col-md-12">
                                           <div class="row">
                                               <div class="col-md-9">
                                                   <h5><b>{{ ($q->alumnos->nombres != "" ? $q->alumnos->nombres : ""). ($q->alumnos->apellido != "" ? " ".$q->alumnos->apellido->nombre: "") }} |                          
                                                    @foreach ($Grado_academico as $item)
                                                        @if($q->alumnos->egresado == $item->id)
                                                            {{ $item->grado_estado }}
                                                        @endif
                                                    @endforeach</b> </h5>
                                                   <p>
                                                        @foreach ($area as $val)
                                                            @if($q->alumnos->area_id == $val->id)
                                                                {{ $val->nombre }}
                                                            @endif
                                                        @endforeach   
                                                   </p>
                                                   <p> @foreach ($Distrito as $item)
                                                            @if ($q->alumnos->distrito_id == $item->id)
                                                                {{ $item->nombre }}
                                                            @endif
                                                        @endforeach | {{ $q->alumnos->telefono }}</p> 
                                                   {{-- <p>{{ ($aviso->provincias != null ?$aviso->provincias->nombre : "-").($aviso->distritos != null ? "," .$aviso->distritos->nombre : "-") }} | {{ $q->alumnos->telefono }} | {{ $q->alumnos->email }}</p>    --}}
                                               </div>
                                               <div class="col-md-2 info-alumno">
                                                   {{-- <a href="{{ route('empresa.postulante_informacion', ['empresa' =>  $aviso->empresas->link, 'slug' =>  $aviso->link, 'alumno' => $q->alumnos->usuario_alumno ]) }}" class="text-uppercase">Ver</a> --}}
                                                   <a href="{{ route('empresa.postulante_informacion', ['empresa' =>  $aviso->empresas->id, 'slug' =>  $aviso->id, 'alumno' => $q->alumnos->usuario_alumno ]) }}" class="text-uppercase">Ver</a>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               @endforeach
                           </div>
                        </div>
                    </div>

                    <div class="card aviso mt-2">
                        <a href="{{ route('empresa.avisos') }}" class="text-uppercase">Regresara</a>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card empresa">
                        <h5>{{ $aviso->empresas != null ? $aviso->empresas->nombre_comercial : "-" }}</h5>
                        <p>Públicado: {{ \Carbon\Carbon::parse($aviso->created_at)->format('d-m-Y') }}</p>
                        <p>{{ ($aviso->provincias != null ? $aviso->provincias->nombre : ""). ($aviso->distritos != null ? " ".$aviso->distritos->nombre: "") }}</p>
                        {{-- <p>{{ $aviso->horarios != null ? $aviso->horarios->nombre : "-" }}</p>
                        <p>{{ $aviso->modalidades != null ? $aviso->modalidades->nombre : "-" }}</p> --}}
                        <p>{{ $aviso->areas != null ? $aviso->areas->nombre : "-" }}</p>
                        <p>{{ $aviso->salario }}</p>
                    </div>
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

