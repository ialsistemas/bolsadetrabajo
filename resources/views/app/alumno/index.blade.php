@extends('app.index')

@section('styles')
    <link rel="stylesheet" href="{{ asset('app/css/avisos/index.css') }}">
    <link rel="stylesheet" href="{{ asset('app/plugins/datepicker/datepicker3.css') }}">
    <link rel="stylesheet" href="{{ asset('app/css/perfil/style.css') }}">
    <link rel="stylesheet" href="{{ asset('app/css/perfil/style-v2.css') }}">
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
                        <div class="filter">
                            <div class="content-perfil">
                                <div class="imagen-perfil text-center">
                                    <label for="upload-trigger" style="cursor: pointer;">
                                        <img id="preview-img" 
                                            src="{{ $alumno != null && $alumno->foto != null 
                                                        ? '/uploads/alumnos/fotos/' . $alumno->foto 
                                                        : '/uploads/default.png' }}" 
                                            class="img-responsive" 
                                            alt="Editar Foto">
                                    </label>
                                    <input type="file" id="upload-trigger" accept="image/jpeg, image/png" style="display: none;">
                                    <input type="hidden" name="imagen_recortada_base64" id="imagen-recortada-base64">
                                </div>
                                <h5>{{ $alumno->nombres . ' ' . $alumno->apellidos }}</h5>
                                <p class="name-alumno">{{ $alumno->areas->nombre }}</p>
                                <p>{{ $alumno->egresado == \BolsaTrabajo\App::$TIPO_ALUMNO ? 'Estudiante' : ($alumno->egresado == \BolsaTrabajo\App::$TIPO_TITULADO ? 'Titulado' : 'Egresado') }}
                                </p>
                                <input type="hidden" id="alumnoId" name="alumnoId" value="{{ $alumno->id }}">
                                <div class="progress-container">
                                    <progress id="progress-bar" max="100" value="0"></progress>
                                    <div class="progress-text" id="progress-text">0%</div>
                                </div>
                                <div class="hoja_de_vida_content">
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
                                <a href="{{ route('alumno.postulaciones') }}" class="enlace-postulaciones">
                                    Ver todas mis postulaciones <i class="fa fa-angle-double-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        @csrf
                        <div class="card aviso">
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
                            <div class="form-group row">
                                @if ($modificationNotice != 0)
                                    <div class="col-md-12">
                                        <div class="alert alert-warning alert-blink" style="font-size: 18px;">
                                            <strong>¡Atención!</strong> El formato de su CV ha cambiado. Actualice sus experiencias para mantener una presentación adecuada.
                                        </div>
                                    </div>
                                @endif
                                @if ($modificationNoticePerfil != 0)
                                    <div class="col-md-12">
                                        <div class="alert alert-warning alert-blink" style="font-size: 18px;">
                                            <strong>¡Atención!</strong> El formato de su Perfil Profesional ha cambiado. Actualice su Perfil Profesional para mantener una presentación adecuada.
                                        </div>
                                    </div>
                                @endif
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
                                    <input type="text" class="form-input" name="telefono" id="telefono"
                                        minlength="6" maxlength="15" value="{{ $alumno->telefono }}"
                                        placeholder="Teléfono" required>
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
                                    <textarea style="" name="perfil_profesional" id="perfil_profesional" cols="3" rows="3" class="form-input" placeholder="Redacte su perfil Profesional">{{ $alumno->perfil_profesional }}</textarea>
                                </div>
                            </div>
                            <hr>
                            <div class="container-experiencia">
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
                                            <ul class="btns-content ul-container">
                                                <li>
                                                    <a class="btn btn-primary btn-xs btn-edit" href="{{ route('alumno.perfil.experiencia-laboral', $q->encrypted_id) }}" style="color: white !important;">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <button type="button" class="btn btn-danger btn-xs btn-delete" title="Eliminar"
                                                        data-info-id="{{ $q->id }}">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </li>
                                            </ul>
                                            
                                        </div>
                                    @endforeach
                                </div>
                                <a href="{{ route('alumno.perfil.new-experiencia-laboral') }}" data-info="agregarExperienciaLaboral"><i
                                        class="fa fa-plus"></i> Agregar Experiencia</a>
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
                                <a href="javascript:void(0)" data-info="agregarEducacion"><i class="fa fa-plus"></i>
                                    Agregar Educación</a>
                            </div>
                            <hr>
                            <hr>
                            <div class="container-fomacion">
                                <h5 class="text-center text-uppercase titulo-adiciones">Formación Complementaria o
                                    Información Adicional</h5>
                                <a class="btn_ejemplo_perfil"
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
                                <a href="javascript:void(0)" data-info="agregarReferenciaLaboral"><i
                                        class="fa fa-plus"></i> Agregar Formación</a>
                            </div>
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
                        <div class="card aviso mt-2">
                            <button type="submit"><i class="fa fa-save"></i> Guardar Datos</button>
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
    <div id="cropperModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <img id="cropper-image" src="" style="max-width: 100%;">
                </div>
                <div class="modal-footer">
                    <button type="button" id="cropImageBtn" class="btn btn-success">Usar imagen</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var routeProgreso= "{{ route('alumno.progreso') }}";
        var tokenWeb = "{{ csrf_token() }}";
        var urlSpanish = "{{ asset('app/js/perfil/lang/es_MX.js') }}";
    </script>
    <script src="{{ asset('app/js/perfil/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app/plugins/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('app/js/perfil/generator-text-area.js') }}"></script>
    {{-- Fin --}}
    <script type="text/javascript" src="{{ asset('app/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app/plugins/datepicker/locales/bootstrap-datepicker.es.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app/plugins/datepicker/bootstrap-datepicker.config.js') }}"></script>
    {{-- CAMBIO MOMENTANEO --}}
    <script type="text/javascript" src="{{ asset('app/js/alumno/index.js') }}"></script>
    {{-- CROOPPERJS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script src="{{ asset('app/js/perfil/validation.js') }}"></script>
    <script src="{{ asset('app/js/perfil/imageRecort.js') }}"></script>
@endsection
