@extends('auth.index')

@section('titulo')
    <title>BolsaTrabajo | Programas de Inserción rápida</title>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('auth/plugins/datatable/datatables.min.css') }}">
@endsection

@section('contenido')
    <div class="content-wrapper">

        <section class="content-header">
            <h1>
                Certificados | Alumnos
            </h1>
        </section>

        <br>
        <div class="content-header">
            <div class="row">
                <form class="col-lg-4 col-md-4" action="{{ route('auth.certificados.store') }}" method="post">
                    @csrf
                    <div class="form-group col-lg-12">
                        <label for="nombre" class="m-0 label-primary">Nombre del Taller <b
                                style="color:red;font-size:10px">(Obligatorio*)</b></label>
                        <input autocomplete="off" type="text" class="form-control form-control-sm" id="nombre"
                            name="nombre" value="{{ old('nombre') }}" required placeholder="Nombre Empresa">
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="fecha" class="m-0 label-primary">Fecha</label>
                        <input type="date" class="form-control form-control-sm" id="fecha" name="fecha"
                            value="{{ old('fecha') }}" required>
                    </div>

                    <!-- Campo para Horas -->
                    <div class="form-group col-lg-12">
                        <label for="horas" class="m-0 label-primary">Horas <b
                                style="color:red;font-size:10px">(Obligatorio*)</b></label>
                        <input type="number" class="form-control form-control-sm" id="horas" name="horas"
                            value="{{ old('horas') }}" required placeholder="Número de Horas">
                    </div>

                    <!-- Campo para Créditos -->
                    <div class="form-group col-lg-12">
                        <label for="creditos" class="m-0 label-primary">Créditos <b
                                style="color:red;font-size:10px">(Obligatorio*)</b></label>
                        <input type="number" class="form-control form-control-sm" id="creditos" name="creditos"
                            value="{{ old('creditos') }}" required placeholder="Número de Créditos">
                    </div>

                    <div class="form-group col-lg-12">
                        <button type="submit" class="btn btn-primary" style="border-color:#2ecc71 !important;">Guardar
                            Taller</button>
                    </div>
                </form>
                
                <div class="col-lg-8 col-md-8">
                    <div class="table-wrapper">
                        <table id="tableCertificados" class="display table table-bordered table-hover table-condensed">
                           
                        </table>
                    </div>
                </div>
                <style>
                    #tablePrograma {
                        max-width: 100%;
                        /* Asegura que la tabla ocupe todo el ancho del contenedor */
                    }
                </style>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/dataTables.config.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/js/certificados/index.js') }}"></script>
@endsection
