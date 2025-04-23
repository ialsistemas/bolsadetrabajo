<!DOCTYPE html>
<html>
<head>
    <title>Certificado</title>
    <style>
        @page {
            margin: 0cm;
        }

        body {
            margin: 0cm;
            font-family: sans-serif;
            position: relative;
        }

        .fondo {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        .contenido {
            position: relative;
            z-index: 1;
            padding-top: 9cm; 
            text-align: center;
        }
        .mover-container{
            padding-top: 9.5cm; 
        }
        .contenido-date {
            position: absolute;
            right: 4cm;
            bottom: 4cm;
            font-size: 18px;
        }
        .description{
            font-size: {{ $templatePdf['font-size'] }}
        }
        .mover {
            position: relative;
            left: 2cm;
        }
    </style>
</head>
<body>
    <img class="fondo" src="{{ $templatePdf['template'] }}" alt="Fondo del certificado - url: {{ $templatePdf['template'] }}">
    <div class="contenido @if ($templatePdf['id'] == 1) mover-container @endif">
        <p class="description @if ($templatePdf['id'] == 2 || $templatePdf['id'] == 3) mover @endif"><b>{{ $entity->nombres }} {{ $entity->apellidos }}</b></p>
        url imagen: {{ $templatePdf['template'] }}
    </div>
    <div class="contenido-date">
        <p>Lima, {{ $date }}</p>
    </div>
</body>
</html>
