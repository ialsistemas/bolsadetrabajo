@extends('app.index')

@section('styles')
    <link rel="stylesheet" href="{{ asset('app/css/avisos/index.css') }}">
    <link rel="stylesheet" href="{{ asset('app/css/perfil/style.css') }}">
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
            <div class="row">
                <div class="col-md-3 filter-cont">
                    <div class="filter">
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
                    <div class="card experiencia">
                        <h5 class="title">{{ $experienciaData != null ? "Modificar" : "Registrar" }} Experiencia</h5>
                        <form action="{{ route('alumno.perfil.experiencia_store') }}" class="form-group row" method="POST">
                            @csrf
                            <input type="hidden" id="id" name="id" value="{{ $experienciaData != null ? $experienciaData->id : 0 }}">
                            <div class="col-md-12 mt-2">
                                <input type="text" name="empresa" id="empresa" value="{{ $experienciaData != null ? $experienciaData->empresa : "" }}" class="form-control" placeholder="Empresa / Negocio / Atención particular" required>
                                <span data-valmsg-for="empresa"></span>
                            </div>
                            <div class="col-md-6 mt-2">
                                <input type="text" name="puesto" id="puesto" value="{{ $experienciaData != null ? $experienciaData->puesto : "" }}" class="form-control" placeholder="Puesto" required>
                                <span data-valmsg-for="puesto"></span>
                            </div>
                            <div class="col-md-6 mt-2">
                                <select name="sector" class="form-control" id="sector" required>
                                    <option value="{{ $experienciaData != null ? $experienciaData->sector : "" }}" selected hidden>{{ $experienciaData != null ? $experienciaData->sector : "-- Tipo de Sector --" }}</option>
                                    <option value="Agricultura; plantaciones, otros sectores rurales ">Agricultura; plantaciones, otros sectores rurales </option>
                                    <option value="Alimentación; bebidas; tabaco">Alimentación; bebidas; tabaco</option>
                                    <option value="Comercio">Comercio</option>
                                    <option value="Construcción">Construcción</option>
                                    <option value="Educación">Educación</option>
                                    <option value="Fabricación de material de transporte">Fabricación de material de transporte</option>
                                    <option value="Función pública">Función pública</option>
                                    <option value="Hotelería, restauración, turismo">Hotelería, restauración, turismo</option>
                                    <option value="Industrias químicas">Industrias químicas</option>
                                    <option value="Ingenieria mecánica y eléctria">Ingenieria mecánica y eléctria</option>
                                    <option value="Medios de comunicación; cultura; gráficos">Medios de comunicación; cultura; gráficos</option>
                                    <option value="Minería (carbón, otra minería)">Minería (carbón, otra minería)</option>
                                    <option value="Petroleo y producción de gas; refinación de petroleo">Petroleo y producción de gas; refinación de petroleo</option>
                                    <option value="Producción de metales básicos">Producción de metales básicos</option>
                                    <option value="Servicios de correos y de telecomunicaciones"> Servicios de correos y de telecomunicaciones</option>
                                    <option value="Servicios de salud">Servicios de salud</option>
                                    <option value="Servicios financieros; servicios profesionales">Servicios financieros; servicios profesionales</option>
                                    <option value="Servicios públicos (agua; gas; electricidad)">Servicios públicos (agua; gas; electricidad)</option>
                                    <option value="Silvicultura; madera; celulosa; papel">Silvicultura; madera; celulosa; papel</option>
                                    <option value="Textiles; vestido; cuero; calzado">Textiles; vestido; cuero; calzado</option>
                                    <option value="Transporte (inluyendo aviación civil; ferrocarriles; transporte por carretera)">Transporte (inluyendo aviación civil; ferrocarriles; transportepor carretera)</option>
                                    <option value="Transporte marítimo; puertos; pesca; transporte interior">Transporte marítimo; puertos; pesca; transporte interior</option>
                                </select>
                            </div> 
                            <div class="col-md-6 mt-2">
                                <select name="estado" class="form-control" id="estado" required>
                                    <option value="{{ $experienciaData != null ? $experienciaData->estado : "" }}" selected hidden>{{ $experienciaData != null ? $experienciaData->estado : "Estado" }}</option>
                                    <option value="Hasta la actualidad">Hasta la actualidad</option>
                                    <option value="Culminado">Culminado</option>
                                </select>
                            </div>
                            <div class="col-md-6 mt-2">
                                <input type="text" id="inicio_laburo" name="inicio_laburo" class="form-control" value="{{ $experienciaData != null ? $experienciaData->inicio_laburo : "" }}" placeholder="Inicio del Laburo" onfocus="(this.type = 'month')" onblur="(this.type='text')" >                          
                            </div>
                            <div class="col-md-6 mt-2">
                                <input type="text" id="fin_laburo" name="fin_laburo" class="form-control" value="{{ $experienciaData != null ? $experienciaData->fin_laburo : "" }}" placeholder="Fin del Laburo" onfocus="(this.type = 'month')" onblur="(this.type='text')" >
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="">FUNCIONES DESEMPEÑADAS</label>
                                <textarea style="" name="descrip" id="habilidades_conoci" cols="3" rows="3"
                                    class="form-input" placeholder="Redacte que conocimientos posee sobre su carrera">{{ $experienciaData != null ? $experienciaData->descripcion : "" }}</textarea>
                                    <br>
                            </div>
                            <div class="col-md-12 mt-2 text-center">
                                <button type="submit" class="btn btn-bold btn-pure btn-primary">{{ $experienciaData != null ? "Modificar" : "Registrar" }} Experiencia</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-2 text-center">
                    <a href="https://wa.me/922611913?text=Hola, Vengo de la Bolsa de trabajo y quiero conocer más sobre los programas de empleabilidad. Información por favor 😊"
                        target="_blank">
                        <img src="{{ asset('app/img/banner2_janet.png') }}" alt="" style="width: 100%;">
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        var routeProgreso= "{{ route('alumno.progreso') }}";
        var tokenWeb = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('app/js/perfil/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app/plugins/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('app/js/perfil/generator-text-area.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app/plugins/datepicker/locales/bootstrap-datepicker.es.js') }}"></script>
    <script type="text/javascript" src="{{ asset('app/plugins/datepicker/bootstrap-datepicker.config.js') }}"></script>
    {{-- CAMBIO MOMENTANEO --}}
    <script type="text/javascript" src="{{ asset('app/js/alumno/index.js') }}"></script>
@endsection
