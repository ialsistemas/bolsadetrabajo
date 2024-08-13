@extends('auth.index')

@section('titulo')
    <title>BolsaTrabajo | Avisos</title>
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

        <section class="content-header">
            <h1>
                Listado de Postulantes por Aviso
                <small>Mantenimiento</small>
            </h1>
        </section>

        <br>
        <div class="content-header">
            <div class="form-row">
                <div class="form-group col-lg-2 col-md-6">
                    <label for="desde" class="m-0 label-primary">Desde</label>
                    <input type="date" class="form-control-m form-control-sm" id="desde" value="{{ Date('Y-m-d') }}">
                </div>
                <div class="form-group col-lg-2 col-md-6">
                    <label for="hasta" class="m-0 label-primary">Hasta</label>
                    <input type="date" class="form-control-m form-control-sm" id="hasta" value="{{ Date('Y-m-d') }}">
                </div>
                <div class="form-group col-lg-3 col-md-6">
                    <label for="carrera" class="m-0 label-primary">Carrera del Estudiante</label>
                    <select name="carrera" id="carrera" class="form-control-m form-control-sm">
                        <option value="">-- TODOS --</option>
                        @foreach($Areas as $q)
                            <option value="{{ $q->id }}">{{ $q->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-lg-3 col-md-6">
                    <label for="provincia" class="m-0 label-primary">Provincia del Estudiante</label>
                    <select name="provincia" id="provincia" class="form-control-m form-control-sm">
                        <option value="">-- TODOS --</option>
                        @foreach($Provincias as $q)
                            <option value="{{ $q->id }}">{{ $q->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-lg-2 col-md-6">
                    <label for="tipo_estudiante" class="m-0 label-primary">Tipo de Estudiante</label>
                    <select name="tipo_estudiante" id="tipo_estudiante" class="form-control-m form-control-sm">
                        <option value="">-- TODOS --</option>
                        @foreach($GradoAcademico as $q)
                            <option value="{{ $q->id }}">{{ $q->grado_estado }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-lg-3 col-md-12 d-flex flex-column">
                    <a href="javascript:void(0)" class="btn-m btn-primary-m" onclick="consultarAvisosPostulantes()">
                        <i class="fa fa-search"></i> Consultar</a>
                </div>
               {{--  <div class="form-group col-lg-3 col-md-12 d-flex flex-column">
                    <a href="javascript:void(0)" id="btn_mostrar" class="btn-m btn-primary-m" mostrar="" onclick="mostrarTodo()">Mostrar toda la Data</a>
                </div> --}}
                
            </div>
        </div>
        <hr>

        <section class="content-header">
            @csrf
            <div class="row">
                
                <div class="col-md-12">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="alert alert-success" role="alert">
                                <span class="fa fa-check-circle"></span> <!-- Icono de check -->
                                <strong>¡Atención!</strong> Para ver toda la información en la tabla, haz clic en el botón.
                            </div>
                        </div>
                        <div class="form-group col-lg-3 col-md-16 d-flex flex-column">
                            <a href="javascript:void(0)" id="btn_mostrar" class="btn-m btn-primary-m" mostrar="" onclick="mostrarTodo()"
                            style="padding: 7.5px; background: #464646;"><i class="fa fa-eye"></i> Mostrar toda la Data</a>
                        </div>
                    </div>
                    <table id="tableAvisoPostulantes" width="100%" class='display responsive no-wrap table table-bordered table-hover table-condensed'></table>
                </div>
            </div>
            <div class="form-group col-lg-3 col-md-12 d-flex flex-column">
                <a href="javascript:void(0)" class="btn-m btn-success-m" onclick="clickExcelAvisosPostulantes()">
                    <i class="fa fa-file"></i> Exportar excel</a>
            </div>
        </section>

    </div>



@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/dataTables.config.min.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('auth/js/aviso/index.js') }}"></script> --}}
    <script type="text/javascript" src="{{ asset('auth/js/avisoPostulacion/index.js') }}"></script>
@endsection
