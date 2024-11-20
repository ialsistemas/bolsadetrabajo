<div id="modalMantenimientoPrograma" class="modal modal-fill fade" data-backdrop="false" tabindex="-1">
    <div class="modal-dialog modal-md">
        <form enctype="multipart/form-data" action="{{ route('auth.eventosasistencia.update') }}" id="registroPrograma"
            method="POST" data-ajax="true" data-close-modal="true" data-ajax-loading="#loading"
            data-ajax-success="OnSuccessRegistroPrograma" data-ajax-failure="OnFailureRegistroPrograma">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Datos </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <input type="hidden" name="id" class="id"
                            value="{{ $Entity != null ? $Entity->id : '' }}" required>
                        {{-- {{ $Entity != null ? $Entity->id : '' }}  --}}
                        <div style="display: flex; flex-wrap: wrap;">
                            {{-- <div class="form-group col-lg-6">
                                <label for="dni" class="m-0 label-primary">DNI <b
                                        style="color:red;font-size:10px">(Obligatorio*)</b></label>
                                <div class="input-group">
                                    <input autocomplete="off" type="text" class="form-control form-control-sm"
                                        id="dni" name="dni" placeholder="Ingresar DNI" minlength="1"
                                        value="{{ $Entity ? $Entity->dni : '' }}" readonly required>
                                </div>
                                <div class="invalid-feedback">
                                    Por favor ingresa un DNI válido (entre 1 y 8 dígitos).
                                </div>
                            </div> --}}

                            <div class="form-group col-lg-6">
                                <label for="dni" class="m-0 label-primary"> DNI <b
                                        style="color:red;"">(Obligatorio*)</b></label>
                                <div class="input-group">
                                    <input autocomplete="off" type="text" class="form-control form-control-sm"
                                        id="dni" name="dni" placeholder="Ingresar DNI" minlength="1"
                                        value="{{ $Entity ? $Entity->dni : '' }}" required readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary btn-sm" id="buscardni" type="button"
                                            style="background-color: #0072bf; color: white;">
                                            <i class="fa fa-search"></i> Buscar
                                        </button>
                                    </div>
                                </div>
                                <div class="invalid-feedback" style="font-size: 16px;">
                                    Por favor ingresa un DNI válido (entre 1 y 8 dígitos).
                                </div>
                            </div>
                            {{-- EL CURSOR DNI SIEMPRE ESTE ACTIVO --}}
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    document.getElementById("dni").focus();
                                });
                            </script>

                            <div class="form-group col-lg-6">
                                <label for="nombre" class="m-0 label-primary">Nombres</label>
                                <input autocomplete="off" type="text" class="form-control form-control-sm"
                                    value="{{ $Entity ? $Entity->nombres : '' }}" id="nombres" name="nombres"
                                    placeholder="Nombres" readonly required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="apellidos" class="m-0 label-primary">Apellidos</label>
                                <input autocomplete="off" type="text" class="form-control form-control-sm"
                                    value="{{ $Entity ? $Entity->apellidos : '' }}" id="apellidos" name="apellidos"
                                    placeholder="Apellidos" readonly required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="especialidad" class="m-0 label-primary">Programa de Estudio</label>
                                <input autocomplete="off" type="text" class="form-control form-control-sm"
                                    value="{{ $Entity ? $Entity->especialidad : '' }}" id="especialidad"
                                    name="especialidad" placeholder="Programa de estudio" readonly required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="telefono" class="m-0 label-primary">Teléfono</label>
                                <input autocomplete="off" type="tel" class="form-control form-control-sm"
                                    value="{{ $Entity ? $Entity->tel : '' }}" id="tel" name="tel"
                                    placeholder="Teléfono">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="correo" class="m-0 label-primary">Correo Electrónico</label>
                                <input autocomplete="off" type="email" class="form-control form-control-sm"
                                    value="{{ $Entity ? $Entity->email : '' }}" id="email" name="email"
                                    placeholder="Correo Electrónico">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="sede" class="m-0 label-primary">Sede</label>
                                <input autocomplete="off" type="text" class="form-control form-control-sm"
                                    id="sede" value="{{ $Entity ? $Entity->sede : '' }}" name="sede"
                                    placeholder="Sede" readonly required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="sede" class="m-0 label-primary">Titulado</label>
                                <input autocomplete="off" type="text" class="form-control form-control-sm"
                                    id="estado" value="{{ $Entity ? $Entity->estado : '' }}" name="estado"
                                    placeholder="Titulado" readonly required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="sede" class="m-0 label-primary">Egresado</label>
                                <input autocomplete="off" type="text" class="form-control form-control-sm"
                                    id="tipo" value="{{ $Entity ? $Entity->tipo : '' }}" name="tipo"
                                    placeholder="Tipo" readonly required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="ciclo" class="m-0 label-primary">Ciclo</label>
                                <input autocomplete="off" type="text" class="form-control form-control-sm"
                                    id="ciclo" value="{{ $Entity ? $Entity->ciclo : '' }}" name="ciclo"
                                    placeholder="Ciclo" readonly required>
                            </div>
                            <div class="form-group col-lg-12">
                                <!-- Botón de Envío -->
                                <button type="submit" class="btn btn-primary "
                                    style="background-color:#2ecc71; border-color:#2ecc71; color:#fff;">
                                    <i class="fa fa-user-plus"></i> Editar Participante
                                </button>
                                <!-- Botón de Cancelar (opcional) -->
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                    style="background-color:#e74c3c; border-color:#e74c3c; color:#fff;">
                                    <i class="fa fa-times"></i> Cancelar
                                </button>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="{{ asset('auth/js/eventos/_EditarPart.js') }}"></script>
