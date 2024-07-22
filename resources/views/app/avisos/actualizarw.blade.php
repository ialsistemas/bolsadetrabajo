<div id="modalMantenimientoAviso" class="modal modal-fill fade" data-backdrop="false" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form enctype="multipart/form-data" action="{{ route('empresa.republicar') }}" id="registroAvisox" method="POST"
            data-ajax="true" data-close-modal="true" data-ajax-loading="#loading"
            data-ajax-success="OnSuccessRegistroAviso" data-ajax-failure="OnFailureRegistroAviso">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Republicar Oportunidad</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="id" name="id" value="{{ $Aviso != null ? $Aviso->id : 0 }}">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <input type="text" name="titulo" id="titulo" class="form-input"
                                value="{{ $Aviso != null ? $Aviso->titulo : '' }}" placeholder="Titulo de oportunidad"
                                required>
                            <span data-valmsg-for="titulo"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <select name="distrito_id" id="distrito_id" class="form-input" required>
                                <option value="">Lugar de Trabajo (Distrito)</option>
                                @foreach ($Distritos as $q)
                                    <option value="{{ $q->id }}"
                                        {{ $Aviso != null && $Aviso->distrito_id == $q->id ? 'selected' : '' }}>
                                        {{ $q->nombre }}</option>
                                @endforeach
                            </select>
                            <span data-valmsg-for="distrito_id"></span>
                        </div>
                        <div class="col-md-6">
                            <input type="number" name="vacantes" class="form-input" placeholder="Cantidad de Vacantes"
                                value="{{ $Aviso->vacantes }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <select name="solicita_carrera" name="" id="" class="form-input" required>
                                <option value="" hidden>Carrera que Solicita</option>
                                @foreach ($Areas as $q)
                                    <option value="{{ $q->id }}"
                                        {{ $Aviso != null && $Aviso->solicita_carrera == $q->id ? 'selected' : '' }}>
                                        {{ $q->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select name="solicita_grado_a" id="solicita_grado_a" class="form-input" required>
                                <option value="" hidden>Grado Académico que solicita</option>
                                @foreach ($Grado as $q)
                                    <option value="{{ $q->id }}"
                                        {{ $Aviso != null && $Aviso->solicita_grado_a == $q->id ? 'selected' : '' }}>
                                        {{ $q->grado_estado }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <input type="text" name="periodo_vigencia" class="form-input"
                                value="{{ $Aviso->periodo_vigencia }}"
                                placeholder="Periodo de vigencia (Hasta cuando se aceptan postulaciones)"
                                onfocus="(this.type='date')" onblur="(this.type='text')" required>
                        </div>
                        {{-- aca tambien --}}
                        <div class="col-md-6">
                            <select name="ciclo_cursa" id="ciclo_cursa" class="form-input">
                                <option hidden class="option_data"
                                    value="{{ $Aviso != null ? $Aviso->ciclo_cursa : '' }}">
                                    {{ $Aviso != null ? $Aviso->ciclo_cursa : '' }}</option>
                                <option value="I">I</option>
                                <option value="II">II</option>
                                <option value="III">III</option>
                                <option value="IV">IV</option>
                                <option value="V">V</option>
                                <option value="VI">VI</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <textarea name="descripcion" id="descripcion" class="form-input" cols="30" rows="10"
                                placeholder="Descripción" required>{{ $Aviso->descripcion }}</textarea>
                            <span data-valmsg-for="descripcion"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <input type="number" name="salario" id="salario"
                                value="{{ $Aviso != null ? $Aviso->salario : '' }}" class="form-input"
                                placeholder="Salario" required min="1025">
                            <span data-valmsg-for="salario"></span>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Republicar Oportunidad</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="{{ asset('app/plugins/ckeditor/ckeditor.js') }}"></script>
<script>
    CKEDITOR.replace('descripcion');
</script>
{{-- <script>
    $(function() {
        $(".modal-footer button").on('click', function(e) {
            for (var instanceName in CKEDITOR.instances) {
                CKEDITOR.instances[instanceName].updateElement();
            }
        });
    })
</script> --}}
<script type="text/javascript" src="{{ asset('app/js/avisos/actualizarw.js') }}"></script>
<script>
    $(document).on('change', '#solicita_grado_a', function(event) {
        inputs_validation()
    });

    function inputs_validation() {
        $("#ciclo_cursa").hide();
        var txt = $('#solicita_grado_a').val()
        if (txt != 0) {
            $("#ciclo_cursa").hide();
            $("#ciclo_cursa").attr('required', false);
        } else {
            $("#ciclo_cursa").show();
            $("#ciclo_cursa").attr('required', true);
            valor = $("#ciclo_cursa").val();
            if (valor != "") {
                // $(".option_data").html("Grado Académico que solicita")
            } else {
                $(".option_data").html("Grado Académico que solicita")
            }
            /* console.log("este es el valor del select : ", valor) */
        }
    }
    inputs_validation()
</script>


