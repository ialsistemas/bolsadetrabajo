@extends('app.index')

@section('styles')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('app/css/avisos/index.min.css') }}">
@endsection

@section('content')
    
    <input type="hidden" id="tipo_persona" value="{{ Auth::guard('empresasw')->user()->tipo_persona }}">
    

    <div id="main">

        <div id="loading-avisos">
            <p>Cargando...</p>
        </div>

        <div class="head-section">
            <div class="container">
                <div class="row">
                    <h3>Registrar Oportunidad</h3>
                </div>
            </div>
        </div>

        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-md-3 filter-cont">
                    <div class="filter">
                    </div>
                </div>

                <div class="col-md-7">
                    <form id="registrarEmpresa" action="{{ route('empresa.store_aviso') }}" class="formulario" method="post">
                        @csrf
                        <div class="card aviso">
                            {{-- <p class="alert alert-primary">El Salario mínimo por 8h es de 1025 soles mensuales según ley.</p> --}}

                            
                            <div class="form-group row">
                                {{-- aca --}}
                                <div class="col-md-6" hidden>
                                    <select name="modalidad_id" id="modalidad_id" class="form-input {{ $errors->has('modalidad_id') ? ' is-invalid' : '' }}">
                                        <option value="">Tipo de empleo</option>
                                        @foreach($Modalidades as $q)
                                            <option value="{{ $q->id }}" {{ old('modalidad_id') == $q->id  ? 'selected': '' }}>{{ $q->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('modalidad_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('modalidad_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                {{-- aca --}}
                                <div class="col-md-6" hidden> 
                                    <select name="horario_id" id="horario_id" class="form-input {{ $errors->has('horario_id') ? ' is-invalid' : '' }}">
                                        <option value="">Tiempo de empleo</option>
                                        @foreach($Horarios as $q)
                                            <option value="{{ $q->id }}" {{ old('horario_id') == $q->id  ? 'selected': '' }}>{{ $q->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('horario_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('horario_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 mt-2">
                                    <input type="text" style="text-transform: uppercase;" class="form-input {{ ($errors->has('titulo') || $errors->has('link')) ? ' is-invalid' : '' }}" value="{{ old('titulo') }}" name="titulo" id="titulo" placeholder="Puesto que se ofrece" required>
                                    @if ($errors->has('titulo'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('titulo') }}</strong>
                                        </span>
                                    @endif
                                    @if ($errors->has('link'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('link') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 mt-2">
                                    <input type="number" name="vacantes" id="vacantes" class="form-input" placeholder="Cantidad de Vacantes" required>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <input type="text" value="" name="direccion" class="form-input" placeholder="Dirección donde se ejecutara el trabajo">
                                </div>
                                <div class="col-md-6 mt-2">
                                    <input type="text" name="referencia_direccion" class="form-input" placeholder="Referencias del Lugar del trabajo" required>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <select name="provincia_id" id="provincia_id" class="form-input">
                                        <option value="">Provincia</option>
                                        @foreach($Provincias as $q)
                                            <option value="{{ $q->id }}" >{{ $q->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <select name="distrito_id" id="distrito_id" class="form-input {{ $errors->has('distrito_id') ? ' is-invalid' : '' }}" required>
                                        <option value="">Distrito</option>
                                        @foreach($Distritos as $q)
                                            <option value="{{ $q->id }}" {{ old('distrito_id') == $q->id  ? 'selected': '' }}>{{ $q->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('distrito_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('distrito_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 mt-1">
                                    <select name="solicita_grado_a" id="solicita_grado_a" class="form-input" required>
                                        <option value="" hidden>Grado Académico que solicita</option>
                                        @foreach($Grado as $q)
                                            <option value="{{ $q->id }}">{{ $q->grado_estado }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mt-1">
                                    <select name="ciclo_cursa" id="ciclo_cursa" class="form-input" hidden>
                                        <option value="" hidden>Seleccione el ciclo que cursa</option>
                                        <option value="I">desde I Ciclo</option>
                                        <option value="II">desde II Ciclo</option>
                                        <option value="III">desde III Ciclo</option>
                                        <option value="IV">desde IV Ciclo</option>
                                        <option value="V">desde V Ciclo</option>
                                        <option value="VI">desde VI Ciclo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 mt-2">
                                    <select name="solicita_carrera" id="" class="form-input" required>
                                        <option value="" hidden>Carrera que Solicita</option>
                                        @foreach($Areas as $q)
                                            <option value="{{ $q->id }}">{{ $q->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <input type="text" name="periodo_vigencia" class="form-input" placeholder="Periodo de vigencia (Hasta cuando se aceptan postulaciones)" onfocus="(this.type='date')" onblur="(this.type='text')" required>
                                </div>
                            </div>


                            @if ( Auth::guard('empresasw')->user()->tipo_persona == 1)
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <textarea name="descripcion" id="descripcion" class="form-input {{ $errors->has('descripcion') ? ' is-invalid' : '' }}" cols="30" rows="10" placeholder="Descripción" required>
                                            <?php 
                                                echo (old('descripcion') != null && old('descripcion') != "") ? old('descripcion') : 
                                                '<b>
                                                    REQUISITOS: </b><br><b>
                                                      - Tiempo de Experiencia Minima:</b><br><br><br><b>
                                                      - Indispensable vivir en el distrito o aledaño: Si , No</b><br><b>
                                                      - Otros:</b><br><br><br>
                                                    FUNCIONES:</b><br><br><br><b>
                                                    HORARIO:</b><br><br><br><b>
                                                    BENEFICIOS:</b><br><br><br>' 
                                            ?>                                            
                                        </textarea>
                                        @if ($errors->has('descripcion'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('descripcion') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <textarea name="descripcion" id="descripcion" class="form-input {{ $errors->has('descripcion') ? ' is-invalid' : '' }}" cols="30" rows="10" placeholder="Descripción" required>
                                            <?php 
                                                echo (old('descripcion') != null && old('descripcion') != "") ? old('descripcion') : 
                                                '<b>
                                                    REQUISITOS: </b><br><b>
                                                    - Tiempo de Experiencia Minima:</b><br><br><br><b>
                                                    - Indispensable vivir en el distrito o aledaño: Si , No</b><br><br><br><b>
                                                    - Otros:</b><br><br><br>
                                                    FUNCIONES (Detalle las más resaltantes):</b><br><br><br><b>
                                                    HORARIO:</b><br><br><br>' 
                                            ?>                                            
                                        </textarea>
                                        @if ($errors->has('descripcion'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('descripcion') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif


                            <div class="form-group row">
                                <div class="col-md-6"></div>
                                <div class="col-md-6">
                                    <input type="text" name="salario" id="salario"  class="form-input {{ $errors->has('salario') ? ' is-invalid' : '' }}" value="{{ old('titulo') }}" placeholder="Remuneración Aproximada" required>
                                    @if ($errors->has('salario'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('salario') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="card aviso mt-2">
                            <button type="submit">Registrar Oportunidad</button>
                            <a href="{{ route('empresa.avisos') }}" class="text-uppercase">Regresar</a>
                        </div>
                    </form>
                </div>

                <div class="col-md-2 text-center">
                    <a href="https://wa.me/923001874?text=Hola,vengo%20de%20la%20bolsa%20de%20trabajo%20y%20deseo%20conocer%20más%20de%20los%20servicios%20gratuitos%20para%20las%20empresas%20aliadas." target="_blank">
                        <img src="{{ asset('app/img/nuevaimagen.png') }}" alt="Logo de WhatsApp">
                    </a>
                    
                </div>
            </div>
        </div>

    </div>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('app/plugins/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace( 'descripcion' );
        CKEDITOR.config.height = 510;
    </script>
    <script type="text/javascript" src="{{ asset('app/js/avisos/registrar.js') }}"></script>
    <script>
        $(document).on('change', '#solicita_grado_a', function(event) {
            inputs_validation()
        });
        function inputs_validation(){
            $("#ciclo_cursa").hide();
            var txt = $('#solicita_grado_a').val()
            /* console.log('esto es ewl txt : ',txt) */
            if(txt == 0){
                $("#ciclo_cursa").show();
                $("#ciclo_cursa").attr('hidden',false);
                $("#ciclo_cursa").attr('required', true);
            }
            else if(txt == ""){
                $("#ciclo_cursa").hide();
                $("#ciclo_cursa").attr('required', false); 
            }
            else{
                $("#ciclo_cursa").hide();
                $("#ciclo_cursa").attr('hidden',true);
                $("#ciclo_cursa").attr('required', false);   
            }
        }
        inputs_validation()
    </script>
    <script>
        Swal.fire({
            icon: 'info',
            html:
                'El Salario mínimo por 8h es de 1025 soles mensuales según ley.',
            showCloseButton: true,
            showCancelButton: false,
            showConfirmButton: false,
        })
    </script>

@endsection

