@extends('auth.index')

@section('titulo')
    <title>BolsaTrabajo | Inicio</title>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('auth/plugins/datatable/datatables.min.css') }}">
@endsection
<style type="text/css">

    .txt_claro{
        background: #79f57f63;
        /* color: #fff; */
    }
    .label-as-badge {
        border-radius: 1em;
        font-size: 12px;
        cursor: pointer;
    }
    table.dataTable th,
    table.dataTable td {
        white-space: nowrap;
    }
    .sorting_1{
        padding-left: 30px !important;
    }
</style>

@section('contenido')
    <div class="content-wrapper">

        <div class="app-page-title app-page-title-simple">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div>
                        <div class="page-title-head center-elem">
                            <span class="d-inline-block">| Datos Generales</span>
                        </div>
                        <div class="page-title-subheading opacity-10">
                            <nav class aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a>
                                            <i aria-hidden="true" class="fa fa-home"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a>Inicio</a>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="page-title-actions">
                </div>
            </div>
        </div>
        
        <div class="mbg-3 alert alert-info alert-dismissible fade show" role="alert">
            <span class="pr-2">
                <i class="fa fa-question-circle"></i>
            </span>
            Estos son los datos <b class="title_fechas">de este mes</b>
        </div>
        
        
        <div class="col-md-12 mb-3 card">
            <div class="card-header-tab card-header">
                <div class="card-header-title font-size-lg  font-weight-normal">
                    <i class="fa fa-certificate icon-gradient bg-amy-crisp" style="color:#F7B924; margin-right:5px;"></i> 
                    <span class="w-100"> Nuevos Registros a la Plataforma Bolsa de Trabajo</span>
                   
                </div>
                <div class="btn-actions-pane-right text-capitalize">
                    <div class="d-inline-block pr-3 d-flex">
                        <input type="date" class="form-control data_input_fecha" name="daterange" value="">
                        <button type="button" class="btn btn-primary d-flex consultar_data_fecha">
                            <i class="fa-solid fa-magnifying-glass pt-1" style="margin-right:10px;"></i> Consultar</button>
                    </div>
                </div>
            </div>
        
            <div class="no-gutters row">
        
                <div class="col-sm-6 col-md-4 col-xl-4">
                    <div class="card no-shadow rm-border bg-transparent widget-chart text-left">
                        <div class="icon-wrapper rounded-circle">
                            <div class="icon-wrapper-bg opacity-10 bg-warning"></div>
                            <svg xmlns="http://www.w3.org/2000/svg" style="z-index:5; color:#fff !important;" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                            </svg>
                        </div>
                        <div class="widget-chart-content">
                            <div class="widget-subheading">Nuevos Empleadores</div>
                            <div class="widget-numbers" id="cuadro_contador_empleador"></div>
                            <div class="widget-description opacity-8 text-focus">
                                <div id="status_empleador" class="d-inline pr-1">
                                    <span class="pl-1"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="divider m-0 d-md-none d-sm-block"></div>
                </div>
        
                <div class="col-sm-6 col-md-4 col-xl-4">
                    <div class="card no-shadow rm-border bg-transparent widget-chart text-left">
                        <div class="icon-wrapper rounded-circle">
                            <div class="icon-wrapper-bg opacity-9 bg-info"></div>
                            <svg xmlns="http://www.w3.org/2000/svg" style="z-index:5; color:#fff !important;" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                            </svg>
                        </div>
                        <div class="widget-chart-content">
                            <div class="widget-subheading">Nuevos Alumnos</div>
                            <div class="widget-numbers" id="cuadro_contador_estudiante"></div>
                            <div class="widget-description opacity-8 text-focus">
                                <span id="status_alumnos" class="d-inline pl-1">
                                    <span class="pl-1"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="divider m-0 d-md-none d-sm-block"></div>
                </div>
        
                <div class="col-sm-12 col-md-4 col-xl-4">
                    <div class="card no-shadow rm-border bg-transparent widget-chart text-left">
                        <div class="icon-wrapper rounded-circle">
                            <div class="icon-wrapper-bg opacity-9 bg-success"></div>
                            <svg xmlns="http://www.w3.org/2000/svg" style="z-index:5; color:#fff !important;" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div class="widget-chart-content">
                            <div class="widget-subheading">Nuevos Avisos</div>
                            <div class="widget-numbers text-success" id="cuadro_contador_aviso"></div>
                            <div class="widget-description text-focus">
                                <span id="status_avisos" class="d-inline pl-1">
                                    <span class="pl-1"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
        
            </div>
            <div class="text-center d-block p-3 card-footer">
                <a href="" class="btn-pill btn-shadow btn-wide fsize-1 btn btn-primary btn-lg">
                    <span class="mr-2 opacity-7">
                        <i class="fa fa-refresh"></i>
                    </span>
                    <span class="mr-1">Actualizar</span>
                </a>
            </div>
        </div>
        
        
        <div class="col-md-12 mb-3 card">
            <div class="card-header-tab card-header">
                <div class="card-header-title font-size-lg text-capitalize font-weight-normal w-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-warning" style="width:20px; margin-right:10px;" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                    Seguimiento Registro Empleadores <?= date('Y') ?>
                </div>
            </div>
            <div class="p-0 card-body">
                <figure class="highcharts-figure">
                    <div id="container_line"></div>
                </figure>
            </div>
        </div>
        
        <div class="col-md-12 mb-3 card">
            <div class="card-header-tab card-header">
                <div class="card-header-title font-size-lg text-capitalize font-weight-normal w-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-info" style="width:20px; margin-right:10px;" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                    Seguimiento Registro Estudiantes <?= date('Y') ?>
                </div>
            </div>
            <div class="p-0 card-body">
                <figure class="highcharts-figure">
                    <div id="container_line_estudiantes"></div>
                </figure>
            </div>
        </div>
        
        
        
        <!--Graficos de inicio-->
        
        <div class="row">
            <div class="col-md-12">
                <div class="well with-header with-footer">
                    <div class="table-scrollable row">
        
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div id="graficEmpleadores" style="width: 100%; height: 380px;"></div>
                        </div>
        
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div id="graficEstudiantes" style="width: 100%; height: 380px;"></div>
                        </div>
        
                        <div class="col-xs-12 col-sm-12 col-md-6 mt-4">
                            <div id="graficAvisos" style="width: 100%; height: 380px;"></div>
                        </div>
        
                    </div>
                </div>
            </div>
        </div>

    </div>



@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/dataTables.config.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/js/anuncio/index.js') }}"></script>
@endsection
