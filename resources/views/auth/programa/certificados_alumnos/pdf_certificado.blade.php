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
            background-image: url('https://bolsadetrabajo.ial.edu.pe/{{ $templatePdf["template"] }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
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
    <div class="contenido @if ($templatePdf['id'] == 1) mover-container @endif">
        <p class="description @if ($templatePdf['id'] == 2 || $templatePdf['id'] == 3) mover @endif"><b>{{ $entity->nombres }} {{ $entity->apellidos }}</b></p>
    </div>
    <div class="contenido-date">
        <p>Lima, {{ $date }}</p>
    </div>
</body>
</html>
