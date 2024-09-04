@extends('auth.index')

@section('titulo')
    <title>BolsaTrabajo | Alumnos Sancionados</title>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('auth/plugins/datatable/datatables.min.css') }}">
@endsection

@section('contenido')
<style>
     .activo {
            background-color: green;
            color: white;
        }

        .inactivo {
            background-color: red;
            color: white;
        }
</style>
    <div class="content-wrapper">

        <section class="content-header">
            <h1>
                Alumnos Sancionados
                <small>Mantenimiento</small>
            </h1>
        </section>

        <br>
        <div class="content-header">
            <div class="form-row">
                
                <div class="form-group col-lg-5 col-md-6">
                  <label for="ruc_dni" class="m-0 label-primary">DNI del Estudiante</label>
                  <input type="text" class="form-control-m form-control-sm" id="ruc_dni" placeholder="Buscar...">
                </div>
                <div class="form-group col-lg-4 col-md-6">
                    <label for="actividad_eco_filter_id" class="m-0 label-primary">Estado</label>
                    <select name="actividad_eco_filter_id" id="actividad_eco_filter_id" class="form-control-m form-control-sm" required>
                        <option value="" selected>-- Seleccione --</option>
                            <option value="Activo">Activo</option>
                            <option value="Deshabilitado">Deshabilitado</option>                       
                    </select>
                </div>
                <div class="form-group col-lg-3 col-md-12 d-flex flex-column">
                    <label for="" class="m-0 w-100">.</label>
                    <a href="javascript:void(0)" class="btn-m btn-primary-m" onclick="consultarSancion()">
                        <i class="fa fa-search"></i> Consultar</a>
                </div>
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
                        <div class="form-group col-lg-3 col-md-12 d-flex flex-column">
                            <a href="javascript:void(0)" id="btn_mostrar" class="btn-m btn-primary-m" mostrar="" onclick="mostrarTodo()"
                            style="padding: 7.5px; background: #464646;">
                            <i class="fa fa-eye"></i> Mostrar toda la Data</a>
                        </div>
                    </div>
                    <table id="tableAlumnoSancionado" width="100%"
                        class='table dataTables_wrapper container-fluid dt-bootstrap4 no-footer'></table>
                </div>
            </div>
           {{--  <div class="form-group col-lg-3 col-md-12 d-flex flex-column">
                <div class="form-group col-lg-3 col-md-12 d-flex flex-column">
                    <a href="javascript:void(0)" class="btn-m btn-success-m" onclick="clickExcel()">Exportar excel</a>
                </div>
            </div> --}}
        </section>

    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/dataTables.config.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/js/alumnosancionado/index.js') }}"></script>
@endsection
