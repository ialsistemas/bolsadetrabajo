@extends('auth.index')

@section('titulo')
    <title>BolsaTrabajo | Habilidades</title>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('auth/plugins/datatable/datatables.min.css') }}">
@endsection

@section('contenido')
    <div class="content-wrapper">

        <section class="content-header">
            <h1>
                Listado Habilidades Profesional
                <small>Mantenimiento</small>
            </h1>

            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <button type="button" id="modalRegistrarHabilidad" class="btn-primary"><i class="fa fa-plus"></i> Registrar Habilidad Profesional</button>
                </li>
            </ol>
        </section>

        <section class="content">
            @csrf
            <input type="hidden" id="tipo_mant" name="tipo_mant" value="2">
            <div class="row">
                <div class="col-md-12">
                    <table id="tableHabilidad" class="table table-bordered table-striped display nowrap margin-top-10 dataTable no-footer"></table>
                </div>
            </div>
        </section>

    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/dataTables.config.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/js/habilidad/index.min.js') }}"></script>
@endsection
