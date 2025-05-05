<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curriculum Vitae</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            color: #333;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
        }
        .image-container {
            display: block;
            margin: 0 auto;
        }
        .image-container img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            display: block;
            margin: 0 auto;
        }
        .info-container {
            display: block;
            margin-top: 10px;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
            padding-bottom: 5px;
            border-bottom: 2px solid #333;
        }
        .info {
            font-size: 14px;
            margin: 5px 0;
        }
        .experience, .education, .courses, .skills {
            margin-top: 15px;
        }
        .experience-item, .education-item, .course-item {
            margin-bottom: 10px;
        }
        .experience-item p, .education-item p, .course-item p {
            margin: 2px 0;
            font-size: 14px;
        }
        .experience-item b, .education-item b, .course-item b {
            font-size: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <table width="100%">
            <tr>
                <!-- Imagen a la izquierda -->
                <td width="120" align="center">
                    @if($alumno->foto != null)
                        <img src="{{ "http://bolsadetrabajo.ial.edu.pe/uploads/alumnos/fotos/".$alumno->foto }}" 
                            width="120" height="120" 
                            style="border-radius: 50%; display: block;">
                    @endif
                </td>
                <td>
                    <h2 style="margin: 0;">{{ $alumno->apellidos }} {{ $alumno->nombres }}</h2>
                    <p style="margin: 5px 0;"><b>DNI:</b> {{ $alumno->dni }}</p>
                    @if ($distritoAlumno != "OTROS")
                        <p style="margin: 5px 0;"><b>Distrito:</b> {{ $distritoAlumno }}</p>
                    @endif
                    <p style="margin: 5px 0;"><b>Celular:</b> {{ $alumno->telefono }}</p>
                    <p style="margin: 5px 0;"><b>Email:</b> {{ $alumno->email }}</p>
                </td>
            </tr>
        </table>
        <div class="section-title">Perfil Profesional</div>
        <p class="info">{!! $alumno->perfil_profesional !!}</p>

        @if(count($experienciaLaboral) > 0)
        <div class="section-title">Experiencia Laboral</div>
        @foreach($experienciaLaboral as $q)
            <div class="experience-item">
                <b>{{ strtoupper($q->empresa) }}</b>
                <p>{{ $q->puesto }} ({{ date("m/Y", strtotime($q->inicio_laburo)) }} - {{ $q->fin_laburo ? date("m/Y", strtotime($q->fin_laburo)) : $q->estado }})</p>
                <p>{!! $q->descripcion !!}</p>
            </div>
        @endforeach
        @endif

        @if(count($educaciones) > 0)
        <div class="section-title">Educación y Formación</div>
        @foreach($educaciones as $q)
            <div class="education-item">
                <b>{{ $q->institucion }}</b>
                <p>{{ $q->areas ? $q->areas->nombre : "-" }} ({{ date("m/Y", strtotime($q->estudio_inicio)) }} - {{ $q->estudio_fin ? date("m/Y", strtotime($q->estudio_fin)) : 'En curso' }})</p>
                <p>{{ $q->estado == "Estudiante" ? "Estudiante del ciclo " . $q->ciclo : $q->estado }}</p>
            </div>
        @endforeach
        @endif

        @if(count($referenciaLaboral) > 0)
        <div class="section-title">Formación Complementaria</div>
        @foreach($referenciaLaboral as $q)
            <div class="course-item">
                <b>{{ $q->name_curso }}</b>
                <p>{{ $q->institucion }} ({{ date("m/Y", strtotime($q->inicio_curso)) }} - {{ $q->fin_curso ? date("m/Y", strtotime($q->fin_curso)) : $q->estado }})</p>
                <p>{!! $q->descripcion !!}</p>
            </div>
        @endforeach
        @endif

        @if(strlen($alumno->referentes_carrera) > 0)
        <div class="section-title">Otras Habilidades</div>
        <p class="info">{!! $alumno->referentes_carrera !!}</p>
        @endif
    </div>
</body>
</html>