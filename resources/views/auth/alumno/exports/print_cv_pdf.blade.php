<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CV Alumno</title>
</head>
<style type="text/css">
    /*body{padding-top: 15px;}*/
    .container-fluid{ width: 100%; display: block }
    .text-center{ text-align: center}
    .font-weight{ font-weight: bold }
    .text-uppercase{ text-transform: uppercase;}
    .mt-10{ margin-top: 10px;}
    .mt-20{ margin-top: 20px;}
    .row{
        display: block;
        margin-right: -15px;
        margin-left: -15px;
        webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .col{
        display: block;
        float: left;
        position: relative;
        min-height: 1px;
        webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    .col-md-5 {width: 41.66%;}
    .col-md-6 {width: 50%;}
    .col-md-7 {width: 58.33%;}
    .col-md-3 {width: 25%;}
    .col-md-4 {width: 33.33%;}
    .col-md-8 {width: 66.66%;}
    .col-md-9 {width: 75%;}
    .col-md-12 {width: 100%;}
    table{width: 100%}
    img{width: 100%;}
    .content-img-perfil{
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background-color: rgb(0, 32, 96);
        position: relative;
        border-radius: 50%;
        margin: 0 20px 0 auto;
    }
    .img-perfil{
        width: 100%;
        height: 100%;
        border-radius: 50%;
    }
    h5{
        border-bottom: 8px solid rgb(0, 32, 96);
        font-family: "Trebuchet MS";
        font-size: 16px;
        padding-bottom: 15px;
        margin-bottom: 0px;
    }
    ul{list-style: none; padding:0; margin: 0}
</style>

<body>

<div class="container-fluid">

        <div class="row" style="height: 70px;">
            @if($alumno->foto != null && $alumno->foto != "")
                <div class="col col-md-9" style="background-color: rgb(0, 32, 96); padding: 10px 0">
                    <h1 style="font-size:27px;text-transform: capitalize !important;color: #fff;padding-left: 15px">{{$alumno->apellidos.' '.$alumno->nombres}}</h1>
                </div>
                <div class="col col-md-3">
                    <div class="content-img-perfil">
                        <img src="http://bolsadetrabajo.ial.edu.pe/uploads/alumnos/fotos/{{ $alumno->foto }}" class="img-perfil" alt="">
                    </div>
                </div>
            @else
                <div class="col col-md-12" style="background-color: rgb(0, 32, 96); padding: 10px 0">
                    <h1 style="font-size:27px;text-transform: capitalize !important;color: #fff;padding-left: 15px">{{$alumno->apellidos.' '.$alumno->nombres}}</h1>
                </div>
            @endif
        </div>
    <div class="row mt-10" style="width: 100%; height: 30px;margin-top: 25px">
        <p>{{ strtoupper($alumno->egresado == \BolsaTrabajo\App::$TIPO_ALUMNO ? "Estudiante" : ($alumno->egresado == \BolsaTrabajo\App::$TIPO_TITULADO ? "Titulado" : "Egresado")) }} <br>
        {{ strtoupper($alumno->areas->nombre) }}</p>
    </div>

    <div class="row mt-10" style="width: 100%; height: 110px">
        <h5>Datos Personales</h5>
        <div class="row mt-20" style="padding: 0 15px">
            <div class="col col-md-12">
                <ul>
                    <li>{{ $alumno->dni != null ? $alumno->dni : "No presenta."}}</li>
                    <li>{{ $alumno->fecha_nacimiento != null ? $alumno->fecha_nacimiento : "No presenta." }}</li>
                    <li>{{ $alumno->provincias != null ? $alumno->provincias->nombre : "No presenta." }}</li>
                    <li>{{ $alumno->distritos != null ? $alumno->distritos->nombre : "No presenta." }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row mt-20">
        <h5>Datos de Contacto</h5>
        <div class="row mt-20" style="padding: 0 15px">
            <div class="col col-md-12">
                <ul>
                    <li>{{ $alumno->telefono != null ? $alumno->telefono : "No presenta."}}</li>
                    <li>{{ $alumno->email != null ? $alumno->email : "No presenta." }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row mt-20">
        <h5>Estudios</h5>
        <div class="row">
            @if($alumno->educaciones != null && Count($alumno->educaciones) > 0)
                @foreach($alumno->educaciones as $q)
                    <div class="col-md-12 mt-20" style="padding: 0 15px">
                        <ul>
                            <li>{{ $q->institucion }}</li>
                            <li>{{ $q->areas != null ? $q->areas->nombre : "-" }}</li>
                            <li>{{ $q->estado }}</li>
                        </ul>
                    </div>
                @endforeach
            @else
                <div class="mt-10 col-md-12" style="padding: 0 15px">
                    <p>No presenta.</p>
                </div>
            @endif
        </div>
    </div>
    <div class="row mt-20">
        <h5>Experiencia Laboral</h5>
        <div class="row">
            @if($alumno->experiencias != null && Count($alumno->experiencias) > 0)
                @foreach($alumno->experiencias as $q)
                    <div class="col-md-12 mt-20" style="padding: 0 15px">
                        <ul>
                            <li>{{ $q->empresa }}</li>
                            <li>{{ $q->puesto }}</li>
                            <li><?php echo $q->descripcion ?></li>
                        </ul>
                    </div>
                @endforeach
            @else
                <div class="mt-10 col-md-12" style="padding: 0 15px">
                    <p>No presenta.</p>
                </div>
            @endif
        </div>
    </div>
    <div class="row mt-20">
        <h5>Disponibilidad</h5>
        <div class="row mt-20" style="padding: 0 15px">
            <div class="col col-md-12">
                <ul>
                    @if( $alumno->disponibilidad != null)
                        @if($alumno->disponibilidad == 1)
                            <li>Tiempo completo</li>
                        @elseif($alumno->disponibilidad == 2)
                            <li>Medio tiempo</li>
                        @elseif($alumno->disponibilidad == 3)
                            <li>Solo Mañana</li>
                        @elseif($alumno->disponibilidad == 4)
                            <li>Solo Tarde y noche</li>
                        @else
                            <li>Solo fines de semana</li>
                        @endif
                    @else
                        <li>No presenta</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

</div>

<script src="https://kit.fontawesome.com/5c07af2b02.js" crossorigin="anonymous"></script>
</body>
</html>
