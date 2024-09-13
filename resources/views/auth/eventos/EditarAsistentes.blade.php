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
                            <div class="form-group col-lg-6">
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
                            </div>

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
                                <input autocomplete="off" type="text" class="form-control form-control-sm" id="sede"
                                    value="{{ $Entity ? $Entity->sede : '' }}" name="sede" placeholder="Sede" readonly required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="sede" class="m-0 label-primary">Titulado</label>
                                <input autocomplete="off" type="text" class="form-control form-control-sm" id="estado"
                                    value="{{ $Entity ? $Entity->estado : '' }}" name="estado" placeholder="Titulado" readonly required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="sede" class="m-0 label-primary">Egresado</label>
                                <input autocomplete="off" type="text" class="form-control form-control-sm" id="tipo"
                                    value="{{ $Entity ? $Entity->tipo : '' }}" name="tipo" placeholder="Tipo" readonly required>
                            </div>
                            
                            {{-- <div class="form-group col-lg-6">
                                <label for="tipo" class="m-0 label-primary">Tipo <b
                                        style="color:red;font-size:10px">(Obligatorio*)</b></label>
                                <select name="tipo" id="tipo" class="form-control form-control-sm" required>
                                    <option value="">Seleccione</option>
                                    <option value="Estudiante"
                                        {{ old('tipo', $Entity->tipo) == 'Estudiante' ? 'selected' : '' }}>
                                        Estudiante
                                    </option>
                                    <option value="Egresado"
                                        {{ old('tipo', $Entity->tipo) == 'Egresado' ? 'selected' : '' }}>
                                        Egresado
                                    </option>
                                    <option value="Titulado"
                                        {{ old('tipo', $Entity->tipo) == 'Titulado' ? 'selected' : '' }}>
                                        Titulado
                                    </option>
                                </select>
                            </div> --}}


                            {{-- <div class="form-group col-lg-6">
                                <label for="sede" class="m-0 label-primary">Sede <b
                                        style="color:red;font-size:10px">(Obligatorio*)</b></label>
                                <select name="sede" id="sede" class="form-control form-control-sm" required>
                                    <option value="">Seleccione</option>
                                    <option value="AREQUIPA 09 - CERCADO DE LIMA"
                                        {{ old('sede', $Entity->sede) == 'AREQUIPA 09 - CERCADO DE LIMA' ? 'selected' : '' }}>
                                        AREQUIPA 09 - CERCADO DE LIMA
                                    </option>
                                    <option value="AREQUIPA 14 - CERCADO DE LIMA"
                                        {{old('sede', $Entity->sede) == 'AREQUIPA 14 - CERCADO DE LIMA' ? 'selected' : '' }}>
                                        AREQUIPA 14 - CERCADO DE LIMA
                                    </option>
                                    <option value="ATE 01 (NICOLAS AYLLON 831)"
                                        {{ old('sede', $Entity->sede) == 'ATE 01 (NICOLAS AYLLON 831)' ? 'selected' : '' }}>
                                        ATE 01 (NICOLAS AYLLON 831)
                                    </option>
                                    <option value="BELISARIO - SAN JUAN DE MIRAFLORES"
                                        {{ old('sede', $Entity->sede) == 'BELISARIO - SAN JUAN DE MIRAFLORES' ? 'selected' : '' }}>
                                        BELISARIO - SAN JUAN DE MIRAFLORES
                                    </option>
                                    <option value="BILLINGHURST - SAN JUAN DE MIRAFLORES"
                                        {{ old('sede', $Entity->sede) == 'BILLINGHURST - SAN JUAN DE MIRAFLORES' ? 'selected' : '' }}>
                                        BILLINGHURST - SAN JUAN DE MIRAFLORES
                                    </option>
                                    <option value="CHOTA - CERCADO DE LIMA"
                                        {{ old('sede', $Entity->sede) == 'CHOTA - CERCADO DE LIMA' ? 'selected' : '' }}>
                                        CHOTA - CERCADO DE LIMA
                                    </option>
                                    <option value="CENTRAL - CERCADO DE LIMA"
                                        {{ old('sede', $Entity->sede) == 'CENTRAL - CERCADO DE LIMA' ? 'selected' : '' }}>
                                        CENTRAL - CERCADO DE LIMA
                                    </option>
                                    <option value="CLÍNICA - CERCADO DE LIMA"
                                        {{ old('sede', $Entity->sede) == 'CLÍNICA - CERCADO DE LIMA' ? 'selected' : '' }}>
                                        CLÍNICA - CERCADO DE LIMA
                                    </option>
                                    <option value="ELEKTRA - FUENTE PIEDRA"
                                        {{ old('sede', $Entity->sede) == 'ELEKTRA - FUENTE PIEDRA' ? 'selected' : '' }}>
                                        ELEKTRA - FUENTE PIEDRA
                                    </option>
                                    <option value="HORACIO ZEVALLOS"
                                        {{ old('sede', $Entity->sede) == 'HORACIO ZEVALLOS' ? 'selected' : '' }}>
                                        HORACIO ZEVALLOS
                                    </option>
                                    <option value="LOS CHINOS - SAN JUAN DE MIRAFLORES"
                                        {{ old('sede', $Entity->sede) == 'LOS CHINOS - SAN JUAN DE MIRAFLORES' ? 'selected' : '' }}>
                                        LOS CHINOS - SAN JUAN DE MIRAFLORES
                                    </option>
                                    <option value="MENDIOLA - LOS OLIVOS"
                                        {{ old('sede', $Entity->sede) == 'MENDIOLA - LOS OLIVOS' ? 'selected' : '' }}>
                                        MENDIOLA - LOS OLIVOS
                                    </option>
                                    <option value="MIGUEL IGLESIAS - SAN JUAN DE MIRAFLORES"
                                        {{ old('sede', $Entity->sede) == 'MIGUEL IGLESIAS - SAN JUAN DE MIRAFLORES' ? 'selected' : '' }}>
                                        MIGUEL IGLESIAS - SAN JUAN DE MIRAFLORES
                                    </option>
                                    <option value="PTE PIEDRA 2"
                                        {{ old('sede', $Entity->sede) == 'PTE PIEDRA 2' ? 'selected' : '' }}>
                                        PTE PIEDRA 2
                                    </option>
                                    <option value="SJL 10 - SAN JUAN DE LURIGANCHO"
                                        {{ old('sede', $Entity->sede) == 'SJL 10 - SAN JUAN DE LURIGANCHO' ? 'selected' : '' }}>
                                        SJL 10 - SAN JUAN DE LURIGANCHO
                                    </option>
                                    <option value="SJL CDRA 22 - SAN JUAN DE LURIGANCHO"
                                        {{ old('sede', $Entity->sede) == 'SJL CDRA 22 - SAN JUAN DE LURIGANCHO' ? 'selected' : '' }}>
                                        SJL CDRA 22 - SAN JUAN DE LURIGANCHO
                                    </option>
                                    <option value="SJL 50 - SAN JUAN DE LURIGANCHO"
                                        {{ old('sede', $Entity->sede) == 'SJL 50 - SAN JUAN DE LURIGANCHO' ? 'selected' : '' }}>
                                        SJL 50 - SAN JUAN DE LURIGANCHO
                                    </option>
                                    <option value="SALAVERRY - LOS OLIVOS"
                                        {{ old('sede', $Entity->sede) == 'SALAVERRY - LOS OLIVOS' ? 'selected' : '' }}>
                                        SALAVERRY - LOS OLIVOS
                                    </option>
                                    <option value="SAN LÁZARO - INDEPENDENCIA"
                                        {{ old('sede', $Entity->sede) == 'SAN LÁZARO - INDEPENDENCIA' ? 'selected' : '' }}>
                                        SAN LÁZARO - INDEPENDENCIA
                                    </option>
                                    <option value="VILLA EL SALVADOR"
                                        {{ old('sede', $Entity->sede) == 'VILLA EL SALVADOR' ? 'selected' : '' }}>
                                        VILLA EL SALVADOR
                                    </option>
                                    <option value="VISTA ALEGRE"
                                        {{ old('sede', $Entity->sede) == 'VISTA ALEGRE' ? 'selected' : '' }}>
                                        VISTA ALEGRE
                                    </option>
                                </select>
                            </div> --}}
                            <style>

                            </style>
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
