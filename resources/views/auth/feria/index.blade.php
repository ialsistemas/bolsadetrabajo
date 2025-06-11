@extends('auth.index')

@section('titulo')
    <title>BolsaTrabajo | Ferias</title>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('auth/plugins/datatable/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('auth/css/feria/style.css') }}">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
@endsection

@section('contenido')
    <div class="content-wrapper">
        <section class="content-header d-flex justify-content-between align-items-center">          
            <h2>
                Listado Ferias
            </h2>           
            <div>
                <a href="javascript:void(0)" class="btn-m btn-secondary-m" onclick="window.location.reload();">
                    <i class="fa fa-refresh"></i> Refrescar | Listado de Ferias
                </a>
            </div>
        </section>
        @if(session('success'))
            <div id="alert-success" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div id="alert-error" class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <br>
        <hr>
        <div class="content-header bg-search" style="">
            <p for="actividad_eco_filter_id" class="m-0 label-primary text-dark-green">Filtro
                por Rango de Fecha de Inicio de la Feria</p>
            <div class="row">
                @php
                    $oneMonthAgo = date('Y-m-d', strtotime('-1 month'));
                    $oneMonthEnd = date('Y-m-d', strtotime('+1 month'));
                @endphp
                <div class="col-lg-4 col-12">
                    <div class="form-group">
                        <label for="startDate">Fecha de Inicio:</label>
                        <input type="date" class="form-control" id="startDate" name="startDate"  min="{{ $oneMonthAgo }}" value="{{ $oneMonthAgo }}">
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="form-group">
                        <label for="endDate">Fecha de Final:</label>
                        <input type="date" class="form-control" id="endDate" name="endDate"  min="{{ $oneMonthAgo }}" value="{{ $oneMonthEnd }}">
                    </div>
                </div>
                <div class="col-lg-4 col-12 d-flex justify-content-center align-items-center">
                    <button type="button" class="btn-m btn-primary-m btn-serach" id="btnSearch">
                        <i class="fa fa-search"></i> Buscar
                    </button>
                </div>
            </div>
        </div>
        <hr>
        <section class="content-header">
            <div class="row">
                <div class="col-12">
                    <button class="btn btn-info mb-10" id="btn-open-feria-modal">Agregar Feria</button>
                </div>
                <div class="col-12">
                    <table id="tableFeria" width="100%" class='table dataTables_wrapper container-fluid dt-bootstrap4 no-foote'>
                        <thead>
                            <th>Nombre de la Feria</th>
                            <th>Fecha Inicio de la Feria</th>
                            <th>Fecha Final de la Feria</th>
                            <th>Url</th>
                            <th>Acciones</th>
                        </thead>
                        <tbody id="tablaFerias">
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
    <div class="modal fade" id="modalAgregarFeria" tabindex="-1" role="dialog" aria-labelledby="modalAgregarFeriaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="modal-feria-content">
                <div class="text-center p-5">Cargando formulario...</div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalEditarFeria" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="contenidoModalEditarFeria">
            </div>
        </div>
    </div>        
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/dataTables.config.min.js') }}"></script>
    <script>
        const url = "{{ route('auth.ferias.filtrar') }}";
        const baseUrlEdit = "{{ route('auth.ferias.edit', ['id' => ':id']) }}";
        const baseUrlDelete = "{{ route('auth.ferias.delete', ['id' => ':id']) }}";
        const baseUrlListEmpresaRegistrado = "{{ route('auth.feria.listada-empresa', ['id' => ':id']) }}";
        const urlAgregar = "{{ route('auth.agregar-feria') }}";
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="{{ asset('auth/js/feria/index.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/js/feria/add.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/js/feria/edit.js') }}"></script>
    @if(session('success'))
        <script type="text/javascript" src="{{ asset('auth/js/feria/success.js') }}"></script>
    @endif
@endsection
