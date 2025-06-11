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
        <section class="content-header">          
            <div class="row">
                <div class="col-lg-6 col-12">
                    <h2>
                        Listado de Postulantes
                    </h2>
                </div>
                <div class="col-lg-6 col-12">
                    <table class="table dataTables_wrapper container-fluid dt-bootstrap4 no-foote w-75">
                        <thead>
                            <th>Nombre de Aviso</th>
                            <th>Cantidad de Postulantes</th>
                        </thead>
                        <tbody>
                            @foreach ($grupoData as $grupo)
                                <tr>
                                    <td>{{ $grupo->nombreAviso }}</td>
                                    <td>{{ $grupo->totalPostulantes }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <hr>
        <section class="content-header">
            <div class="row">
                <div class="col-12">
                    <table id="tableFeria" width="100%" class='table dataTables_wrapper container-fluid dt-bootstrap4 no-foote'>
                        <thead>
                            <th>Aviso</th>
                            <th>Nombre Completo Postulante</th>
                            <th>Correo Electronico</th>
                            <th>Telefono</th>
                            <th>Acciones</th>
                        </thead>
                        <tbody>
                            @foreach ($postulantesData as $postulantes)
                                <tr>
                                    <td>{{ $postulantes->nameAviso }}</td>
                                    <td>{{ $postulantes->lastNameAlumno }} {{ $postulantes->nameAlumno }}</td>
                                    <td>{{ $postulantes->emailAlumno }}</td>
                                    <td>{{ $postulantes->phoneAlumno }}</td>
                                    <td>
                                        <a href="{{ route('auth.feria.ver-cv-empresa-postulante', $postulantes->idAlumno) }}" class="btn btn-info" target="_blank">Ver CV</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/dataTables.config.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="{{ asset('auth/js/feria/index.js') }}"></script>
@endsection