<div id="modalMantenimientoPrograma" class="modal modal-fill fade" data-backdrop="false" tabindex="-1">
    <div class="modal-dialog modal-md">
        <form enctype="multipart/form-data" action="{{ route('auth.programa.updateDataEmpleabilidad') }}" id="registroPrograma"
            method="POST" data-ajax="true" data-close-modal="true" data-ajax-loading="#loading"
            data-ajax-success="OnSuccessRegistroPrograma" data-ajax-failure="OnFailureRegistroPrograma">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Datos del Programa</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id" value="{{ $Entity != null ? $Entity->id : '' }}" required>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                    <label for="registro" class="m-0 label-primary">Fecha</label>
                                    <input type="date" class="form-control form-control-sm" id="registro"
                                        name="registro" value="{{ $Entity != null ? $Entity->registro : '' }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="">Programa</label>
                                <select name="tipo_programa" id="tipo_programa" class="form-input" required>
                                    <option value="" hidden>-- Seleccione --</option>
                                    <option value="DESPEGA 360"
                                        {{ old('tipo_programa', isset($Entity) ? $Entity->tipo_programa : '') == 'DESPEGA 360' ? 'selected' : '' }}>
                                        DESPEGA 360</option>
                                    <option value="CARRERA PRO"
                                        {{ old('tipo_programa', isset($Entity) ? $Entity->tipo_programa : '') == 'CARRERA PRO' ? 'selected' : '' }}>
                                        CARRERA PRO</option>
                                    <option value="SKILLS TO WORK"
                                        {{ old('tipo_programa', isset($Entity) ? $Entity->tipo_programa : '') == 'SKILLS TO WORK' ? 'selected' : '' }}>
                                        SKILLS TO WORK</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">Responsable</label>
                                <select name="responsable" id="responsable" class="form-input" required>
                                    <option value="" hidden>-- Seleccione --</option>
                                    <option value="Gina Vera"
                                        {{ old('responsable', isset($Entity) ? $Entity->responsable : '') == 'Gina Vera' ? 'selected' : '' }}>
                                        Gina Vera</option>
                                    <option value="Florencia Hurtado"
                                        {{ old('responsable', isset($Entity) ? $Entity->responsable : '') == 'Florencia Hurtado' ? 'selected' : '' }}>
                                        Florencia Hurtado</option>
                                    <option value="Evangelyn Caceres"
                                        {{ old('responsable', isset($Entity) ? $Entity->responsable : '') == 'Evangelyn Caceres' ? 'selected' : '' }}>
                                        Evangelyn Caceres</option>
                                    <option value="Alexa Alvarez"
                                        {{ old('responsable', isset($Entity) ? $Entity->responsable : '') == 'Alexa Alvarez' ? 'selected' : '' }}>
                                        Alexa Alvarez</option>
                                </select>
                            </div>
                            <div class="col-md-12 text-center">
                                <button tyoe="submit" class="btn btn-primary" style="margin-top:28px;border-color:#2ecc71!important;">Actualizar Programa</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="{{ asset('auth/js/programa/_Editar.js') }}"></script>
