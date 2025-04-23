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
    @if ($templatePdf['id'] != 1)
        <div style="width: 100%; padding: 0 4cm 4cm 0; box-sizing: border-box; margin-top: 170px;">
            <div style="text-align: right; font-size: 18px;">
                <p>Lima, {{ $date }}</p>
            </div>
        </div> 
    @else
        <div style="width: 100%; padding: 0 4cm 4cm 0; box-sizing: border-box; margin-top: 130px;">
            <div style="text-align: right; font-size: 18px;">
                <p>Lima, {{ $date }}</p>
            </div>
        </div>
    @endif  
</body>
</html>
