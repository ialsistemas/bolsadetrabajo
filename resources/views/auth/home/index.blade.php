@extends('auth.index')

@section('titulo')
    <title>BolsaTrabajo | Empresas</title>
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
        padding-top:28px !important;
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
                Listado Empleador
                <small>Mantenimiento</small>
            </h1>
        </section>
        <br>
        <div class="content-header">
            <div class="form-row">
                <div class="form-group col-lg-5 col-md-6">
                    <label for="ruc_dni" class="m-0 label-primary">Desde</label>
                    <input type="date" class="form-control-m form-control-sm" max="<?php echo date('Y-m-d'); ?>" id="fecha_desde" name="fecha_desde" value="<?php echo date('Y-m-01'); ?>">
                </div>
                <div class="form-group col-lg-4 col-md-6">
                    <label for="ruc_dni" class="m-0 label-primary">Hasta</label>
                    <input type="date" class="form-control-m form-control-sm" max="<?php echo date('Y-m-d'); ?>" id="fecha_hasta" name="fecha_hasta" value="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="form-group col-lg-3 col-md-6">
                    
                  </div>
                <div class="form-group col-lg-5 col-md-6">
                  <label for="ruc_dni" class="m-0 label-primary">RUC / DNI o Nombre Comercial</label>
                  <input type="text" class="form-control-m form-control-sm" id="ruc_dni">
                </div>
                <div class="form-group col-lg-4 col-md-6">
                    <label for="actividad_eco_filter_id" class="m-0 label-primary">Tipo de Persona</label>
                    <select name="actividad_eco_filter_id" id="actividad_eco_filter_id" class="form-control-m form-control-sm" required>
                        <option value="" selected>-- Seleccione --</option>
                        @foreach($tipo_persona as $q)
                            <option value="{{ $q->id }}">{{ $q->tipo }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group col-lg-3 col-md-12 d-flex flex-column">
                    <label for="" class="m-0 w-100">.</label>
                    <a href="javascript:void(0)" class="btn-m btn-primary-m" onclick="consultarEmpleador()">Consultar</a>
                </div>
                <div class="form-group col-lg-3 col-md-12 d-flex flex-column">
                    <a href="javascript:void(0)" id="btn_mostrar" class="btn-m btn-primary-m" mostrar="" onclick="mostrarTodo()">Mostrar toda la Data</a>
                </div>
                <div class="form-group col-lg-3 col-md-12 d-flex flex-column">
                    <a href="javascript:void(0)" class="btn-m btn-success-m" onclick="clickExcel()">Exportar excel</a>
                </div>
              </div>
        </div>
        <hr>
        <section class="content-header">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <table id="tableEmpresa" width="100%" class='table dataTables_wrapper no-wrap container-fluid dt-bootstrap4 no-footer'></table>
                    {{-- <table id="tableEmpresa" width="100%" class='table responsive dataTables_wrapper no-wrap'></table> --}}
                    {{-- <table id="tableEmpresa" width="100%" class='display responsive no-wrap table table-bordered table-hover table-condensed'></table> --}}
                </div>
            </div>
        </section>

    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/dataTables.config.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/js/empresa/index.js') }}"></script>
@endsection
