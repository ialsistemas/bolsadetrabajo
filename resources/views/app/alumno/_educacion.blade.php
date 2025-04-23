<div id="modalMantenimientoEducacion" class="modal modal-fill fade" data-backdrop="false" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form enctype="multipart/form-data" action="{{ route('alumno.perfil.educacion_store') }}" id="registroEducacion" method="POST"
            data-ajax="true" data-close-modal="true" data-ajax-loading="#loading" data-ajax-success="OnSuccessRegistroEducacion" data-ajax-failure="OnFailureRegistroEducacion">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $Educacion != null ? "Modificar" : " Registrar" }}  Educación</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="id" name="id" value="{{ $Educacion != null ? $Educacion->id : 0 }}">

                    <div class="form-group row">
                        <div class="col-md-6 mt-2">
                            <input type="text" name="institucion" id="institucion" class="form-input" 
                                value="{{ $Educacion != null ? $Educacion->institucion : 'INSTITUTO ARZOBISPO LOAYZA' }}" 
                                placeholder="Institución" 
                                {{ $Educacion != null ? 'readonly' : '' }} required>
                            <span data-valmsg-for="empresa"></span>
                        </div>

                        <div class="col-md-6 mt-2">
                            @if ($Educacion != null)
                                <select id="area_id" class="form-input">
                                    @foreach($Areas as $q)
                                        @if($Educacion->area_id == $q->id)
                                            <option value="{{ $q->id }}" selected>{{ $q->nombre }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <input type="hidden" name="area_id" value="{{ $Educacion->area_id }}">
                            @else
                                <select name="area_id" id="area_id" class="form-input" required>
                                    <option value="">PROGRAMA DE ESTUDIOS</option>
                                    @foreach($Areas as $q)
                                        <option value="{{ $q->id }}">{{ $q->nombre }}</option>
                                    @endforeach
                                </select>
                            @endif
                            <span data-valmsg-for="area_id"></span>
                        </div>

                        <div class="col-md-6 mt-2">
                            <select name="estado" id="estado" class="form-input" required>
                                <option value="">Grado académico</option>
                                <option value="0" {{ $Educacion != null && $Educacion->estado == "Estudiante" ? "selected" : "" }}>Estudiante</option>
                                <option value="1" {{ $Educacion != null && $Educacion->estado == "Egresado" ? "selected" : "" }}>Egresado</option>
                                <option value="2" {{ $Educacion != null && $Educacion->estado == "Titulado" ? "selected" : "" }}>Titulado</option>
                            </select>
                            <span data-valmsg-for="estado"></span>
                        </div>

                        <div class="col-md-6 mt-2" id="ciclo">
                            <select name="ciclo" class="form-input">
                                <option value="">Ciclo</option>
                                <option value="I" {{ $Educacion != null && $Educacion->ciclo == "I" ? "selected" : "" }}>I ciclo</option>
                                <option value="II" {{ $Educacion != null && $Educacion->ciclo == "II" ? "selected" : "" }}>II ciclo</option>
                                <option value="III" {{ $Educacion != null && $Educacion->ciclo == "III" ? "selected" : "" }}>III ciclo</option>
                                <option value="IV" {{ $Educacion != null && $Educacion->ciclo == "IV" ? "selected" : "" }}>IV ciclo</option>
                                <option value="V" {{ $Educacion != null && $Educacion->ciclo == "V" ? "selected" : "" }}>V ciclo</option>
                                <option value="VI" {{ $Educacion != null && $Educacion->ciclo == "VI" ? "selected" : "" }}>VI ciclo</option>
                            </select>
                        </div>

                        <div id="inicio_estudio" class="col-md-6 mt-2">
                            <input class="form-input" value="{{ $Educacion != null ? $Educacion->estudio_inicio : "" }}" name="inicio_estudio" placeholder="Inicio de estudio" type="text" onfocus="(this.type = 'month')" onblur="(this.type='text')" required>
                        </div>

                        <div id="fin_estudio" class="col-md-3 mt-2">
                            <input  value="{{ $Educacion != null ? $Educacion->estudio_fin : "" }}" class="form-input" name="fin_estudio" placeholder="Año de Egreso" type="text" onfocus="(this.type = 'month')" onblur="(this.type='text')">
                        </div>

                        <div id="estado_estudiante" class="col-md-6 mt-2">
                            <select name="estado_estudiante" class="form-input" id="select_estado_estd" required>
                                <option value="">Estado</option>
                                <option value="En Curso" {{ $Educacion != null && $Educacion->estado_estudiante == "En Curso" ? "selected" : "" }}>En Curso</option>
                                <option value="Trunco" {{ $Educacion != null && $Educacion->estado_estudiante == "Trunco" ? "selected" : "" }}>Trunco</option>
                            </select>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-bold btn-pure btn-primary">{{ $Educacion != null ? "Modificar" : " Registrar" }} Educación</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="{{ asset('app/js/alumno/_educacion.js') }}"></script>
<script>
    $('#modalMantenimientoEducacion').on('shown.bs.modal', function () {
        
    });
</script>

