@extends('auth.index')

@section('titulo')
    <title>BolsaTrabajo | Eventos Asistencia</title>
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
                Eventos Asistencia
            </h1>
        </section>

        <br>
        <div class="content-header">
            <div class="row align-items-center">
                <!-- Contenedor para los mensajes -->
                <div class="col-lg-12">
                    <!-- Mensaje de éxito -->
                    @if (session('success'))
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="fa fa-check-circle me-2"></i> <!-- Icono de éxito -->
                            <div>
                                <ul class="mb-0">
                                    {{ session('success') }}
                                </ul>
                            </div>
                        </div>
                    @endif
                    <!-- Mensaje de error -->
                    @if ($errors->any())
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="fa fa-exclamation-triangle me-2"></i> <!-- Icono de error -->
                            <div>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="form-row">
                <form class="col-lg-12 col-md-12" action="{{ route('auth.eventosasistencia.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="id_user" class="id_user" value="{{ $userId }}" required>
                    <div style="display: flex; flex-wrap: wrap;">
                        <div class="form-group col-lg-12">
                            <label for="estado" class="m-0 label-primary" style="font-size: 17px;">
                                <i class="fa fa-calendar"></i> Evento <b
                                    style="color:red; font-size:16px">(Obligatorio*)</b>
                            </label>
                            <select name="id_evento" id="id_evento" class="form-control form-control-lg" required>
                                {{-- <option value="">Seleccione</option> --}}
                                @foreach ($eventos as $evento)
                                    <option value="{{ $evento->id }}">
                                        {{ $evento->nombre }} | Fecha:
                                        {{ \Carbon\Carbon::parse($evento->fecha_registro)->format('d-m-Y') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="dni" class="m-0 label-primary" style="font-size: 17px;"><i
                                    class="fa fa-id-card"></i> DNI <b
                                    style="color:red; font-size:16px">(Obligatorio*)</b></label>
                            <div class="input-group">
                                <input autocomplete="off" type="text" class="form-control form-control-lg" id="dni"
                                    name="dni" placeholder="Ingresar DNI" minlength="1" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary btn-lg" id="buscardni" type="button"
                                        style="background-color: #0072bf; color: white; font-size:18px;">
                                        <i class="fa fa-search"></i> Buscar
                                    </button>
                                </div>
                            </div>
                            <div class="invalid-feedback" style="font-size: 16px;">
                                Por favor ingresa un DNI válido (entre 1 y 8 dígitos).
                            </div>
                        </div>
                        {{-- EL CURSOR DNI SIEMPRE ESTE ACTIVO --}}
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                document.getElementById("dni").focus();
                            });
                        </script>
                        
                        <div class="form-group col-lg-6">
                            <label for="nombre" class="m-0 label-primary" style="font-size: 17px;">
                                <i class="fa fa-user"></i> Nombres</label>
                            <input autocomplete="off" type="text" class="form-control form-control-lg" id="nombres"
                                name="nombres" placeholder="Nombres" readonly required>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="apellidos" class="m-0 label-primary" style="font-size: 17px;">
                                <i class="fa fa-user"></i> Apellidos</label>
                            <input autocomplete="off" type="text" class="form-control form-control-lg" id="apellidos"
                                name="apellidos" placeholder="Apellidos" readonly required>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="especialidad" class="m-0 label-primary" style="font-size: 17px;">
                                <i class="fa fa-book"></i> Programa de
                                Estudio</label>
                            <input autocomplete="off" type="text" class="form-control form-control-lg" id="especialidad"
                                name="especialidad" placeholder="Programa de estudio" readonly required>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="telefono" class="m-0 label-primary" style="font-size: 17px;">
                                <i class="fa fa-phone"></i> Teléfono</label>
                            <input autocomplete="off" type="tel" class="form-control form-control-lg" id="tel"
                                name="tel" placeholder="Teléfono">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="correo" class="m-0 label-primary" style="font-size: 17px;">
                                <i class="fa fa-envelope"></i> Correo
                                Electrónico</label>
                            <input autocomplete="off" type="email" class="form-control form-control-lg" id="email"
                                name="email" placeholder="Correo Electrónico">
                        </div>

                        {{-- <div class="form-group col-lg-6">
                            <label for="tipo" class="m-0 label-primary" style="font-size: 17px;"> <i
                                    class="fa fa-tags"></i> Tipo <b
                                    style="color:red; font-size:16px">(Obligatorio*)</b></label>
                            <select name="tipo" id="tipo" class="form-control form-control-lg" required>
                                <option value="">Seleccione</option>
                                <option value="Estudiante" {{ old('tipo') == 'Estudiante' ? 'selected' : '' }}>Estudiante
                                </option>
                                <option value="Egresado" {{ old('tipo') == 'Egresado' ? 'selected' : '' }}>Egresado
                                </option>
                                <option value="Titulado" {{ old('tipo') == 'Titulado' ? 'selected' : '' }}>Titulado
                                </option>
                            </select>
                        </div> --}}
                        <div class="form-group col-lg-6">
                            <label for="sede" class="m-0 label-primary" style="font-size: 17px;">
                                <i class="fa fa-envelope"></i> Sede</label>
                            <input autocomplete="off" type="text" class="form-control form-control-lg" id="sede"
                                name="sede" placeholder="Sede" readonly required>
                        </div>

                        {{-- <div class="form-group col-lg-6">
                            <label for="sede" class="m-0 label-primary" style="font-size: 17px;">
                                <i class="fa fa-map-marker"></i> Sede <b
                                    style="color:red; font-size:16px">(Obligatorio*)</b>
                            </label>
                            <select name="sede" id="sede" class="form-control form-control-lg" required>
                                <option value="">Seleccione</option>
                                <option value="AREQUIPA 09 - CERCADO DE LIMA"
                                    {{ old('sede') == 'AREQUIPA 09 - CERCADO DE LIMA' ? 'selected' : '' }}>AREQUIPA 09 -
                                    CERCADO DE LIMA</option>
                                <option value="AREQUIPA 14 - CERCADO DE LIMA"
                                    {{ old('sede') == 'AREQUIPA 14 - CERCADO DE LIMA' ? 'selected' : '' }}>AREQUIPA 14 -
                                    CERCADO DE LIMA</option>
                                <option value="ATE 01 (NICOLAS AYLLON 831)"
                                    {{ old('sede') == 'ATE 01 (NICOLAS AYLLON 831)' ? 'selected' : '' }}>ATE 01 (NICOLAS
                                    AYLLON 831)</option>
                                <option value="BELISARIO - SAN JUAN DE MIRAFLORES"
                                    {{ old('sede') == 'BELISARIO - SAN JUAN DE MIRAFLORES' ? 'selected' : '' }}>BELISARIO -
                                    SAN JUAN DE MIRAFLORES</option>
                                <option value="BILLINGHURST - SAN JUAN DE MIRAFLORES"
                                    {{ old('sede') == 'BILLINGHURST - SAN JUAN DE MIRAFLORES' ? 'selected' : '' }}>
                                    BILLINGHURST - SAN JUAN DE MIRAFLORES</option>
                                <option value="CHOTA - CERCADO DE LIMA"
                                    {{ old('sede') == 'CHOTA - CERCADO DE LIMA' ? 'selected' : '' }}>CHOTA - CERCADO DE
                                    LIMA</option>
                                <option value="CENTRAL - CERCADO DE LIMA"
                                    {{ old('sede') == 'CENTRAL - CERCADO DE LIMA' ? 'selected' : '' }}>CENTRAL - CERCADO DE
                                    LIMA</option>
                                <option value="CLÍNICA - CERCADO DE LIMA"
                                    {{ old('sede') == 'CLÍNICA - CERCADO DE LIMA' ? 'selected' : '' }}>CLÍNICA - CERCADO DE
                                    LIMA</option>
                                <option value="ELEKTRA - FUENTE PIEDRA"
                                    {{ old('sede') == 'ELEKTRA - FUENTE PIEDRA' ? 'selected' : '' }}>ELEKTRA - FUENTE
                                    PIEDRA</option>
                                <option value="HORACIO ZEVALLOS"
                                    {{ old('sede') == 'HORACIO ZEVALLOS' ? 'selected' : '' }}>HORACIO ZEVALLOS</option>
                                <option value="LOS CHINOS - SAN JUAN DE MIRAFLORES"
                                    {{ old('sede') == 'LOS CHINOS - SAN JUAN DE MIRAFLORES' ? 'selected' : '' }}>LOS CHINOS
                                    - SAN JUAN DE MIRAFLORES</option>
                                <option value="MENDIOLA - LOS OLIVOS"
                                    {{ old('sede') == 'MENDIOLA - LOS OLIVOS' ? 'selected' : '' }}>MENDIOLA - LOS OLIVOS
                                </option>
                                <option value="MIGUEL IGLESIAS - SAN JUAN DE MIRAFLORES"
                                    {{ old('sede') == 'MIGUEL IGLESIAS - SAN JUAN DE MIRAFLORES' ? 'selected' : '' }}>
                                    MIGUEL IGLESIAS - SAN JUAN DE MIRAFLORES</option>
                                <option value="PTE PIEDRA 2" {{ old('sede') == 'PTE PIEDRA 2' ? 'selected' : '' }}>PTE
                                    PIEDRA 2</option>
                                <option value="SJL 10 - SAN JUAN DE LURIGANCHO"
                                    {{ old('sede') == 'SJL 10 - SAN JUAN DE LURIGANCHO' ? 'selected' : '' }}>
                                    SJL 10 - SAN JUAN DE LURIGANCHO
                                </option>
                                <option value="SJL CDRA 22 - SAN JUAN DE LURIGANCHO"
                                    {{ old('sede') == 'SJL CDRA 22 - SAN JUAN DE LURIGANCHO' ? 'selected' : '' }}>
                                    SJL CDRA 22 - SAN JUAN DE LURIGANCHO
                                </option>
                                <option value="SJL 50 - SAN JUAN DE LURIGANCHO"
                                    {{ old('sede') == 'SJL 50 - SAN JUAN DE LURIGANCHO' ? 'selected' : '' }}>
                                    SJL 50 - SAN JUAN DE LURIGANCHO
                                </option>
                                <option value="SALAVERRY - LOS OLIVOS"
                                    {{ old('sede') == 'SALAVERRY - LOS OLIVOS' ? 'selected' : '' }}>
                                    SALAVERRY - LOS OLIVOS
                                </option>
                                <option value="SAN LÁZARO - INDEPENDENCIA"
                                    {{ old('sede') == 'SAN LÁZARO - INDEPENDENCIA' ? 'selected' : '' }}>
                                    SAN LÁZARO - INDEPENDENCIA
                                </option>
                                <option value="VILLA EL SALVADOR"
                                    {{ old('sede') == 'VILLA EL SALVADOR' ? 'selected' : '' }}>
                                    VILLA EL SALVADOR
                                </option>
                                <option value="VISTA ALEGRE" {{ old('sede') == 'VISTA ALEGRE' ? 'selected' : '' }}>
                                    VISTA ALEGRE
                                </option>
                            </select>

                            <script>
                                $(document).ready(function() {
                                    $('#sede').select2({
                                        placeholder: 'Seleccione', // Texto que aparece cuando no hay una opción seleccionada
                                        width: '100%' // Ajusta el ancho para que se adapte al contenedor
                                    });
                                });
                            </script>
                        </div> --}}
                    </div>

                    <div class="form-group col-lg-12 text-center">
                        <button type="submit" class="btn btn-primary btn-lg" style="font-size: 18px;">
                            <i class="fa fa-save"></i> Registrar Asistencia</button>
                    </div>
                </form>
            </div>


        </div>
        <hr>

    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/dataTables.config.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/js/eventos/index.js') }}"></script>
@endsection
