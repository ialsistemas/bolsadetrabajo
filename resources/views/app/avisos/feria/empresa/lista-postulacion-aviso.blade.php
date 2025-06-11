@extends('app.index')

@section('styles')
    <link rel="stylesheet" href="{{ asset('app/css/avisos/index.min.css') }}">
    <link rel="stylesheet" href="{{ asset('auth/plugins/datatable/datatables.min.css') }}">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('app/css/empresa/style.css') }}">
@endsection

@section('content')
    <div id="main">
        <div id="loading-avisos">
            <p>Cargando...</p>
        </div>
        <div class="head-section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3>Postulaciones al aviso <strong>{{ $avisoEmpresaData->name }}</strong> en la feria <strong>{{ $feriaData->name }}</strong></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-md-10 container-filter">
                    <div class="filter">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12 col-12">
                                    <h2 class="text-center mt-4">Lista de Postulaciones</h2>
                                </div>
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table id="tableAviso" class="table table-striped">
                                            <thead class="bg-loayza">
                                                <th>Nombre Completo del Alumno</th>
                                                <th>Correo Electronico</th>
                                                <th>Telefono</th>
                                                <th>Acciones</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($postulacionesData as $postulaciones)
                                                    <tr>
                                                        <td class="text-center align-middle">{{ $postulaciones->lastNameAlumno }} {{ $postulaciones->nameAlumno }}</td>
                                                        <td class="text-center align-middle">{{ $postulaciones->emailAlumno }}</td>
                                                        <td class="text-center align-middle">{{ $postulaciones->phoneAlumno }}</td>
                                                        <td class="text-center align-middle">
                                                            <a href="{{ route('empresa.postulante-feria-cv', $postulaciones->idAlumnoEncrypted) }}" class="btn btn-info" target="_blank">
                                                                <i class="icon-file-text"></i> Ver CV
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 text-center">
                    <a href="https://wa.me/948536701?text=Hola,vengo%20de%20la%20bolsa%20de%20trabajo%20y%20deseo%20conocer%20más%20de%20los%20servicios%20gratuitos%20para%20las%20empresas%20aliadas." target="_blank">
                        <img src="{{ asset('app/img/nuevaimagen2.png') }}" alt="Logo de WhatsApp">
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('app/js/empresas/feria.js') }}"></script>
@endsection
