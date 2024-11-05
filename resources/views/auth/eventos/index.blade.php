@extends('auth.index')

@section('titulo')
    <title>BolsaTrabajo | Eventos</title>
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
                Eventos 
                {{-- <small>Mantenimiento</small> --}}
            </h1>
            {{-- <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <button type="button" id="modalRegistrarEventos" class="btn-primary"><i class="fa fa-plus"></i> Registrar
                        Evento</button>
                </li>
            </ol> --}}
        </section>

        <br>
        <div class="content-header">
            <form enctype="multipart/form-data" action="{{ route('auth.eventos.store') }}" id="registroEventos" method="POST">
                @csrf <!-- Asegúrate de incluir el token CSRF para la seguridad -->
                <div class="form-row">
                    <div class="form-group col-lg-5 col-md-4">
                        <label for="fecha_registro" class="m-0 label-primary">Fecha de Evento</label>
                        <input type="date" class="form-control form-control-sm" id="fecha_registro" name="fecha_registro"
                            required>
                    </div>

                    <div class="form-group col-lg-5 col-md-4">
                        <label for="nombre" class="m-0 label-primary">Nombre de Evento</label>
                        <input type="text" class="form-control form-control-sm" id="nombre" name="nombre"
                            placeholder="Nombre del evento" required>
                    </div>

                    <div class="form-group col-lg-2 col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Registrar Evento
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <hr>
        <section class="content-header">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    {{-- <div class="row align-items-center">
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
                    </div> --}}
                    <table id="tableEventos" width="100%"
                        class='table dataTables_wrapper container-fluid dt-bootstrap4 no-footer'></table>
                </div>
            </div>
            {{--  <div class="form-group col-lg-3 col-md-12 d-flex flex-column">
                <div class="form-group col-lg-3 col-md-12 d-flex flex-column">
                    <a href="javascript:void(0)" class="btn-m btn-success-m" onclick="clickExcel()">Exportar excel</a>
                </div>
            </div> --}}
        </section>
        <hr>
        {{-- <section class="content-header">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <table id="tableParticipantesAsistentes" width="100%"
                        class='table dataTables_wrapper container-fluid dt-bootstrap4 no-footer'></table>
                </div>
            </div>
        </section> --}}
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/dataTables.config.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/js/eventos/index.js') }}"></script>
@endsection
