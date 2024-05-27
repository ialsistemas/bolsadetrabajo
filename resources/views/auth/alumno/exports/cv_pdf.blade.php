<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Curriculum Vitae</title>
</head>
<style>
    body{
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    }
    .title_datos_personales{
        padding: 10px 0px;
        margin-bottom: 20px;
        border-bottom: 1px solid rgb(0, 0, 0);
        font-size: 20px;

    }
    .titulo_exp_laboral{
        padding: 10px 0px;
        margin-bottom: 10px;
        border-bottom: 1px solid rgb(0, 0, 0);
        font-size: 16px;
    }
    .titulo_educacion{
        padding: 10px 0px;
        margin-bottom: 10px;
        border-bottom: 1px solid rgb(0, 0, 0);
        font-size: 16px;
    }
    .titulo_cursos{
        margin-top: 0px;
        padding: 10px 0px;
        margin-bottom: 10px;
        border-bottom: 1px solid rgb(0, 0, 0);
        font-size: 16px;
    }
    .titulo_habilidades{
        margin-top: 0px;
        padding: 10px 0px;
        margin-bottom: 10px;
        border-bottom: 1px solid rgb(0, 0, 0);
        font-size: 16px;
    }
    .head_cv{
        display: flex;
        margin-bottom: 0px;
        padding-bottom: 0px;
    }
    .sect_datos_personales{
        margin-left: 0px;
        margin-bottom: 0px;
        width: 72%;
    }
    .img_perfil{
        width: 20%;
        height: 10px;
        margin-left: 530px;
        margin-bottom: 0px;
        padding-bottom: 0px;
    }
    .img_perfil img{
        width: 100%;
        margin-bottom: 0px;
        padding-bottom: 0px;
    }
    .border_bottom{
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 2px solid rgba(129, 129, 129, 0.363);
    }
    .caja_item_esperiencia{
        margin-left: 20px;
        /* display: flex; */
        margin-bottom: 0px; 
    }
    .tipo_letra{
        font-size: 14px !important;
    }
    .titulo_nombres{
        font-size: 24px !important;
    }
    .letra_perfil_profesional{
        font-size: 14px !important;
        margin-bottom: -2px;
        text-align: justify;
    }
    .punto_negro_experiencia{
        margin-right: 15px;
    }
    .datos_experiencia{
        position: absolute;
        margin-left: 470px;
        top: 0;
    }
    .text_sector_experiencia{
        margin-left: 23px;
        font-size: 14px;
    }
    .text_puesto_experiencia{
        margin-left: 23px;
        font-size: 14px;
    }
    .text_empresa_experiencia{
        font-size: 14px;
    }
    .fin_exp{
        margin-top: 6px;
        margin-left:24px;
        font-size: 14px;
        width: 67% !important;
    }
    .txt_area_educacion{
        font-size: 14px;
    }
    .txt_area_intitucion{
        font-size: 14px;
        margin-left:24px;
    }
    .txt_fecha_fecha{
        font-size: 14px;
        margin-left:24px;
    }
    .txt_estado_estado{
        font-size: 14px;
        margin-left:26px;
    }
    .txt_curso_taller{
        font-size: 14px;
        margin-left:26px;
    }
    .fecha_educacion{
        position: absolute;
        margin-left: 470px;
        top: 0;
    }
    .caja_curso_x{
        width: 64% !important;
    }  
</style>
<body>
    <div class="head_cv">
        
        <div class="sect_datos_personales" style="width: {{ $alumno->foto == null ? '100%' : '72%'}}">
            <h2 class="titulo_nombres">{{ $alumno->apellidos ." ". $alumno->nombres }}</h2>
                <div class="tipo_letra">
                    <b>DNI:</b>  {{ $alumno->dni }}, 
                    {{-- <b>Dirección:</b> {{ $alumno->direccion }}, --}}
                    @if(count($distritos) > 0)
                    @foreach($distritos as $q)
                        @php
                            if($alumno->distrito_id == $q->id){
                
                                echo "<b>Distrito:</b> ".$q->nombre." ,";
                            }
                
                        @endphp
                    @endforeach
                    @endif
                    <b>Celular: {{ $alumno->telefono }}</b>,
                    <b>Email:{{ $alumno->email }}</b> 
                </div>
                
            </p>
            <p class='letra_perfil_profesional'>
                {{ $alumno->perfil_profesional }} 
            </p>
        </div>        
        <div class="img_perfil">
            @if($alumno->foto != null)
                <img src="{{ "http://bolsadetrabajo.ial.edu.pe/uploads/alumnos/fotos/".$alumno->foto }}" alt="">
            @endif
        </div>

    </div>

    {{-- <div class="title_datos_personales">Datos Personales</div>
    <p>FECHA DE NACIMIENTO: {{ $alumno->fecha_nacimiento }}</p>
    @if(count($distritos) > 0)
    @foreach($distritos as $q)
        @php
            if($alumno->distrito_id == $q->id){

                echo "<p>DISTRITO : ".$q->nombre."</p>";
            }

        @endphp
    @endforeach
    @endif
    <p>CORREO : {{ $alumno->email }}</p>
    <p>CELULAR : {{ $alumno->telefono }}</p> --}}

    <div class="titulo_exp_laboral" style="display:{{count($experienciaLaboral) > 0 ? 'block' : 'none'}}"><b>EXPERIENCIA LABORAL</b></div>
    @foreach($experienciaLaboral as $q)
        <div class="caja_item_esperiencia">
            <div class="data_experiencia1"><b class="punto_negro_experiencia">.</b> 
                <b class="text_empresa_experiencia">{{ strtoupper($q->empresa) }}</b> <br>
                {{-- <span class="text_sector_experiencia">{{ $q->sector }}</span> <br> --}}
                <b class="text_puesto_experiencia">{{ $q->puesto }}</b> 
                <p class='fin_exp'>
                    {{-- @php
                        echo "<p class='fin_exp' style='color: red;'>".$q->descripcion."</p>";
                    @endphp --}}
                    {{ strip_tags($q->descripcion) }}
                </p>    
            </div>
            <div class="datos_experiencia">
                <p> ( {{ date("m/Y", strtotime($q->inicio_laburo)) }}  -  {{ $q->fin_laburo == null || $q->fin_laburo == "" ? $q->estado : date("m/Y", strtotime($q->fin_laburo)) }} )</p>         
            </div>
        </div>
    @endforeach

    <div class="titulo_educacion" style="display:{{count($educaciones) > 0 ? 'block' : 'none'}}"><b>EDUCACIÓN Y FORMACIÓN</b> </div>
    @foreach($educaciones as $q)
    <div class="info-content">
        <div class="caja_item_esperiencia">
            <div class="data_experiencia1"><b class="punto_negro_experiencia">.</b>
                <b class="txt_area_educacion">{{ $q->areas != null ? $q->areas->nombre : "-" }}</b> <br>
                <b class="txt_area_intitucion">{{ $q->institucion }}</b> <br>
                @if($q->estado == "Estudiante")
                <span class="txt_estado_estado">{{ $q->estado }} del {{ $q->ciclo }} ciclo</span>
                @else
                <span class="txt_estado_estado">{{ $q->estado }}</span>
                @endif
            </div><br>
            <div class="datos_experiencia">
                @if ($q->estado == "Estudiante")
                    <span class="fecha_educacion"> ( {{ date("m/Y", strtotime($q->estudio_inicio)) }}{{ $q->estado_estudiante != null ? " - ".$q->estado_estudiante : "" }} )</span>
                @else
                    <span class="fecha_educacion"> ( {{ date("m/Y", strtotime($q->estudio_inicio)) }}  -  {{  date("m/Y", strtotime($q->estudio_fin)) }} )</span>
                @endif
            </div>
        </div>
    </div>
    @endforeach

    <div class="titulo_cursos" style="display:{{count($referenciaLaboral) > 0 ? 'block' : 'none'}}"><b>CURSOS</b></div>
    @foreach ($referenciaLaboral as $q)
    <div class="caja_item_esperiencia">
        <div class="data_experiencia1 caja_curso_x"><b class="punto_negro_experiencia">.</b> 
            <b class="text_empresa_experiencia">{{ $q->name_curso }}</b> <br>
            <b class="text_sector_experiencia">{{ $q->institucion }}</b>
                @php
                    echo "<p class='fin_exp' style='color: red;'>".$q->descripcion."</p>";
                @endphp
                {{-- {{ strip_tags($q->descripcion) }} --}}
        </div>
        <div class="datos_experiencia">
            <p> ( {{ date("m/Y", strtotime($q->inicio_curso)) }}  -  {{ $q->fin_curso == null || $q->fin_curso == "" ? $q->estado : date("m/Y", strtotime($q->fin_curso)) }} )</p>         
        </div>
    </div>
    @endforeach

    <div class="titulo_habilidades" style="display:{{strlen($alumno->referentes_carrera) >= 1 ? 'block' : 'none'}}"><b>OTRAS HABILIDADES</b> </div>
    @php
        echo $alumno->referentes_carrera;
    @endphp

</body>
</html>