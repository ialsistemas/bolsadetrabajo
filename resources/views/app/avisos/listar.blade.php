@extends('app.index')

@section('styles')
    <link rel="stylesheet" href="{{ asset('app/css/avisos/index.min.css') }}">
    <link rel="stylesheet" href="{{ asset('auth/plugins/datatable/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('app/css/empresa/style.css') }}">
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
                            {{-- Fin Style --}}
                            @if (Auth::guard('empresasw')->check())
                                @if (Auth::guard('empresasw')->user()->tipo_persona == 2)
                                    <div class="content_pNatural">
                                        <p>
                                            Nuestros asesores están listos para ayudarte a encontrar el talento adecuado.
                                            Por favor, contáctanos para obtener asistencia personalizada en la publicación
                                            de tu aviso.
                                        </p>
                                        <a href="https://wa.link/0q0eyc" target="_blank" class="btn btn-success w-100 p-3 button btn-empresa">
                                            <i class="fa fa-whatsapp"></i> Contactar a un Asesor</a>
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
                                {{-- Se cambio la fecha --}}
                                <input type="date" id="fecha_desde"
                                    value="{{ request()->input('fecha_desde', date('2024-01-01')) }}" name="fecha_desde"
                                    class="form-control date-empresa">
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
                                    class="form-control date-empresa">
                                @error('fecha_hasta')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <br>
                            <button type="submit" id="filtro-submit" class="btn btn-primary btn-sm btn-filtro"
                                onclick="consultarEmpleador()">Aplicar
                            Filtro</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="row justify-content-center mt-4">
                        @php
                            $rucsPermitidos = ['20101267467', '20100054184', '20109015611', '20511211639', '20101281966', '20501781291', '20100579228', '20523915399', '20305354563', '20607030635', '20605267395', '20608458281', '20600937511', '20515774182', '20613902041', '20610958231', '20556690660', '20517738701', '20603847122', '20606567252', '20477983708', '20613599879', '20344818909', '20611187191', '1007948506', '20555113731', '20535637599'];
                        @endphp
                        @if ( Auth::guard('empresasw')->check() && in_array(Auth::guard('empresasw')->user()->ruc, $rucsPermitidos))
                            @if(Auth::guard('empresasw')->check() && Auth::guard('empresasw')->user()->logo == null)
                                <div class="col-lg-12 mb-3">
                                    <div class="alert alert-danger d-flex align-items-center justify-content-between" role="alert">
                                        <div>
                                            <i class="fa fa-exclamation-triangle mr-2"></i>
                                            <strong>¡Atención!</strong> Para publicar avisos de trabajo en la Bolsa de Trabajo, es obligatorio que subas el logo de tu empresa.
                                        </div>
                                        <a href="{{ route('empresa.perfil') }}" class="btn btn-sm btn-light ml-3">
                                            <i class="fa fa-upload mr-1"></i> Subir logo
                                        </a>
                                    </div>
                                </div>
                            @else
                                @foreach ($listaFeriaData as $listaFeria)
                                    <div class="col-lg-12">
                                        <div class="alert alert-info d-flex align-items-center justify-content-between" role="alert">
                                            <div>
                                                <i class="fa fa-bullhorn mr-2"></i>
                                                <strong>¡Atención!</strong> Se viene un gran evento: <strong>{{ $listaFeria->name }}</strong> inicia el 
                                                <strong>{{ $listaFeria->fecha_inicio }}</strong> y finaliza el 
                                                <strong>{{ $listaFeria->fecha_final }}</strong>. 
                                                Si estás interesado en participar:
                                            </div>
                                            <a href="{{ route('empresa.feria-empresa', $listaFeria->route) }}" class="btn btn-sm btn-primary ml-3">
                                                <i class="fa fa-sign-in-alt mr-1"></i> ¡Ingresa aquí!
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @endif
                        <div class="col-lg-12">
                            <div class="alert alert-success" role="alert">
                                <span class="fa fa-check-circle"></span>
                                Aplique filtros de fecha para ver sus avisos actualizados o anteriores según lo que requiera.
                            </div>
                        </div>
                    </div>
                    <table id="tableAviso"
                        class="table table-bordered table-striped display nowrap margin-top-10 dataTable no-footer"></table>
                </div>
                <div class="col-md-2 text-center">
                    <a href="https://wa.me/948536701?text=Hola,vengo%20de%20la%20bolsa%20de%20trabajo%20y%20deseo%20conocer%20más%20de%20los%20servicios%20gratuitos%20para%20las%20empresas%20aliadas." target="_blank">
                        <img src="{{ asset('app/img/nuevaimagen2.png') }}" alt="Logo de WhatsApp">
                    </a>
                    
                </div>
            </div>
        </div>
        <button hidden type="button" class="btn btn-primary btn-lg btn_evento_bolsa" data-toggle="modal"
            data-target="#tuto"></button>

        <button hidden type="button" class="btn btn-primary btn-lg btn_evento_bolsa" data-toggle="modal"
            data-target="#tuto">
        </button>
        <div class="modal fade bg-modal"
            id="{{ $anuncios->isEmpty() ? '' : 'tuto' }}" tabindex="-1" role="dialog" aria-labelledby="tuto"
            data-backdrop="static">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content bg-content-modal" style="">
                    <div class="modal-header modal-header-modal">
                        <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close"><span
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
                <span class="carusel-previous" aria-hidden="true"> ◀ </span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carusel-next" aria-hidden="true"> ▶ </span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/dataTables.config.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app/js/avisos/listar.js') }}"></script>
@endsection
