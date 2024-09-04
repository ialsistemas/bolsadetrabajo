@extends('app.index')

@section('styles')
    <link rel="stylesheet" href="{{ asset('app/css/avisos/index.min.css') }}">
    <link rel="stylesheet" href="{{ asset('app/plugins/datepicker/datepicker3.css') }}">
    <style type="text/css">
        .hidden {
            display: none !important;
        }
    </style>
@endsection

@section('content')

    <style>
        .btn_ejemplo_perfil {
            color: #2092f0 !important;
            display: inline !important;
        }

        .colo_parentesis {
            color: #d61010e0 !important;
        }
    </style>
    <div id="main">

        <div id="loading-avisos">
            <p>Cargando...</p>
        </div>

        <div class="head-section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3>Mi Perfil</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid mt-3">
            <form enctype="multipart/form-data" id="actualizoPerfil" class="formulario"
                data-ajax-failure="OnFailureActualizoPerfil">
                <div class="row">
                    <div class="col-md-3 filter-cont">
                        <div class="filter" style="background-color: #f5f9fb !important;">
                            <div class="content-perfil">
                                <div class="imagen-perfil">
                                    <img src="{{ $alumno != null && $alumno->foto != null
                                        ? '/uploads/alumnos/fotos/' . $alumno->foto
                                        : '/uploads/default.png' }}"
                                        class="img-responsive" alt="Editar Foto">
                                    <input type="file" class="styled form-control" name="foto" id="foto"
                                        accept="image/jpeg, image/png" {{ $alumno != null ? '' : 'required' }}>
                                </div>
                                <h5>{{ $alumno->nombres . ' ' . $alumno->apellidos }}</h5>
                                <p>{{ $alumno->egresado == \BolsaTrabajo\App::$TIPO_ALUMNO ? 'Estudiante' : ($alumno->egresado == \BolsaTrabajo\App::$TIPO_TITULADO ? 'Titulado' : 'Egresado') }}
                                </p>
                                <p>{{ $alumno->areas->nombre }}</p>
                                <div class="hoja_de_vida_content">
                                    {{-- @if ($alumno->hoja_de_vida != null && $alumno->hoja_de_vida != '')
                                        <a href="/uploads/alumnos/archivos/{{ $alumno->hoja_de_vida }}" target="_blank">Cv{{ str_replace(' ', '', $alumno->nombres." ".$alumno->apellidos ) }}</a>
                                    @endif --}}
                                    <div class="hoja_de_vida" hidden>
                                        <p> <span class="bold">
                                                {{ $alumno->hoja_de_vida != null && $alumno->hoja_de_vida != '' ? 'Editar' : 'Adjuntar' }}
                                                mi CV </span><br> <span>(*.pdf, *.doc)</span></p>
                                        <input type="file" class="styled form-control" name="hoja_de_vida"
                                            id="hoja_de_vida" accept="application/pdf, application/msword, .doc, .docx"
                                            {{ $alumno != null ? '' : 'required' }}>
                                    </div>
                                    <a href="/uploads/modeloCV.docx" download hidden>
                                        Descargar plantilla para CV
                                    </a>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        @csrf
                        <div class="card aviso" style="background-color:#f5f9fb !important;">

                            @if ($errors != null && count($errors) > 0)
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <div class="alert alert-danger">
                                            <p>Para poder postular a una oferta laboral es indispensable actualizar los
                                                siguientes datos en tu perfil: </p>
                                            <ul>
                                                @foreach ($errors as $q)
                                                    <li style="font-size: 13px">{{ $q }}</li>
                                                @endforeach
                                            </ul>
                                            <p>Pulse el botón actualizar perfil para guardar toda su información personal,
                                                luego pulse el botón ver avisos para visualizar las ofertas laborales.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <style>
                                #main .formulario input,
                                #main .formulario select,
                                #main .formulario textarea {
                                    background: #ffffff;
                                    border-color: #dadada;
                                    font-family: Arial, Helvetica, sans-serif;
                                   /*  font-weight: 400; */
                                    box-shadow: -6px 5px 20px 0rem rgba(230, 230, 230, 0.397);
                                    border-radius: 10px;
                                }

                                .form-input:focus {
                                    border-color: #80bdff;
                                    outline: none;
                                    box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
                                }

                                /* Estilo cuando el elemento está enfocado (es decir, cuando está seleccionado) */
                                #main .formulario input:focus,
                                #main .formulario select:focus,
                                #main .formulario textarea:focus {
                                    border-color: #80bdff;
                                    outline: none;
                                    box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
                                }

                                /* Añadido para mejorar la experiencia al estar enfocado y también para el hover */
                                #main .formulario input:focus:hover,
                                #main .formulario select:focus:hover,
                                #main .formulario textarea:focus:hover {
                                    border-color: #66aaff;
                                    /* Color del borde al pasar el cursor cuando está enfocado */
                                    box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.35);
                                    /* Cambia la sombra cuando está enfocado y se pasa el cursor */
                                }
                            </style>
                            <div class="form-group row">
                                <div class="col-md-6 mt-3">
                                    <label for="dni" t>DNI/CE/PASAPORTE</label>
                                    <input type="text" class="form-input" name="dni" id="dni" minlength="8"
                                        maxlength="15" placeholder="DNI" onkeypress="return isNumberKey(event)"
                                        value="{{ $alumno->dni }}" required>
                                    <span data-valmsg-for="dni"></span>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                                    <input type="text" class="form-input" name="fecha_nacimiento" id="fecha_nacimiento"
                                        value="{{ \Carbon\Carbon::createFromFormat('Y-m-d', $alumno->fecha_nacimiento)->format('d/m/Y') }}"
                                        placeholder="Fecha de Nacimiento" autocomplete="off" required>
                                    <span data-valmsg-for="fecha_nacimiento"></span>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="provincia_id">Departamento</label>
                                    <select name="provincia_id" id="provincia_id" class="form-input" required>
                                        <option value="">Departamento</option>
                                        @foreach ($provincias as $q)
                                            <option value="{{ $q->id }}"
                                                {{ $alumno->provincia_id == $q->id ? 'selected' : '' }}>
                                                {{ $q->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <span data-valmsg-for="provincia_id"></span>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="distrito_id">Distrito</label>
                                    <select name="distrito_id" id="distrito_id" class="form-input" required>
                                        <option value="">Distrito</option>
                                        @if (count($distritos) > 0)
                                            @foreach ($distritos as $q)
                                                <option value="{{ $q->id }}"
                                                    {{ $alumno->distrito_id == $q->id ? 'selected' : '' }}>
                                                    {{ $q->nombre }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span data-valmsg-for="distrito_id"></span>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="telefono">Dirección</label>
                                    <input type="text" class="form-input" name="direccion" id="direccion"
                                        value="{{ $alumno->direccion }}" placeholder="Dirección" required>
                                    <span data-valmsg-for="telefono"></span>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="telefono">Teléfono</label>
                                    <input type="text" class="form-input" name="telefono" id="telefono" minlength="6"
                                        maxlength="15" value="{{ $alumno->telefono }}" placeholder="Teléfono" required>
                                    <span data-valmsg-for="telefono"></span>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="email">Correo electrónico</label>
                                    <input type="email" class="form-input" name="email" id="email"
                                        placeholder="Correo electrónico" value="{{ $alumno->email }}" required>
                                    <span data-valmsg-for="email"></span>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="egresado">Grado académico</label>
                                    <select name="egresado" id="egresado" class="form-input">
                                        <option value="0"
                                            {{ $alumno->egresado == \BolsaTrabajo\App::$TIPO_ALUMNO ? 'selected' : '' }}>
                                            Estudiante</option>
                                        <option value="1"
                                            {{ $alumno->egresado == \BolsaTrabajo\App::$TIPO_EGRESADO ? 'selected' : '' }}>
                                            Egresado</option>
                                        <option value="2"
                                            {{ $alumno->egresado == \BolsaTrabajo\App::$TIPO_TITULADO ? 'selected' : '' }}>
                                            Titulado</option>
                                    </select>
                                    <span data-valmsg-for="egresado"></span>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="area_id">Programa de estudios</label>
                                    <select name="area_id" id="area_id" class="form-input" required>
                                        <option value="">--Seleccione--</option>
                                        @foreach ($areas as $q)
                                            <option value="{{ $q->id }}"
                                                {{ $alumno->area_id == $q->id ? 'selected' : '' }}>{{ $q->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span data-valmsg-for="area_id"></span>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <label for="">Perfil Profesional</label> <a class="btn_ejemplo_perfil"
                                        href="{{ asset('app/img/perfil_word.pdf') }}" target="_blank">Ver Ejemplo</a>
                                    <input type="text" class="form-input" name="perfil_profesional"
                                        id="perfil_profesional" placeholder="Redacte su perfil Profesional"
                                        value="{{ strip_tags($alumno->perfil_profesional) }}" required>

                                </div>
                            </div>

                            <hr>
                            <div style="display: flex; justify-content:center; width:50%; margin:0 auto; ">
                                <h5 class="text-center text-uppercase titulo-adiciones">Experiencia Laboral</h5>
                                <a style="width:100px; margin-top:0px" class="btn_ejemplo_perfil"
                                    href="{{ asset('app/img/EXPERIENCIA_LABORAL2.pdf') }}" target="_blank">Ver
                                    Ejemplo</a>
                            </div>
                            <div id="experienciaLaboral" class="info-adiciones">
                                <div id="content_experienciaLaboral">
                                    @foreach ($experienciaLaboral as $q)
                                        <div class="info-content">
                                            <p><b>Puesto:</b> {{ $q->puesto }}</p>
                                            <p><b>Empresa:</b> {{ $q->empresa }}</p>
                                            <p><b>Sector:</b> {{ $q->sector }}</p>
                                            @if ($q->estado != null || $q->estado != '')
                                                <p><b>Estado:</b> {{ $q->estado }}</p>
                                            @endif
                                            <p><b>Inicio del Laburo:</b> {{ $q->inicio_laburo }}</p>
                                            @if ($q->fin_laburo != null || ($q->fin_laburo = ''))
                                                <p><b>Fin del Laburo:</b> {{ $q->fin_laburo }}</p>
                                            @endif
                                            <p><b>Funciones desempeñadas:</b> <br>
                                                @php
                                                    echo $q->descripcion;
                                                @endphp
                                            </p>
                                            <ul class="btns-content">
                                                <button type="button" class="btn btn-primary btn-xs" title="Editar"
                                                    data-info-id="{{ $q->id }}"><i
                                                        class="fa fa-pencil"></i></button>
                                                <button type="button" class="btn btn-danger btn-xs" title="Eliminar"
                                                    data-info-id="{{ $q->id }}"><i
                                                        class="fa fa-trash"></i></button>
                                            </ul>
                                        </div>
                                    @endforeach
                                </div>
                                <a href="javascript:void(0)" data-info="agregarExperienciaLaboral"><i class="fa fa-plus"></i> Agregar Experiencia</a>
                            </div>
                            <hr>
                            <hr>
                            <h5 class="text-center text-uppercase titulo-adiciones">Educación y Formación</h5>
                            <div id="educacion" class="info-adiciones">
                                <div id="content_educacion">
                                    @foreach ($educaciones as $q)
                                        <div class="info-content">
                                            <p><b>Institución:</b> {{ $q->institucion }}</p>
                                            <p><b>Programa de estudio:</b>
                                                {{ $q->areas != null ? $q->areas->nombre : '-' }}</p>
                                            <p><b>Estado:</b> {{ $q->estado }}</p>
                                            <p><b>Inicio de Estudio:</b> {{ $q->estudio_inicio }}</p>
                                            @switch($q->estado)
                                                @case($q->estado = 'Estudiante')
                                                    <p><b>Ciclo:</b> {{ $q->ciclo }}</p>
                                                    <p><b>Estado del Estudiante:</b> {{ $q->estado_estudiante }}</p>
                                                @break

                                                @case($q->estado = 'Egresado')
                                                    <p><b>Fin de estudio:</b> {{ $q->estudio_fin }}</p>
                                                @break

                                                @default
                                                    <p><b>Fin de estudio:</b> {{ $q->estudio_fin }}</p>
                                            @endswitch
                                            <ul class="btns-content">
                                                <button type="button" class="btn btn-primary btn-xs" title="Editar"
                                                    data-info-id="{{ $q->id }}"><i
                                                        class="fa fa-pencil"></i></button>
                                                <button type="button" class="btn btn-danger btn-xs" title="Eliminar"
                                                    data-info-id="{{ $q->id }}"><i
                                                        class="fa fa-trash"></i></button>
                                            </ul>
                                        </div>
                                    @endforeach
                                </div>
                                <a href="javascript:void(0)" data-info="agregarEducacion"><i class="fa fa-plus"></i> Agregar Educación</a>
                            </div>
                            <hr>
                            <hr>
                            {{-- {{ $referenciaLaboral }} --}}
                            <div
                                style="display: flex; justify-content:center; width:50%; margin:0 auto; align-items:center">
                                <h5 class="text-center text-uppercase titulo-adiciones">Formación Complementaria o
                                    Información Adicional</h5>
                                <a style="width:100px; margin-top:0px" class="btn_ejemplo_perfil"
                                    href="{{ asset('app/img/FORMACIÓN_COMPLEMENTARIA.pdf') }}" target="_blank">Ver
                                    Ejemplo</a>
                            </div>

                            <div id="" class="info-adiciones">
                                <div id="content_referenciaLaboral">
                                    @foreach ($referenciaLaboral as $item)
                                        <div class="info-content">
                                            <p><b>Nombre del Curso:</b> {{ $item->name_curso }}</p>
                                            <p><b>Institución:</b> {{ $item->institucion }}</p>
                                            @if ($item->estado != null || $item->estado != '')
                                                <p><b>Estado:</b> {{ $item->estado }}</p>
                                            @endif
                                            <p><b>Inicio del Curso:</b> {{ $item->inicio_curso }}</p>
                                            @if ($item->fin_curso != null || ($item->fin_curso = ''))
                                                <p><b>Fin del Curso:</b> {{ $item->fin_curso }}</p>
                                            @endif
                                            <ul class="btns-content">
                                                <button type="button" class="btn btn-primary btn-xs" title="Editar"
                                                    data-info-id="{{ $item->id }}"><i
                                                        class="fa fa-pencil"></i></button>
                                                <button type="button" class="btn btn-danger btn-xs" title="Eliminar"
                                                    data-info-id="{{ $item->id }}"><i
                                                        class="fa fa-trash"></i></button>
                                            </ul>
                                        </div>
                                    @endforeach
                                </div>
                                <a href="javascript:void(0)" data-info="agregarReferenciaLaboral"><i class="fa fa-plus"></i> Agregar Formación</a>
                            </div>

                            {{-- <div class="form-group row">
                                    <div class="col md-12">
                                        <label for="">Cursos, Talleres o Conferencias académicas</label>
                                        <textarea name="curso_talleres" id="cursos_talleres" cols="3" rows="3" class="form-input" placeholder="Cursos, Talleres o Conferencias académicas">
                                            {{ $alumno->curso_talleres }}
                                        </textarea>
                                    </div>
                                </div> --}}
                            <hr>
                            <br>


                        </div>
                        <div class="form-group row">
                            <div class="col md-12 mt-2">
                                <label for="">Otras Habilidades</label>
                                <a style="width:100px; margin-top:0px" class="btn_ejemplo_perfil"
                                    href="{{ asset('app/img/HABILIDADES.pdf') }}" target="_blank">Ver Ejemplo</a>
                                <textarea style="" name="referentes_carrera" id="habilidades_conoci" cols="3" rows="3"
                                    class="form-input" placeholder="Redacte que conocimientos posee sobre su carrera">{{ $alumno->referentes_carrera }}</textarea>
                            </div>
                        </div>

                        <hr>

                        <h5 class="text-center text-uppercase titulo-adiciones" hidden>Disponibilidad</h5>
                        <div class="info-adiciones" hidden>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <select name="disponibilidad" id="disponibilidad" class="form-input">
                                        <option value="">--Seleccione--</option>
                                        <option value="1" {{ $alumno->disponibilidad == 1 ? 'selected' : '' }}>Tiempo
                                            completo</option>
                                        <option value="2" {{ $alumno->disponibilidad == 2 ? 'selected' : '' }}>Medio
                                            tiempo</option>
                                        <option value="3" {{ $alumno->disponibilidad == 3 ? 'selected' : '' }}>Solo
                                            Mañana</option>
                                        <option value="4" {{ $alumno->disponibilidad == 4 ? 'selected' : '' }}>Solo
                                            Tarde y noche</option>
                                        <option value="5" {{ $alumno->disponibilidad == 5 ? 'selected' : '' }}>Solo
                                            fines de semana</option>
                                    </select>
                                    <span data-valmsg-for="egresado"></span>
                                </div>
                            </div>
                        </div>
                        <style>
                            .card .btn_cv {
                                width: 60% !important;
                                text-transform: uppercase;
                                text-align: center;
                                padding: 12px 20px;
                                margin: 10px auto;
                                font-size: 17px;
                                font-weight: 400;
                                color: #fff !important;
                                border: 0;
                                outline: 0;
                                transition: 0.5s ease;
                                background-color: #2092f0;
                                text-decoration: none !important;
                            }

                            textarea {
                                resize: auto !important;
                            }
                        </style>
                        <div class="card aviso mt-2" style="background-color:#f5f9fb;">

                            {{-- @if ($alumno->hoja_de_vida != null && $alumno->hoja_de_vida != '')
                                    <a href="/uploads/alumnos/archivos/{{ $alumno->hoja_de_vida }}" class="btn_cv" target="_blank"> Descargar mi CV </a>
                                @endif --}}
                            <button type="submit"><i class="fa fa-save"></i> Guardar</button>
                            <a href="pdf" class="btn_cv" target="_blank"> <i class="fa fa-download"></i> Descargar
                                mi CV </a>

                            <a href="{{ route('index') }}" class="text-uppercase">Ver Avisos</a>
                        </div>
                    </div>

                    <div class="col-md-2 text-center">
                        <a href="https://wa.me/922611913?text=Hola, Vengo de la Bolsa de trabajo y quiero conocer más sobre los programas de empleabilidad. Información por favor 😊"
                            target="_blank">
                            <img src="{{ asset('app/img/banner2_janet.png') }}" alt="">
                        </a>
                    </div>
                </div>
            </form>

        </div>
    </div>

@endsection

@section('scripts')

    {{-- Se Comento --}}
    {{--  <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script> --}}
    {{-- <script type="text/javascript" src="{{ asset('app/plugins/ckeditor/ckeditor.js') }}"></script> --}}
    {{-- <script>
        CKEDITOR.replace( 'habilidades_conoci' );
    </script> --}}
    {{-- Se agrego nuevo text area con plugins - Sebastián --}}
    <script type="text/javascript" src="{{ asset('app/plugins/tinymce/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: '#habilidades_conoci',
            width: "100%",
            height: 400,
            statusbar: false, // Corregir "statubar" a "statusbar" para bloquear moverse
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste textcolor"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons"
        });
    </script>
    {{-- Fin --}}
    <script type="text/javascript" src="{{ asset('app/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app/plugins/datepicker/locales/bootstrap-datepicker.es.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app/plugins/datepicker/bootstrap-datepicker.config.js') }}"></script>
    {{-- CAMBIO MOMENTANEO --}}
    <script type="text/javascript" src="{{ asset('app/js/alumno/index.js') }}"></script>
@endsection
