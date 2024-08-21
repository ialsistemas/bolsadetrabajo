@extends('auth.index')

@section('titulo')
    <title>BolsaTrabajo | Avisos</title>
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
        padding-top: 40px !important;
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

        <section class="content-header d-flex justify-content-between align-items-center">          
                <h2>
                    Listado Avisos
                    <small>| Mantenimiento</small>
                </h2>           
            <!-- Botón de refresco alineado a la derecha -->
            <div>
                <a href="javascript:void(0)" class="btn-m btn-secondary-m" onclick="window.location.reload();">
                    <i class="fa fa-refresh"></i> Refrescar | Listado de Avisos
                </a>
            </div>
        </section>
        


        <br>
        <div class="content-header">
            <div class="form-row">
                <div class="form-group col-lg-6 col-md-6">
                    <label for="ruc_dni" class="m-0 label-primary">Ruc/DNI del Empleador</label>
                    <input type="text" class="form-control-m form-control-sm" id="ruc_dni"
                        placeholder="Buscar...">
                </div>
                <div class="form-group col-lg-3 col-md-12 d-flex flex-column">
                    <label for="" class="m-0 w-100">.</label>
                    <a href="javascript:void(0)" class="btn-m btn-primary-m" onclick="consultarAvisos()">
                        <i class="fa fa-search"></i> Consultar por Ruc/DNI</a>
                </div>
                <div class="form-group col-lg-3 col-md-12 d-flex flex-column">
                    <label for="" class="m-0 w-100">.</label>
                    <a href="javascript:void(0)" id="btn_pendientes" class="btn-m btn-warning-m"
                        onclick="mostrarPendientes()"><i class="fa fa-exclamation-triangle"></i> Pendientes por Activar</a>
                </div>

            </div>
        </div>
        <hr>
        <div class="content-header" style="background-color:#00b98b12 !important;">
            <div class="form-row">
                <div class="form-group col-lg-4 col-md-4">

                    <label for="actividad_eco_filter_id" class="m-0 label-primary" style="color:#004130 !important;">Filtro
                        por Año</label>
                        <select name="fechasemestre" id="fechasemestre" class="form-control-m form-control-sm" required>
                            <option value="" selected="true">-- Seleccione... --</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                        </select>                      
                </div>
                <div class="form-group col-lg-3 col-md-12 d-flex flex-column">
                    <label for="" class="m-0 w-100">.</label>
                    <a href="javascript:void(0)" class="btn-m btn-primary-m" onclick="mostrarTodoxAño()"
                        style="padding: 7.5px; background: #00b98b;">
                        <i class="fa fa-search"></i> Filtrar por Año</a>
                        
                </div>
               
            </div>
        </div>
        <hr>

        <section class="content-header">
            @csrf
            <!-- width="100%" class='display responsive no-wrap table table-bordered table-hover table-condensed' -->
            <div class="row">
                <div class="col-md-12">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="alert alert-success" role="alert">
                                <span class="fa fa-check-circle"></span> <!-- Icono de check -->
                                <strong>¡Atención!</strong> Para ver toda la información en la tabla, haz clic en el botón.
                            </div>
                        </div>
                        <div class="form-group col-lg-3 col-md-6 d-flex flex-column">
                            <a href="javascript:void(0)" id="btn_mostrar" class="btn-m btn-primary-m" mostrar=""
                                onclick="mostrarTodo()" style="padding: 7.5px; background: #464646;">
                                <i class="fa fa-eye"></i> Mostrar toda la Data</a>
                        </div>
                    </div>


                    <table id="tableAviso" width="100%"
                        class='table dataTables_wrapper container-fluid dt-bootstrap4 no-foote'></table>
                    {{-- <table id="tableAviso" width="100%" class='display responsive no-wrap table table-bordered table-hover table-condensed'></table> --}}
                </div>
                <div class="form-group col-lg-3 col-md-12 d-flex flex-column">
                    <!-- Botón para exportar en Excel -->
                    <a href="javascript:void(0)" class="btn-m btn-success-m mb-2" onclick="clickExcelAvisos()">
                        <i class="fa fa-file"></i> Exportar en Excel
                    </a>
                    
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
