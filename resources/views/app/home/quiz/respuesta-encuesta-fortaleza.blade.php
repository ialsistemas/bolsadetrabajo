<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TEST DE FORTALEZAS PERSONALES – Arzobispo Loayza</title>
    <link rel="stylesheet" href="{{ asset('app/css/home/encuesta-two.css') }}">
    <meta name="description" content="Completa este formulario para conocer más sobre tus fortalezas y afinidades personales. Una iniciativa del Instituto Arzobispo Loayza para apoyarte en tu futuro profesional.">
    <meta name="keywords" content="Instituto Arzobispo Loayza, orientación vocacional, perfil personal, fortalezas, potencial, autoconocimiento, desarrollo profesional">
    <meta name="author" content="Instituto Arzobispo Loayza">
    <link rel="icon" type="image/png" href="{{ asset('app/img/logo_ial.png') }}">
</head>
<body>
    <div class="container">
        <header class="header">
            <h1 id="title" class="txt-center">TEST DE FORTALEZAS PERSONALES</h1>
            <p id="description" class="description">Identifica tus fortalezas en el ámbito laboral y reconoce aquello que te hace único. Comparte tus resultados y capta la atención de empresas que buscan talentos como el tuyo.</p>
        </header>
        <form id="survey-form" action="{{ route('alumno.store-active-fortaleza') }}" method="POST">
            @csrf
            <h1>Resultados:</h1>
            @if (count($destacadas) > 0)
                @foreach ($destacadas as $i => $destacada)
                    <div class="grafico-container">
                        <div class="grafico-box">
                            <canvas id="grafico-{{ $loop->index }}" width="250" height="250"></canvas>
                        </div>
                        <div class="estado-box">
                            <h3 class="estado-titulo">{{ $destacada['estado'] }}</h3>
                            <p class="estado-descripcion">{{ $destacada['estado_description'] }}</p>
                        </div>
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
                        {{ isset($strengthHistoryData) && $strengthHistoryData->visualizacion == 1 ? 'checked' : '' }}
                    >
                    Activa esta opción para aumentar tu visibilidad profesional.
                </label>
            </div>
            <div class="form-group">
                <button type="submit" id="submit" class="submit-button">
                    Enviar
                </button>
            </div>
            @if ($puedeMostrarBoton)
                <!--Campo boton-->
                <div class="componentesFormulario">
                    <button 
                        type="button" 
                        id="regresar"
                        class="submit-button btn-regresar" 
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
                        class="submit-button btn-regresar" 
                        title="bt">
                        <a href="{{ route('alumno.avisos') }}" class="enlace-corregido">Regresar Inicio</a>
                    </button>
                </div>
            @endif
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const datosGraficos = {!! json_encode($destacadas) !!};
    </script>
    <script src="{{ asset('app/js/home/graficos.js') }}"></script>
</body>
</html>