@extends('auth.index')

@section('titulo')
    <title>BolsaTrabajo | Programas de Empleabilidad</title>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('auth/plugins/datatable/datatables.min.css') }}">
@endsection

@section('contenido')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Publicar Programas de Empleabilidad
            </h1>
        </section>
        <br>
        <div class="content-header">
            <div class="row">
                <form class="col-lg-4 col-md-4" action="{{ route('auth.programa.store-empleabilidad') }}" method="post">
                    @csrf
                    <div class="form-group col-lg-12">
                        <label for="registro" class="m-0 label-primary">Fecha</label>
                        <input type="date" class="form-control form-control-sm" id="registro"
                            name="registro" value="{{ old('registro') }}" required>
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="tipo_programa" class="m-0 label-primary">Programa <b
                                style="color:red;font-size:10px">(Obligatorio*)</b></label>
                        <select name="tipo_programa" id="tipo_programa" class="form-control form-control-sm" required>
                            <option value="">Seleccione</option>
                            <option value="DESPEGA 360" {{ old('tipo_programa') == 'DESPEGA 360' ? 'selected' : '' }}>
                                DESPEGA 360</option>
                            <option value="CARRERA PRO" {{ old('tipo_programa') == 'CARRERA PRO' ? 'selected' : '' }}>CARRERA PRO</option>
                            <option value="SKILLS TO WORK" {{ old('tipo_programa') == 'SKILLS TO WORK' ? 'selected' : '' }}>SKILLS TO WORK</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="responsable" class="m-0 label-primary">Responsable <b
                                style="color:red;font-size:10px">(Obligatorio*)</b></label>
                        <select name="responsable" id="responsable" class="form-control form-control-sm" required>
                            <option value="">Seleccione</option>
                            <option value="Gina Vera"
                                {{ old('responsable') == 'Gina Vera' ? 'selected' : '' }}>Gina Vera
                            </option>
                            <option value="Florencia Hurtado" {{ old('responsable') == 'Florencia Hurtado' ? 'selected' : '' }}>
                                Florencia Hurtado
                            </option>
                            <option value="Evangelyn Caceres"
                                {{ old('responsable') == 'Evangelyn Caceres' ? 'selected' : '' }}>Evangelyn Caceres
                            </option>
                            <option value="Alexa Alvarez" {{ old('responsable') == 'Alexa Alvarez' ? 'selected' : '' }}>
                                Alexa Alvarez</option>
                        </select>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-group col-lg-12">
                        <button type="submit" class="btn btn-primary" style="border-color:#2ecc71 !important;">Guardar
                            Programa</button>
                    </div>
                </form>
                <div class="col-lg-8 col-md-8">
                    <div class="table-wrapper">
                        <table id="tablePrograma" class="display table table-bordered table-hover table-condensed">
                        </table>
                    </div>
                    <div class="form-group col-lg-3 col-md-12 d-flex flex-column">
                        <a href="javascript:void(0)" class="btn-m btn-success-m" onclick="clickExcelAlumno()">
                            <i class="fa fa-file"></i> Exportar excel
                        </a>
                    </div>
                </div>
                <style>
                    #tablePrograma {
                        max-width: 100%;
                    }
                </style>
            </div>
        </div>
        <script>
            var numPuestosAgregados = 0;
            var nombresPuestos = ['dos', 'tres', 'cuatro'];
            function agregarPuesto() {
                if (numPuestosAgregados < 3) {
                    numPuestosAgregados++;

                    var nuevosPuestosDiv = document.getElementById('nuevosPuestos');
                    var nuevoPuestoHTML = `
                <div class="form-group col-lg-12">
                    <label for="puesto${nombresPuestos[numPuestosAgregados - 1]}" class="m-0 label-primary">Puesto ${nombresPuestos[numPuestosAgregados - 1].charAt(0).toUpperCase() + nombresPuestos[numPuestosAgregados - 1].slice(1)} <b style="color:green;font-size:10px">(Opcional)</b></label>
                    <input autocomplete="off" type="text" class="form-control form-control-sm" id="puesto${nombresPuestos[numPuestosAgregados - 1]}" name="puesto${nombresPuestos[numPuestosAgregados - 1]}">
                </div>
            `;
                    nuevosPuestosDiv.insertAdjacentHTML('beforeend', nuevoPuestoHTML);
                    if (numPuestosAgregados === 3) {
                        var botonAgregar = document.querySelector('.btn-link');
                        botonAgregar.style.display = 'none';
                    }
                }
            }
        </script>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('auth/plugins/datatable/dataTables.config.min.js') }}"></script>
    <script>
        const urlData = "{{ route('auth.programas.empleabilidad-list') }}";
    </script>
    <script type="text/javascript" src="{{ asset('auth/js/programa/indexEmpleabilidad.js') }}"></script>
@endsection
