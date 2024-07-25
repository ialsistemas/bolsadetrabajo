@extends('auth.index')

@section('titulo')
    <title>BolsaTrabajo | Anuncios</title>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('auth/plugins/datatable/datatables.min.css') }}">
@endsection
<style type="text/css">
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
</style>

@section('contenido')
    <div class="content-wrapper">

        <section class="content-header">
            <h1>
                Publicar Anuncios paras las Empresas
                <small>Mantenimiento</small>
            </h1>
        </section>

        <br>
        <div class="content-header">
            <div class="row">
                <form class="col-lg-4 col-md-4" action="{{ route('auth.anuncioempresa.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group col-lg-12">
                        <label for="titulo" class="m-0 label-primary">Titulo del Anuncio</label>
                        <input autocomplete="off" type="text" class="form-control-m form-control-sm" id="titulo"
                            name="titulo" value="{{ old('titulo') }}">
                        @error('titulo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="enlace" class="m-0 label-primary">Enlace del Anuncio <b>*Opcional</b></label>
                        <input autocomplete="off" type="text" class="form-control-m form-control-sm" id="enlace"
                            name="enlace">
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="fecha_desde" class="m-0 label-primary">Mostrar desde</label>
                        <input type="date" class="form-control-m form-control-sm" min="<?php echo date('Y-m-d'); ?>"
                            id="fecha_desde" name="fecha_desde" value="<?php echo date('Y-m-d'); ?>">
                        @error('fecha_desde')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="fecha_vigencia" class="m-0 label-primary">Fecha de Vigencia</label>
                        <input type="date" class="form-control-m form-control-sm" min="<?php echo date('Y-m-d'); ?>"
                            id="fecha_vigencia" name="vigencia" value="{{ old('vigencia') }}">
                        @error('vigencia')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="banner_anuncio" class="m-0 label-primary">Banner del Anuncio</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input form-control-sm" id="banner_anuncio" name="banner"
                                onchange="validateFile(this)">
                            <label class="custom-file-label" for="banner_anuncio" id="banner_label">Seleccionar archivo...</label>
                        </div>
                        <small id="fileHelp" class="form-text text-muted">Selecciona un archivo JPG o PNG. (Se recomienda 1200x1200px)</small>
                        @error('banner')
                            <div class="alert alert-danger mt-2">
                                <i class="fa fa-exclamation-circle"></i> <!-- Add Icono de advertencia -->
                                <span class="ml-1">{{ $message }}</span>
                            </div>
                        @enderror
                        <span id="fileError" class="text-danger"></span> <!-- Add Aquí se mostrará el mensaje de error -->
                    </div>
                    {{-- Codigo Sebastian --}}
                    <script>
                        function validateFile(input) {
                            var fileName = input.files[0].name;
                            var label = document.getElementById('banner_label');
                            var fileError = document.getElementById('fileError');
                            var validExtensions = ['jpg', 'jpeg', 'png']; // Extensiones válidas
                    
                            // Obtener la extensión del archivo seleccionado
                            var fileExtension = fileName.split('.').pop().toLowerCase();
                    
                            // Verificar si la extensión es válida
                            if (validExtensions.indexOf(fileExtension) == -1) {
                                label.innerText = 'Seleccionar archivo...';
                                fileError.innerHTML = '<i class="fa fa-exclamation-circle"></i> Error: Seleccione un archivo JPG o PNG válido.';
                                input.value = ''; // Limpiar el valor del input file
                            } else {
                                label.innerText = fileName;
                                fileError.innerText = '';
                            }
                        }
                    </script>
                    {{-- Fin Codigo --}}

                    
                    

                    {{-- <div class="form-group col-lg-12">
                        <label for="banner_anuncio" class="m-0 label-primary">Banner del Anuncio</label>
                        <input type="file" class="form-control-m form-control-sm" id="banner_anuncio" name="banner"
                            value="{{ old('banner') }}">
                        @error('banner')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div> --}}
                    <div class="form-group col-lg-12">
                        <button type="submit" class="btn-m btn-primary-m">Subir Anuncio</button>
                    </div>
                </form>
                <div class="col-lg-8 col-md-8">
                    <table id="tableAnuncioEmpresa" width="100%"
                        class='display responsive no-wrap table table-bordered table-hover table-condensed'></table>
                </div>
            </div>
        </div>
        <!--  <section class="content">
                {{-- @csrf
            <div class="row">
                <div class="col-md-12">
                    <table id="tableAvisoPostulantes" width="100%" class='display responsive no-wrap table table-bordered table-hover table-condensed'></table>
                </div>
            </div> --}}
            </section> -->

    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/dataTables.config.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/js/anuncioempresa/index.js') }}"></script>
@endsection
