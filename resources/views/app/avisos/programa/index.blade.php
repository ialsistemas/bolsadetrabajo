@extends('app.index')

@section('styles')
<link rel="stylesheet" href="{{ asset('app/css/avisos/index.css') }}">
    <link rel="stylesheet" href="{{ asset('app/css/perfil/style.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('app/css/avisos/indexV2.css') }}">
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
                        <h3>Mi programa: <b>{{ $nombrePrograma }}</b></h3>
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
                                <a href="{{ route('alumno.perfil') }}" class="btn-perfil-estudiante">
                                    Mejora tu perfil profesional
                                </a>
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
                    <div class="filter trainings">
                        <div class="form-group">
                            <select id="selectPrograma" class="form-input selct-template">
                                <option value="">MIS PROGRAMAS</option>
                                <option value="{{ route('alumno.capacitaciones', 'despega-360') }}">DESPEGA 360</option>
                                <option value="{{ route('alumno.capacitaciones', 'carrera-pro') }}">CARRERA PRO</option>
                                <option value="{{ route('alumno.capacitaciones', 'skills-to-work') }}">SKILLS TO WORK</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card card-programas">
                        <div class="row">
                            <div class="col-12">
                                <table id="mytable" class="display responsive nowrap table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Fecha de Registro</th>
                                            <th>Programa</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $indice = 1; @endphp
                                        @foreach ($participanteData as $participante)
                                            <tr>
                                                <td>{{ $indice++ }}</td>
                                                <td>{{ $participante->created_at }}</td>
                                                <td>{{ $nombrePrograma }}</td>
                                                <td>
                                                    <a href="{{ route('alumno.certificado', ['id' => urlencode($participante->id_encriptado)]) }}"
                                                        class="btn btn-secondary text-white"
                                                        target="_blank"
                                                        style="text-decoration: none;">
                                                        Ver certificado
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12">
                                @if ($nombrePrograma == "SKILLS TO WORK")
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            @if ($studentApplicationData != null && $studentApplicationData->video_presentation)
                                                <video class="responsive-video" controls>
                                                    <source src="{{ asset('app/students/'.$alumno->id.'/'.$studentApplicationData->video_presentation) }}" type="video/mp4">
                                                    Tu navegador no soporta la etiqueta de video.
                                                </video>
                                            @else
                                                <img src="{{ asset('app/img/falta-video.png') }}" alt="falta-video">
                                            @endif
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <form action="{{ route('alumno.uploadProgramRequirement') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" value="{{ $alumno->id }}" name="idAlumno">
                                                <div id="overlay">
                                                    <div>Cargando...</div>
                                                </div>
                                                <div class="form-group p-5 uploaded">
                                                    <label for="video">Subir Video:</label>
                                                    <input type="file" class="form-control" id="file" name="video" accept="video/*" style="line-height: -1.5;">
                                                    <small id="pesoArchivo" class="text-secondary">El video debe durar máximo 3 minutos y pesar menos de 35 MB.</small>
                                                    <div id="mensajeExito" class="text-success mt-2" style="display: none;">¡Video subido correctamente!</div>
                                                    @if ($errors->any())
                                                        <div class="alert alert-danger mt-2">
                                                            <ul class="mb-0">
                                                                @foreach ($errors->all() as $error)
                                                                    <li>{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                    <div class="p-2 text-center">
                                                        <button type="submit" id="submitBtn" class="btn btn-primary">Subir</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            @if ($studentApplicationData != null && $studentApplicationData->cv_pdf)
                                            <div class="text-center">
                                                <iframe src="{{ asset('app/students/'.$alumno->id.'/'.$studentApplicationData->cv_pdf) }}" class="cv-frame">
                                                </iframe>
                                            </div>
                                            @else
                                                <img src="{{ asset('app/img/falta-pdf.png') }}" alt="falta-pdf">
                                            @endif
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <form action="{{ route('alumno.uploadProgramRequirement') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div id="overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%;
                                                    background-color: rgba(0, 0, 0, 0.7); z-index: 9999; 
                                                    display: flex; justify-content: center; align-items: center; 
                                                    color: white; font-size: 2rem; display: none;">
                                                    <div>Cargando...</div>
                                                </div>
                                                <input type="hidden" value="{{ $alumno->id }}" name="idAlumno">
                                                <div class="form-group p-5 uploaded">
                                                    <label for="video">Subir CV:</label>
                                                    <input type="file" class="form-control" id="file" name="pdf" accept="application/pdf" style="line-height: -1.5;">
                                                    <small id="pesoArchivo" class="text-secondary">El Pdf debe pesar menos de 35 MB.</small>
                                                    <div id="mensajeExito" class="text-success mt-2" style="display: none;">PDF subido correctamente!</div>
                                                    @if ($errors->any())
                                                        <div class="alert alert-danger mt-2">
                                                            <ul class="mb-0">
                                                                @foreach ($errors->all() as $error)
                                                                    <li>{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                    <div class="p-2 text-center">
                                                        <button type="submit" id="submitBtn" class="btn btn-primary">Subir</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 text-center">
                    <a href="https://wa.me/922611913?text=Hola, Vengo de la Bolsa de trabajo y quiero conocer más sobre los programas de empleabilidad. Información por favor 😊"
                        target="_blank">
                        <img src="{{ asset('app/img/banner2_janet.png') }}" alt="">
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
    <script>
        $(document).ready(function () {
            $('#selectPrograma').on('change', function () {
                var url = $(this).val();
                if (url) {
                    window.location.href = url;
                }
            });
        });
    </script>
    <script src="{{ asset('app/js/perfil/app.js') }}"></script>
    {{-- CAMBIO MOMENTANEO --}}
    <script type="text/javascript" src="{{ asset('app/js/alumno/index.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    @if ($nombrePrograma == "SKILLS TO WORK")
        <script src="{{ asset('app/js/perfil/domVideo.js') }}"></script>
    @else
        <script src="{{ asset('app/js/perfil/domPdf.js') }}"></script>
    @endif
@endsection
