<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado - Una Mirada a Tu Futuro</title>
    <link rel="stylesheet" href="{{ asset('app/css/home/encuesta.css') }}">
    <meta name="description" content="Completa este formulario para conocer más sobre tus fortalezas y afinidades personales. Una iniciativa del Instituto Arzobispo Loayza para apoyarte en tu futuro profesional.">
    <meta name="keywords" content="Instituto Arzobispo Loayza, orientación vocacional, perfil personal, fortalezas, potencial, autoconocimiento, desarrollo profesional">
    <meta name="author" content="Instituto Arzobispo Loayza">
    <link rel="icon" type="image/png" href="{{ asset('app/img/logo_ial.png') }}">
</head>
<body>
    <div class="ancho">
    <div class="contenedor-todo">
        <header class="encabezado">
            <h1 id="title">Resultado - TEST  de competencias y habilidades<br></h1>
            <p id="description">Identifica tus fortalezas en el ámbito laboral y reconoce aquello que te hace único. Comparte tus resultados y capta la atención de empresas que buscan talentos como el tuyo.</p>
        </header>
        <form action="{{ route('alumno.store-active-inteligencias-multiples') }}" method="POST" class="contenedor-formulario" id="survey-form">
            @csrf
            <h1>Inteligencias Destacadas</h1>
            @if (count($destacadas) > 0)
                @foreach ($destacadas as $destacada)
                    <div class="componentesFormulario">
                        <h4>{{ $destacada['name'] }}</h4>
                        <p>{{ $destacada['description'] }}</p>
                    </div>
                @endforeach
            @else
                <div class="alert alert-danger">
                    No se detectaron inteligencias destacadas.
                </div>
            @endif
            <p>¿Quieres que las empresas vean el resultado de tu test de competencias en tu CV?</p>
            <div class="componentesFormulario">
                <label for="active" class="form-check-label" style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input 
                        type="checkbox" 
                        name="active" 
                        id="active" 
                        value="1" 
                        class="input-check"
                        style="margin: 0;"
                        {{ isset($intelligenceHistoryData) && $intelligenceHistoryData->visualizacion == 1 ? 'checked' : '' }}
                    >
                    Activa esta opción para aumentar tu visibilidad profesional.
                </label>
            </div>            
            <button 
                type="submit" 
                id="enviar"
                class="input-boton" 
                title="bt">
                Actualizar
            </button>
            @if ($puedeMostrarBoton)
                <!--Campo boton-->
                <div class="componentesFormulario">
                    <button 
                        type="button" 
                        id="regresar"
                        class="input-boton btn-regresar" 
                        title="bt">
                        <a href="{{ route('alumno.resultado-inteligencias-multiples') }}" class="enlace-corregido">Regresar Encuesta</a>
                    </button>
                </div>
            @else
                <!--Campo boton-->
                <div class="componentesFormulario">
                    <button 
                        type="button" 
                        id="regresar"
                        class="input-boton btn-regresar" 
                        title="bt">
                        <a href="{{ route('alumno.avisos') }}" class="enlace-corregido">Regresar Inicio</a>
                    </button>
                </div>
            @endif
        </form>
    </div>
    </div>
</body>
</html>