@extends('auth.index')

@section('titulo')
    <title>BolsaTrabajo | Alumnos</title>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('auth/plugins/datatable/datatables.min.css') }}">
@endsection
<style type="text/css">
    .txt_claro {
        background: #79f57f63;
        /* color: #fff; */
    }

    .label-as-badge {
        border-radius: 1em;
        font-size: 12px;
        cursor: pointer;
    }

    table {
        padding-top: 28px !important;
    }

    table.dataTable th,
    table.dataTable td {
        white-space: nowrap;
    }

    .sorting_1 {
        padding-left: 30px !important;
    }
</style>
@section('contenido')
    <div class="content-wrapper">

        <section class="content-header">
            <h1>
                Listado Estudiantes
                <small>Mantenimiento</small>
            </h1>
        </section>

        <br>
        <div class="content-header">
            <div class="form-row">
                <div class="form-group col-lg-6 col-md-6">
                    <label for="ruc_dni" class="m-0 label-primary">DNI o Apellidos del Estudiante</label>
                    <input type="text" class="form-control-m form-control-sm" id="dni_apellido" placeholder="Buscar...">
                </div>
                <div class="form-group col-lg-3 col-md-12 d-flex flex-column">
                    <label for="" class="m-0 w-100">.</label>
                    <a href="javascript:void(0)" class="btn-m btn-primary-m" onclick="consultarAlumno()">
                        <i class="fa fa-search"></i> Consultar</a>
                </div>
                {{-- <div class="form-group col-lg-3 col-md-12 d-flex flex-column">
                    <label for="" class="m-0 w-100">.</label>
                    <a href="javascript:void(0)" id="btn_mostrar" class="btn-m btn-primary-m" mostrar="" onclick="mostrarTodo()">
                        <i class="fa fa-eye"></i> Mostrar toda la Data</a>
                </div> --}}

            </div>
        </div>
        <hr>
        <!-- width="100%" class='display responsive no-wrap table table-bordered table-hover table-condensed' -->

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
                            <label for="" class="m-0 w-100">.</label>
                            <a href="javascript:void(0)" id="btn_mostrar" class="btn-m btn-primary-m" mostrar=""
                                onclick="mostrarTodo()" style="padding: 7.5px; background: #464646;">
                                <i class="fa fa-eye"></i> Mostrar toda la Data</a>
                        </div>
                    </div>
                    <table id="tableAlumno" width="100%"
                        class='table dataTables_wrapper container-fluid dt-bootstrap4 no-footer'></table>
                    {{-- <table id="tableAlumno" width="100%" class='display responsive no-wrap table table-bordered table-hover table-condensed'></table> --}}
                </div>
            </div>
            <div class="form-group col-lg-3 col-md-12 d-flex flex-column">
                <a href="javascript:void(0)" class="btn-m btn-success-m" onclick="clickExcelAlumno()">
                    <i class="fa fa-file"></i> Exportar excel</a>
            </div>
        </section>

    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/dataTables.config.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/js/alumno/index.js') }}"></script>
@endsection
