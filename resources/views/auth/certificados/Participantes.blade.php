<div id="modalMantenimientoParticipantes" class="modal modal-fill fade" data-backdrop="false" tabindex="-1">
    <div class="modal-dialog modal-md">
        <form enctype="multipart/form-data" action="{{-- {{ route('auth.programa.storeParticipantes') }} --}}" id="registroParticipantes" method="POST"
            data-ajax="true" data-close-modal="true" data-ajax-loading="#loading"
            data-ajax-success="OnSuccessRegistroParticipantes" data-ajax-failure="OnFailureRegistroParticipantes">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Añadir Participante </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <input type="hidden" name="id_certificados" class="id_certificados"
                            value="{{ $Entity != null ? $Entity->id : '' }}" required>
                        <div style="display: flex; flex-wrap: wrap;">
                            <div class="form-group col-lg-6">
                                <label for="dni" class="m-0 label-primary">DNI <b
                                        style="color:red;font-size:10px">(Obligatorio*)</b></label>
                                <div class="input-group">
                                    <input autocomplete="off" type="text" class="form-control form-control-sm"
                                        id="dni" name="dni" placeholder="Ingresar DNI" minlength="1"
                                        required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" id="buscardni" type="button"
                                            style="background-color: #0072bf; color: white;">
                                            <i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                                <div class="invalid-feedback">
                                    Por favor ingresa un DNI válido (entre 1 y 8 dígitos).
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label for="nombre" class="m-0 label-primary">Nombres</label>
                                <input autocomplete="off" type="text" class="form-control form-control-sm"
                                    id="nombres" name="nombres" placeholder="Nombres" readonly required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="apellidos" class="m-0 label-primary">Apellidos</label>
                                <input autocomplete="off" type="text" class="form-control form-control-sm"
                                    id="apellidos" name="apellidos" placeholder="Apellidos" readonly required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="especialidad" class="m-0 label-primary">Programa de Estudio</label>
                                <input autocomplete="off" type="text" class="form-control form-control-sm"
                                    id="especialidad" name="especialidad" placeholder="Programa de estudio" readonly
                                    required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="telefono" class="m-0 label-primary">Teléfono</label>
                                <input autocomplete="off" type="tel" class="form-control form-control-sm"
                                    id="tel" name="tel" placeholder="Teléfono">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="correo" class="m-0 label-primary">Correo Electrónico</label>
                                <input autocomplete="off" type="email" class="form-control form-control-sm"
                                    id="email" name="email" placeholder="Correo Electrónico">
                            </div>
                            <style>

                            </style>
                            <div class="form-group col-lg-12">
                                <!-- Botón de Envío -->
                                <button type="submit" class="btn btn-primary "
                                    style="background-color:#2ecc71; border-color:#2ecc71; color:#fff;">
                                    <i class="fa fa-user-plus"></i> Registrar participante
                                </button>
                                <!-- Botón de Cancelar (opcional) -->
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                    style="background-color:#e74c3c; border-color:#e74c3c; color:#fff;">
                                    <i class="fa fa-times"></i> Cancelar
                                </button>
                            </div>


                        </div>
                    </div>

                    <div>
                        <div class="col-lg-12 col-md-12">
                            <div class="table-wrapper">
                                <table id="tableParticipantes"
                                    class="display table table-bordered table-hover table-condensed">
                                    <thead>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
    // Define las variables en el contexto global de JavaScript
    var userProfileId = @json(Auth::guard('web')->user()->profile_id);
    var PERFIL_DESARROLLADOR = @json(\BolsaTrabajo\App::$PERFIL_DESARROLLADOR);
</script>
<script type="text/javascript" src="{{ asset('auth/js/certificados/_Participantes.js') }}"></script>
