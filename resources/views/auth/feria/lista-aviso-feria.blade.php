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
                Listado de Empresa
            </h2>           
        </section>
        <hr>
        <section class="content-header">
            <div class="row">
                <div class="col-12">
                    <table id="tableFeria" width="100%" class='table dataTables_wrapper container-fluid dt-bootstrap4 no-foote'>
                        <thead>
                            <th>Nombre de la Empresa</th>
                            <th>Razon social</th>
                            <th>Cantidad de Avisos</th>
                            <th>Acciones</th>
                        </thead>
                        <tbody>
                            @foreach ($avisoEmpresaFeriaData as $avisoEmpresaFeria)
                                <tr>
                                    <td>{{ $avisoEmpresaFeria->nameEmpresa }}</td>
                                    <td>{{ $avisoEmpresaFeria->razonEmpresa }}</td>
                                    <td>{{ $avisoEmpresaFeria->totalAvisos }}</td>
                                    <td>
                                        <a href="{{ route('auth.feria.listada-empresa-postulantes', $avisoEmpresaFeria->idsAvisos) }}" class="btn btn-success">Ver Postulantes</a>
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