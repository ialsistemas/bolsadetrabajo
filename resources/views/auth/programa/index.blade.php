@extends('auth.index')

@section('titulo')
    <title>BolsaTrabajo | Programas de Inserción rápida</title>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('auth/plugins/datatable/datatables.min.css') }}">
@endsection
{{-- <style type="text/css">
    .txt_claro {
        background: #79f57f63;
        /* color: #fff; */
    }

    .label-as-badge {
        border-radius: 1em;
        font-size: 12px;
        cursor: pointer;
    }

    table.dataTable th,
    table.dataTable td {
        white-space: nowrap;
    }

    .sorting_1 {
        padding-left: 30px !important;
    }
</style> --}}

@section('contenido')
    <div class="content-wrapper">

        <section class="content-header">
            <h1>
                Publicar Programas de Inserción rápida
                <small>Mantenimiento</small>
            </h1>
        </section>

        <br>
        <div class="content-header">
            <div class="row">
                <form class="col-lg-4 col-md-4" action="{{ route('auth.programa.store') }}" method="post">

                    @csrf
                    <div class="form-group col-lg-12">
                        <label for="registro" class="m-0 label-primary">Fecha</label>
                        <input type="date" class="form-control form-control-sm" min="<?php echo date('Y-m-d'); ?>" id="registro"
                            name="registro" value="{{ old('registro') }}" required>
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="tipo_programa" class="m-0 label-primary">Programa <b
                                style="color:red;font-size:10px">(Obligatorio*)</b></label>
                        <select name="tipo_programa" id="tipo_programa" class="form-control form-control-sm" required>
                            <option value="">Seleccione</option>
                            <option value="Bolsa de Trabajo"
                                {{ old('tipo_programa') == 'Bolsa de Trabajo' ? 'selected' : '' }}>Bolsa de Trabajo</option>
                            <option value="Talent Day" {{ old('tipo_programa') == 'Talent Day' ? 'selected' : '' }}>Talent
                                Day</option>
                            <option value="Nexo Laboral" {{ old('tipo_programa') == 'Nexo Laboral' ? 'selected' : '' }}>Nexo
                                Laboral</option>
                            <option value="Contrata Talento"
                                {{ old('tipo_programa') == 'Contrata Talento' ? 'selected' : '' }}>Contrata Talento</option>
                        </select>

                    </div>
                    <div class="form-group col-lg-12">
                        <label for="empresa" class="m-0 label-primary">Empresa <b
                                style="color:red;font-size:10px">(Obligatorio*)</b></label>
                        <input autocomplete="off" type="text" class="form-control form-control-sm" id="empresa"
                            name="empresa" value="{{ old('empresa') }}" required placeholder="Nombre Empresa">
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="puestouno" class="m-0 label-primary">Puesto 1 <b
                                style="color:red;font-size:10px">(Obligatorio*)</b></label>
                        <input autocomplete="off" type="text" class="form-control form-control-sm" id="puestouno"
                            name="puestouno" value="{{ old('puestouno') }}" required placeholder="Ingresar puesto uno">
                    </div>
                    <div id="nuevosPuestos"></div>
                    <button type="button" class="btn btn-link" onclick="agregarPuesto()"
                        style="margin-bottom: 20px;margin-top: -20px;font-size:12px">
                        <i class="fa fa-plus-circle mr-1"></i>Agregar otro puesto (Máximo 4)
                    </button>
                    <div class="form-group col-lg-12">
                        <label for="responsable" class="m-0 label-primary">Responsable <b
                                style="color:red;font-size:10px">(Obligatorio*)</b></label>
                        <select name="responsable" id="responsable" class="form-control form-control-sm" required>
                            <option value="">Seleccione</option>
                            <option value="Bryan Julcamoro" {{ old('responsable') == 'Bryan Julcamoro' ? 'selected' : '' }}>
                                Bryan Julcamoro
                            </option>
                            <option value="Joselyn Condori"
                                {{ old('responsable') == 'Joselyn Condori' ? 'selected' : '' }}>Joselyn Condori
                            </option>
                            {{-- <option value="Setafani Carlos"
                                {{ old('responsable') == 'Setafani Carlos' ? 'selected' : '' }}>Setafani Carlos
                            </option> --}}
                            <option value="Stefany Gutierrez"
                                {{ old('responsable') == 'Stefany Gutierrez' ? 'selected' : '' }}>Stefany Gutierrez
                            </option>
                            {{-- <option value="Yessica Caceres"
                                {{ old('responsable') == 'Yessica Caceres' ? 'selected' : '' }}>Yessica Cáceres
                            </option> --}}
                            <option value="Yamile Bazan" {{ old('responsable') == 'Yamile Bazan' ? 'selected' : '' }}>
                                Yamilé Bazán</option>
                        </select>
                    </div>

                    <div class="form-group col-lg-12">
                        <label for="postulantes" class="m-0 label-primary">Cantidad Postulantes</label>
                        <input autocomplete="off" type="number" class="form-control form-control-sm" id="postulantes"
                            name="postulantes" value="{{ old('postulantes') }}" placeholder="Ingrese Cantidad">
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="evaluando" class="m-0 label-primary">Cantidad Evaluando</label>
                        <input autocomplete="off" type="number" class="form-control form-control-sm" id="evaluando"
                            name="evaluando" value="{{ old('evaluando') }}" placeholder="Ingrese Cantidad">
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="contratados" class="m-0 label-primary">Cantidad Contratado</label>
                        <input autocomplete="off" type="number" class="form-control form-control-sm" id="contratados"
                            name="contratados" value="{{ old('contratados') }}" placeholder="Ingrese Cantidad">
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="descartado" class="m-0 label-primary">Cantidad Descartado</label>
                        <input autocomplete="off" type="number" class="form-control form-control-sm" id="descartado"
                            name="descartado" value="{{ old('descartado') }}" placeholder="Ingrese Cantidad">
                    </div>




                   {{--  <div>
                        <h3 class="col-lg-12">Datos del <span style="color: #0072bf">Estudiante</span></h3>
                        <div style="display: flex; flex-wrap: wrap;">
                            <div class="form-group col-lg-6">
                                <label for="dni" class="m-0 label-primary">DNI <b
                                        style="color:red;font-size:10px">(Obligatorio*)</b></label>
                                <div class="input-group">
                                    <input autocomplete="off" type="text" class="form-control form-control-sm"
                                        id="dni" name="dni" placeholder="Ingresar DNI" minlength="1"
                                        maxlength="8" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" id="buscardni" type="button"
                                            style="background-color: #0072bf; color: white;">
                                            <i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                                <div class="invalid-feedback">
                                    Por favor ingresa un DNI válido (entre 1 y 8 dígitos).
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label for="nombre" class="m-0 label-primary">Nombres</label>
                                <input autocomplete="off" type="text" class="form-control form-control-sm"
                                    id="nombres" name="nombres" placeholder="Nombres" readonly required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="apellidos" class="m-0 label-primary">Apellidos</label>
                                <input autocomplete="off" type="text" class="form-control form-control-sm"
                                    id="apellidos" name="apellidos" placeholder="Apellidos" readonly required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="telefono" class="m-0 label-primary">Teléfono</label>
                                <input autocomplete="off" type="tel" class="form-control form-control-sm"
                                    id="tel" name="tel" placeholder="Teléfono">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="correo" class="m-0 label-primary">Correo Electrónico</label>
                                <input autocomplete="off" type="email" class="form-control form-control-sm"
                                    id="email" name="email" placeholder="Correo Electrónico">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="estado" class="m-0 label-primary">Estado <b
                                        style="color:red;font-size:10px">(Obligatorio*)</b></label>
                                <select name="estado" id="estado" class="form-control form-control-sm" required>
                                    <option value="">Seleccione</option>
                                    <option value="Postulante" {{ old('estado') == 'Postulante' ? 'selected' : '' }}>
                                        Postulante
                                    </option>
                                    <option value="Evaluando" {{ old('estado') == 'Evaluando' ? 'selected' : '' }}>
                                        Evaluando</option>
                                    <option value="Contratado" {{ old('estado') == 'Contratado' ? 'selected' : '' }}>
                                        Contratado
                                    </option>
                                    <option value="Descartado" {{ old('estado') == 'Descartado' ? 'selected' : '' }}>
                                        Descartado
                                    </option>


                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="tipo" class="m-0 label-primary">Tipo <b
                                        style="color:red;font-size:10px">(Obligatorio*)</b></label>
                                <select name="tipo" id="tipo" class="form-control form-control-sm" required>
                                    <option value="">Seleccione</option>
                                    <option value="Estudiante" {{ old('tipo') == 'Estudiante' ? 'selected' : '' }}>
                                        Estudiante
                                    </option>
                                    <option value="Egresado" {{ old('tipo') == 'Egresado' ? 'selected' : '' }}>
                                        Egresado
                                    </option>
                                    <option value="Titulado" {{ old('tipo') == 'Titulado' ? 'selected' : '' }}>
                                        Titulado
                                    </option>

                                </select>
                            </div>

                            <div class="form-group col-lg-6">
                                <label for="sede" class="m-0 label-primary">Sede <b
                                        style="color:red;font-size:10px">(Obligatorio*)</b></label>
                                <select name="sede" id="sede" class="form-control form-control-sm" required>
                                    <option value="">Seleccione</option>
                                    <option value="AREQUIPA 09 - CERCADO DE LIMA"
                                        {{ old('sede') == 'AREQUIPA 09 - CERCADO DE LIMA' ? 'selected' : '' }}>
                                        AREQUIPA 09 - CERCADO DE LIMA
                                    </option>
                                    <option value="AREQUIPA 14 - CERCADO DE LIMA"
                                        {{ old('sede') == 'AREQUIPA 14 - CERCADO DE LIMA' ? 'selected' : '' }}>
                                        AREQUIPA 14 - CERCADO DE LIMA
                                    </option>
                                    <option value="ATE 01 (NICOLAS AYLLON 831)"
                                        {{ old('sede') == 'ATE 01 (NICOLAS AYLLON 831)' ? 'selected' : '' }}>
                                        ATE 01 (NICOLAS AYLLON 831)
                                    </option>
                                    <option value="BELISARIO - SAN JUAN DE MIRAFLORES"
                                        {{ old('sede') == 'BELISARIO - SAN JUAN DE MIRAFLORES' ? 'selected' : '' }}>
                                        BELISARIO - SAN JUAN DE MIRAFLORES
                                    </option>
                                    <option value="BILLINGHURST - SAN JUAN DE MIRAFLORES"
                                        {{ old('sede') == 'BILLINGHURST - SAN JUAN DE MIRAFLORES' ? 'selected' : '' }}>
                                        BILLINGHURST - SAN JUAN DE MIRAFLORES
                                    </option>
                                    <option value="CHOTA - CERCADO DE LIMA"
                                        {{ old('sede') == 'CHOTA - CERCADO DE LIMA' ? 'selected' : '' }}>
                                        CHOTA - CERCADO DE LIMA
                                    </option>
                                    <option value="CENTRAL - CERCADO DE LIMA"
                                        {{ old('sede') == 'CENTRAL - CERCADO DE LIMA' ? 'selected' : '' }}>
                                        CENTRAL - CERCADO DE LIMA
                                    </option>
                                    <option value="CLÍNICA - CERCADO DE LIMA"
                                        {{ old('sede') == 'CLÍNICA - CERCADO DE LIMA' ? 'selected' : '' }}>
                                        CLÍNICA - CERCADO DE LIMA
                                    </option>
                                    <option value="ELEKTRA - FUENTE PIEDRA"
                                        {{ old('sede') == 'ELEKTRA - FUENTE PIEDRA' ? 'selected' : '' }}>
                                        ELEKTRA - FUENTE PIEDRA
                                    </option>
                                    <option value="HORACIO ZEVALLOS"
                                        {{ old('sede') == 'HORACIO ZEVALLOS' ? 'selected' : '' }}>
                                        HORACIO ZEVALLOS
                                    </option>
                                    <option value="LOS CHINOS - SAN JUAN DE MIRAFLORES"
                                        {{ old('sede') == 'LOS CHINOS - SAN JUAN DE MIRAFLORES' ? 'selected' : '' }}>
                                        LOS CHINOS - SAN JUAN DE MIRAFLORES
                                    </option>
                                    <option value="MENDIOLA - LOS OLIVOS"
                                        {{ old('sede') == 'MENDIOLA - LOS OLIVOS' ? 'selected' : '' }}>
                                        MENDIOLA - LOS OLIVOS
                                    </option>
                                    <option value="MIGUEL IGLESIAS - SAN JUAN DE MIRAFLORES"
                                        {{ old('sede') == 'MIGUEL IGLESIAS - SAN JUAN DE MIRAFLORES' ? 'selected' : '' }}>
                                        MIGUEL IGLESIAS - SAN JUAN DE MIRAFLORES
                                    </option>
                                    <option value="PTE PIEDRA 2" {{ old('sede') == 'PTE PIEDRA 2' ? 'selected' : '' }}>
                                        PTE PIEDRA 2
                                    </option>
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
                            </div>

                        </div>
                    </div> --}}
                    <div class="form-group col-lg-12">
                        
                        <button type="submit" class="btn btn-primary"
                            style="border-color:#2ecc71 !important;">Guardar Programa</button>
                    </div>
                </form>
                <div class="col-lg-8 col-md-8">
                    <div class="table-wrapper">
                        <table id="tablePrograma" class="display table table-bordered table-hover table-condensed">
                            <!-- Aquí se puede agregar un caption para la tabla si es necesario -->
                        </table>
                    </div>
                    <div class="form-group col-lg-3 col-md-12 d-flex flex-column">
                        <a href="javascript:void(0)" class="btn-m btn-success-m" onclick="clickExcelAlumno()">
                            <i class="fa fa-file"></i> Exportar excel
                        </a>
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

        <script>
            // Script para validar el campo DNI
            document.addEventListener('DOMContentLoaded', function() {
                var dniInput = document.getElementById('dni');

                dniInput.addEventListener('input', function() {
                    // Remover la clase de error si el valor es válido
                    if (dniInput.validity.valid) {
                        dniInput.classList.remove('is-invalid');
                    } else {
                        dniInput.classList.add('is-invalid');
                    }
                });
            });
        </script>

        {{-- Script para poder agregar nuevo puesto opcional --}}
        <script>
            var numPuestosAgregados = 0;
            var nombresPuestos = ['dos', 'tres', 'cuatro'];

            function agregarPuesto() {
                if (numPuestosAgregados < 3) {
                    numPuestosAgregados++;

                    var nuevosPuestosDiv = document.getElementById('nuevosPuestos');
                    var nuevoPuestoHTML = `
                <div class="form-group col-lg-12">
                    <label for="puesto${nombresPuestos[numPuestosAgregados - 1]}" class="m-0 label-primary">Puesto ${nombresPuestos[numPuestosAgregados - 1].charAt(0).toUpperCase() + nombresPuestos[numPuestosAgregados - 1].slice(1)} <b style="color:green;font-size:10px">(Opcional)</b></label>
                    <input autocomplete="off" type="text" class="form-control form-control-sm" id="puesto${nombresPuestos[numPuestosAgregados - 1]}" name="puesto${nombresPuestos[numPuestosAgregados - 1]}">
                </div>
            `;
                    nuevosPuestosDiv.insertAdjacentHTML('beforeend', nuevoPuestoHTML);

                    // Ocultar el botón después de agregar cuatro puestos
                    if (numPuestosAgregados === 3) {
                        var botonAgregar = document.querySelector('.btn-link');
                        botonAgregar.style.display = 'none';
                    }
                }
            }
        </script>
        {{-- Fin de Script --}}

        <section class="content">
            {{-- @csrf
            <div class="row">
                <div class="col-md-12">
                    <table id="tableAvisoPostulantes" width="100%" class='display responsive no-wrap table table-bordered table-hover table-condensed'></table>
                </div>
            </div> --}}
        </section>

    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/dataTables.config.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/js/programa/index.js') }}"></script>
@endsection
