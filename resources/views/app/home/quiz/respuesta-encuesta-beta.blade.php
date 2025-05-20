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
            <h1 id="title">Resultado - Una Mirada a Tu Futuro<br></h1>
            <p id="description">Esta breve actividad nos ayudará a orientarte mejor en tu desarrollo profesional dentro del Instituto Arzobispo Loayza.</p>
        </header>
        <form class="contenedor-formulario" id="survey-form">
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
            <!--Campo boton-->
            <div class="componentesFormulario">
                <button 
                type="button" 
                id="regresar"
                class="input-boton" style="background-color: #17a2b8;"
                title="bt">
                <a href="{{ route('encuesta-psicologa-beta') }}" style="text-decoration: none;color: white;">Regresar</a>
                </button>
            </div>
        </form>
    </div>
    </div>
</body>
</html>