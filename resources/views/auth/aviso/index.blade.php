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
    table{
        padding-top:40px !important;
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
                Listado Avisos
                <small>Mantenimiento</small>
            </h1>
        </section>


        <br>
        <div class="content-header">
            <div class="form-row">
                <div class="form-group col-lg-6 col-md-6">
                    <label for="ruc_dni" class="m-0 label-primary">Ruc/DNI del Empleador</label>
                    <input type="text" class="form-control-m form-control-sm" id="ruc_dni">
                </div>
                <div class="form-group col-lg-3 col-md-12 d-flex flex-column">
                    <label for="" class="m-0 w-100">.</label>
                    <a href="javascript:void(0)" class="btn-m btn-primary-m" onclick="consultarAvisos()">Consultar</a>
                </div>
                <div class="form-group col-lg-3 col-md-12 d-flex flex-column">
                    <label for="" class="m-0 w-100">.</label>
                    <a href="javascript:void(0)" id="btn_pendientes" class="btn-m btn-warning-m" onclick="mostrarPendientes()">Pendientes por Activar</a>
                </div>
                <div class="form-group col-lg-3 col-md-12 d-flex flex-column">
                    <a href="javascript:void(0)" id="btn_mostrar" class="btn-m btn-primary-m" mostrar="" onclick="mostrarTodo()">Mostrar toda la Data</a>
                </div>
                <div class="form-group col-lg-3 col-md-12 d-flex flex-column">
                    <a href="javascript:void(0)" class="btn-m btn-success-m" onclick="clickExcelAvisos()">Exportar excel</a>
                </div>
              </div>
        </div>
        <hr>

        <section class="content-header">
            @csrf
            <!-- width="100%" class='display responsive no-wrap table table-bordered table-hover table-condensed' -->
            <div class="row">
                <div class="col-md-12">
                    <table id="tableAviso" width="100%" class='table dataTables_wrapper container-fluid dt-bootstrap4 no-foote'></table>
                    {{-- <table id="tableAviso" width="100%" class='display responsive no-wrap table table-bordered table-hover table-condensed'></table> --}}
                </div>
            </div>
        </section>

    </div>



@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/dataTables.config.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/js/aviso/index.js') }}"></script>
@endsection
