@extends('auth.index')

@section('titulo')
    <title>BolsaTrabajo | Inicio</title>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('auth/plugins/datatable/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('auth/css/inicio/core.css') }}">
@endsection
<style type="text/css">
    .txt_claro {
        background: #79f57f63;
        /* color: #fff; */
    }

    .label-as-badge {
        border-radius: 1em;
        font-size: 12px;
        cursor: pointer;
    }

    table.dataTable th,
    table.dataTable td {
        white-space: nowrap;
    }

    .sorting_1 {
        padding-left: 30px !important;
    }
</style>

@section('contenido')
    <div class="content-wrapper">

        <section class="content-header">
            <h1>
                Dashboard
                <small>| Inicio</small>
            </h1>
        </section>

        <br>
        {{-- Cargando --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-3 mb-4">
                    <div class="container rounded"
                        style="background-color: #ffffff; padding: 20px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); text-align: center;
                        border-radius:35px !important;">
                        <form id="filtro-form" action="{{ route('auth.inicio') }}" method="GET">
                            <div class="form-group">
                                <label for="fecha_desde" class="m-0 label-primary">Mostrar desde</label>
                                <input type="date" class="form-control form-control-sm" id="fecha_desde"
                                    name="fecha_desde" value="{{ request()->input('fecha_desde', date('Y-m-d')) }}">
                                @error('fecha_desde')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="fecha_hasta" class="m-0 label-primary">Mostrar hasta</label>
                                <input type="date" class="form-control form-control-sm" id="fecha_hasta"
                                    name="fecha_hasta" value="{{ request()->input('fecha_hasta', date('Y-m-d')) }}">
                                @error('fecha_hasta')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mt-3">
                                <button type="submit" id="filtro-submit" class="btn btn-primary btn-sm"
                                    style="border-color: #2ecc71; border-radius: 5px;">Aplicar Filtro</button>
                                <div id="loading" style="display: none;">
                                    Cargando...
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-3 mb-4">
                    <div class="totales text-center">
                        <div class="title">
                            <p class="title-text" style="color:rgb(255, 187, 0)">
                                <i class="fa fa-building"></i> Total de Empresas
                            </p>
                        </div>
                        <div class="data">
                            <p id="totalEmpresasAprobadas">
                                {{ $totalEmpresasAprobadas }}
                            </p>
                            <div class="range">
                                <div class="fill"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 mb-4">
                    <div class="totales text-center">
                        <div class="title">
                            <p class="title-text" style="color:rgb(0, 175, 102)">
                                <i class="fa fa-users"></i> Total de Usuarios
                            </p>
                        </div>
                        <div class="data">
                            <p id="totalUsuarios">
                                {{ $totalUsuarios }}
                            </p>
                            <div class="range">
                                <div class="fill"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 mb-4">
                    <div class="totales text-center">
                        <div class="title">
                            <p class="title-text" style="color:rgb(111, 0, 255)">
                                <i class="fa fa-bullhorn"></i> Total de Avisos
                            </p>
                        </div>
                        <div class="data">
                            <p id="totalAvisos">
                                {{ $totalAvisos }}
                            </p>
                            <div class="range">
                                <div class="fill"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center mt-4">
                <div class="col-lg-9">
                    <div class="alert alert-success" role="alert">
                        <span class="fa fa-check-circle"></span> <!-- Icono de check -->
                        Por favor, aplique filtros por fecha para visualizar gráficos e indicadores actualizados.
                    </div>
                </div>
            </div>

        </div>
        <br>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="content-header"
                        style="box-shadow: 0 2px 25px -5px rgba(0, 0, 0, .16), 0 25px 21px -5px rgba(0, 0, 0, .1) !important;">
                        <div id="container"></div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="content-header"
                        style="box-shadow: 0 2px 25px -5px rgba(0, 0, 0, .16), 0 25px 21px -5px rgba(0, 0, 0, .1) !important;">
                        <div id="usuarios"></div>
                    </div>
                </div>
            </div>

            <br>
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="content-header"
                        style="box-shadow: 0 2px 25px -5px rgba(0, 0, 0, .16), 0 25px 21px -5px rgba(0, 0, 0, .1) !important;">
                        <div id="grafico"></div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="content-header"
                        style="box-shadow: 0 2px 25px -5px rgba(0, 0, 0, .16), 0 25px 21px -5px rgba(0, 0, 0, .1) !important;">
                        <div id="carreraporcontratado"></div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="content-header"
                        style="box-shadow: 0 2px 25px -5px rgba(0, 0, 0, .16), 0 25px 21px -5px rgba(0, 0, 0, .1) !important;">
                        <div id="otro"></div>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>
@endsection

@section('scripts')
    <!-- Incluir archivos de Highcharts -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/boost.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/variwide.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>


    <script type="text/javascript" src="{{ asset('auth/js/inicio/index.js') }}"></script>

    <script type="text/javascript">
        // Obtener los datos proporcionados por el controlador
        @isset($empresas)

            // Obtener las empresas desde el controlador
            var empresas = @json($empresas);

            // Configurar el gráfico de Highcharts
            Highcharts.chart('container', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'INFORMACIÓN DE LAS EMPRESAS'
                },
                tooltip: {
                    formatter: function() {
                        return '<b>' + this.point.name + ': ' + this.point.percentage.toFixed(0) + '%</b>';
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '{point.name}: {point.y}'
                        }
                    }
                },
                series: [{
                    name: 'Cantidad',
                    colorByPoint: true,
                    data: empresas.map(item => ({
                        name: item.tipo_persona,
                        y: item.cantidad
                    }))
                }]
            });

            /*  */

            var programasContratados =  @json($programasContratados);
            console.log(programasContratados);

            Highcharts.chart('otro', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'CONTRATADOS POR PROGRAMA DE INSERCIÓN'
                },
                tooltip: {
                    pointFormat: 'Contratados: <b>{point.y}</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            distance: 20,
                            format: '{point.name}: {point.y}'
                        }
                    }
                },
                series: [{
                    name: 'Porcentaje',
                    colorByPoint: true,
                    data: programasContratados.map(function(programa) {
                        return {
                            name: programa.tipo_programa,
                            y: parseFloat(programa.cantidad_contratados)
                        };
                    })
                }]
            });


            /*  */
            var seriesData = @json($totalAvisosporEmpleador);

            Highcharts.chart('grafico', {
                chart: {
                    type: 'column'
                },
                title: {
                    align: 'left',
                    text: 'CANTIDAD DE AVISOS POR EMPLEADOR'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'Cantidad de Avisos'
                    }
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y}'
                        }
                    }
                },
                series: [{
                    name: 'Cantidad de Avisos',
                    colorByPoint: true,
                    data: seriesData
                }]
            });

            /*  */
            var carrera = @json($totalContratadosporCarrera);

            Highcharts.chart('carreraporcontratado', {
                chart: {
                    type: 'column'
                },
                title: {
                    align: 'left',
                    text: 'CANTIDAD DE CONTRATADOS POR PROGRAMA DE ESTUDIO'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'Cantidad de Contratados'
                    }
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y}'
                        }
                    }
                },
                series: [{
                    name: 'Cantidad de Contratados',
                    colorByPoint: true,
                    data: carrera
                }]
            });

            // Convertir los datos de PHP a JavaScript
            var TotalUsuariosporCarrera = @json($TotalUsuariosporCarrera);

            // Preparar los datos para Highcharts
            var seriesData = TotalUsuariosporCarrera.map(item => item.cantidad_alumnos);

            // Configurar el gráfico de Highcharts
            Highcharts.chart('usuarios', {
                chart: {
                    type: 'column' // Tipo de gráfico de columnas (bar chart)
                },
                title: {
                    text: 'Usuarios Registrados por Programa de Estudio'
                },
                xAxis: {
                    categories: TotalUsuariosporCarrera.map(item => item
                        .nombre_area), // Usamos nombre_area como categorías
                    title: {
                        text: 'Programa de Estudio'
                    }
                },
                yAxis: {
                    title: {
                        text: 'Cantidad de Usuarios'
                    }
                },
                series: [{
                    name: 'Cantidad de Usuarios',
                    data: seriesData
                }]
            });

            /* a */
        @else
            // Manejar el caso en el que $empresas no está definida
            console.error('Variable $empresas no definida en la vista.');
        @endisset
    </script>
@endsection
