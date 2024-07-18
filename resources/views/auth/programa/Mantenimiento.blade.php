<div id="modalMantenimientoPrograma" class="modal modal-fill fade" data-backdrop="false" tabindex="-1">
    <div class="modal-dialog modal-md">
        <form enctype="multipart/form-data" action="{{ route('auth.programa.updateData') }}" id="registroPrograma"
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
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                    <label for="registro" class="m-0 label-primary">Fecha</label>
                                    <input type="date" class="form-control form-control-sm" min="<?php echo date('Y-m-d'); ?>" id="registro"
                                        name="registro" value="{{ $Entity != null ? $Entity->registro : '' }}" required>
                            </div>
                            <div class="col-md-4">
                                <input type="hidden" name="id" value="{{ $Entity != null ? $Entity->id : '' }}"
                                    required>
                                <label for="">Empresa</label>
                                <input type="text" class="form-input" name="empresa"
                                    value="{{ $Entity != null ? $Entity->empresa : '' }}" autocomplete="off" required>
                            </div>
                            <div class="col-md-4">
                                <label for="">Programa</label>
                                <select name="tipo_programa" id="tipo_programa" class="form-input" required>
                                    <option value="" hidden>-- Seleccione --</option>
                                    <option value="Bolsa de Trabajo"
                                        {{ old('tipo_programa', isset($Entity) ? $Entity->tipo_programa : '') == 'Bolsa de Trabajo' ? 'selected' : '' }}>
                                        Bolsa de Trabajo</option>
                                    <option value="Talent Day"
                                        {{ old('tipo_programa', isset($Entity) ? $Entity->tipo_programa : '') == 'Talent Day' ? 'selected' : '' }}>
                                        Talent Day</option>
                                    <option value="Nexo Laboral"
                                        {{ old('tipo_programa', isset($Entity) ? $Entity->tipo_programa : '') == 'Nexo Laboral' ? 'selected' : '' }}>
                                        Nexo Laboral</option>
                                    <option value="Contrata Talento"
                                        {{ old('tipo_programa', isset($Entity) ? $Entity->tipo_programa : '') == 'Contrata Talento' ? 'selected' : '' }}>
                                        Contrata Talento</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">Puesto 1</label>
                                <input type="text" class="form-input" name="puestouno"
                                    value="{{ $Entity != null ? $Entity->puestouno : '' }}" autocomplete="off">
                            </div>
                            <div class="col-md-4">
                                <label for="">Puesto 2</label>
                                <input type="text" class="form-input" name="puestodos"
                                    value="{{ $Entity != null ? $Entity->puestodos : '' }}" autocomplete="off">
                            </div>
                            <div class="col-md-4">
                                <label for="">Puesto 3</label>
                                <input type="text" class="form-input" name="puestotres"
                                    value="{{ $Entity != null ? $Entity->puestotres : '' }}" autocomplete="off">
                            </div>
                            <div class="col-md-4">
                                <label for="">Puesto 4</label>
                                <input type="text" class="form-input" name="puestocuatro"
                                    value="{{ $Entity != null ? $Entity->puestocuatro : '' }}" autocomplete="off">
                            </div>
                            <div class="col-md-4">
                                <label for="">Responsable</label>
                                <select name="responsable" id="responsable" class="form-input" required>
                                    <option value="" hidden>-- Seleccione --</option>
                                    <option value="Bryan Julcamoro"
                                        {{ old('responsable', isset($Entity) ? $Entity->responsable : '') == 'Bryan Julcamoro' ? 'selected' : '' }}>
                                        Bryan Julcamoro</option>
                                    <option value="Joselyn Condori"
                                        {{ old('responsable', isset($Entity) ? $Entity->responsable : '') == 'Joselyn Condori' ? 'selected' : '' }}>
                                        Joselyn Condori</option>
                                    <option value="Setafani Carlos"
                                        {{ old('responsable', isset($Entity) ? $Entity->responsable : '') == 'Setafani Carlos' ? 'selected' : '' }}>
                                        Setafani Carlos</option>
                                    <option value="Stefany Gutierrez"
                                        {{ old('responsable', isset($Entity) ? $Entity->responsable : '') == 'Stefany Gutierrez' ? 'selected' : '' }}>
                                        Stefany Gutierrez</option>
                                    <option value="Yessica Caceres"
                                        {{ old('responsable', isset($Entity) ? $Entity->responsable : '') == 'Yessica Caceres' ? 'selected' : '' }}>
                                        Yessica Caceres</option>
                                    <option value="Yamile Bazan"
                                        {{ old('responsable', isset($Entity) ? $Entity->responsable : '') == 'Yamile Bazan"' ? 'selected' : '' }}>
                                        Yamile Bazan"</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="">Cantidad Postulantes</label>
                                <input type="number" class="form-input" name="postulantes"
                                    value="{{ $Entity != null ? $Entity->postulantes : '' }}" autocomplete="off">
                            </div>
                            <div class="col-md-4">
                                <label for="">Cantidad Evaluando</label>
                                <input type="number" class="form-input" name="evaluando"
                                    value="{{ $Entity != null ? $Entity->evaluando : '' }}" autocomplete="off">
                            </div>
                            <div class="col-md-4">
                                <label for="">Cantidad Contratados</label>
                                <input type="number" class="form-input" name="contratados"
                                    value="{{ $Entity != null ? $Entity->contratados : '' }}" autocomplete="off">
                            </div>
                            <div class="col-md-4">
                                <label for="">Cantidad Descartados</label>
                                <input type="number" class="form-input" name="descartado"
                                    value="{{ $Entity != null ? $Entity->descartado : '' }}" autocomplete="off">
                            </div>

                        </div>
                    </div>
                    {{-- <div class="row">
                        <h3 class="col-lg-12" style="text-align: center">Datos del <span
                                style="color: #0072bf">Estudiante</span></h3>
                        <div class="col-md-4">
                            <label for="">Dni</label>
                            <input type="text" class="form-control form-control-sm" name="dni"
                                value="{{ $Entity != null ? $Entity->dni : '' }}" autocomplete="off" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="">Nombres</label>
                            <input type="text" class="form-control form-control-sm" name="nombres"
                                value="{{ $Entity != null ? $Entity->nombres : '' }}" autocomplete="off" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="">Apellidos</label>
                            <input type="text" class="form-control form-control-sm" name="apellidos"
                                value="{{ $Entity != null ? $Entity->apellidos : '' }}" autocomplete="off" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="">Email</label>
                            <input type="text" class="form-control form-control-sm" name="email"
                                value="{{ $Entity != null ? $Entity->email : '' }}" autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <label for="">Teléfono</label>
                            <input type="text" class="form-control form-control-sm" name="tel"
                                value="{{ $Entity != null ? $Entity->tel : '' }}" autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <label for="">Estado</label>
                            <select name="estado" id="estado" class="form-input" required>
                                <option value="" hidden>-- Seleccione --</option>
                                <option value="Postulante"
                                    {{ old('estado', isset($Entity) ? $Entity->estado : '') == 'Postulante' ? 'selected' : '' }}>
                                    Postulante</option>
                                <option value="Talent Day"
                                    {{ old('estado', isset($Entity) ? $Entity->estado : '') == 'Evaluando' ? 'selected' : '' }}>
                                    Evaluando</option>
                                <option value="Contratado"
                                    {{ old('estado', isset($Entity) ? $Entity->estado : '') == 'Contratado' ? 'selected' : '' }}>
                                    Contratado</option>
                                <option value="Descartado"
                                    {{ old('estado', isset($Entity) ? $Entity->estado : '') == 'Descartado' ? 'selected' : '' }}>
                                    Descartado</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">Tipo</label>
                            <select name="tipo" id="tipo" class="form-input" required>
                                <option value="" hidden>-- Seleccione --</option>
                                <option value="Estudiante"
                                    {{ old('tipo', isset($Entity) ? $Entity->tipo : '') == 'Estudiante' ? 'selected' : '' }}>
                                    Estudiante</option>
                                <option value="Egresado"
                                    {{ old('tipo', isset($Entity) ? $Entity->tipo : '') == 'Egresado' ? 'selected' : '' }}>
                                    Egresado</option>
                                <option value="Titulado"
                                    {{ old('tipo', isset($Entity) ? $Entity->tipo : '') == 'Titulado' ? 'selected' : '' }}>
                                    Titulado</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="sede">Sede</label>
                            <select name="sede" id="sede" class="form-control form-control-sm" required>
                                <option value="">Seleccione</option>
                                <option value="AREQUIPA 09 - CERCADO DE LIMA"
                                    {{ old('sede', isset($Entity) ? $Entity->sede : '') == 'AREQUIPA 09 - CERCADO DE LIMA' ? 'selected' : '' }}>
                                    AREQUIPA 09 - CERCADO DE LIMA
                                </option>
                                <option value="AREQUIPA 14 - CERCADO DE LIMA"
                                    {{ old('sede', isset($Entity) ? $Entity->sede : '') == 'AREQUIPA 14 - CERCADO DE LIMA' ? 'selected' : '' }}>
                                    AREQUIPA 14 - CERCADO DE LIMA
                                </option>
                                <option value="ATE 01 (NICOLAS AYLLON 831)"
                                    {{ old('sede', isset($Entity) ? $Entity->sede : '') == 'ATE 01 (NICOLAS AYLLON 831)' ? 'selected' : '' }}>
                                    ATE 01 (NICOLAS AYLLON 831)
                                </option>
                                <option value="BELISARIO - SAN JUAN DE MIRAFLORES"
                                    {{ old('sede', isset($Entity) ? $Entity->sede : '') == 'BELISARIO - SAN JUAN DE MIRAFLORES' ? 'selected' : '' }}>
                                    BELISARIO - SAN JUAN DE MIRAFLORES
                                </option>
                                <option value="BILLINGHURST - SAN JUAN DE MIRAFLORES"
                                    {{ old('sede', isset($Entity) ? $Entity->sede : '') == 'BILLINGHURST - SAN JUAN DE MIRAFLORES' ? 'selected' : '' }}>
                                    BILLINGHURST - SAN JUAN DE MIRAFLORES
                                </option>
                                <option value="CHOTA - CERCADO DE LIMA"
                                    {{ old('sede', isset($Entity) ? $Entity->sede : '') == 'CHOTA - CERCADO DE LIMA' ? 'selected' : '' }}>
                                    CHOTA - CERCADO DE LIMA
                                </option>
                                <option value="CENTRAL - CERCADO DE LIMA"
                                    {{ old('sede', isset($Entity) ? $Entity->sede : '') == 'CENTRAL - CERCADO DE LIMA' ? 'selected' : '' }}>
                                    CENTRAL - CERCADO DE LIMA
                                </option>
                                <option value="CLÍNICA - CERCADO DE LIMA"
                                    {{ old('sede', isset($Entity) ? $Entity->sede : '') == 'CLÍNICA - CERCADO DE LIMA' ? 'selected' : '' }}>
                                    CLÍNICA - CERCADO DE LIMA
                                </option>
                                <option value="ELEKTRA - FUENTE PIEDRA"
                                    {{ old('sede', isset($Entity) ? $Entity->sede : '') == 'ELEKTRA - FUENTE PIEDRA' ? 'selected' : '' }}>
                                    ELEKTRA - FUENTE PIEDRA
                                </option>
                                <option value="HORACIO ZEVALLOS"
                                    {{ old('sede', isset($Entity) ? $Entity->sede : '') == 'HORACIO ZEVALLOS' ? 'selected' : '' }}>
                                    HORACIO ZEVALLOS
                                </option>
                                <option value="LOS CHINOS - SAN JUAN DE MIRAFLORES"
                                    {{ old('sede', isset($Entity) ? $Entity->sede : '') == 'LOS CHINOS - SAN JUAN DE MIRAFLORES' ? 'selected' : '' }}>
                                    LOS CHINOS - SAN JUAN DE MIRAFLORES
                                </option>
                                <option value="MENDIOLA - LOS OLIVOS"
                                    {{ old('sede', isset($Entity) ? $Entity->sede : '') == 'MENDIOLA - LOS OLIVOS' ? 'selected' : '' }}>
                                    MENDIOLA - LOS OLIVOS
                                </option>
                                <option value="MIGUEL IGLESIAS - SAN JUAN DE MIRAFLORES"
                                    {{ old('sede') == 'MIGUEL IGLESIAS - SAN JUAN DE MIRAFLORES' ? 'selected' : '' }}>
                                    MIGUEL IGLESIAS - SAN JUAN DE MIRAFLORES
                                </option>
                                <option value="PTE PIEDRA 2"
                                    {{ old('sede', isset($Entity) ? $Entity->sede : '') == 'PTE PIEDRA 2' ? 'selected' : '' }}>
                                    PTE PIEDRA 2
                                </option>
                                <option value="SJL 10 - SAN JUAN DE LURIGANCHO"
                                    {{ old('sede', isset($Entity) ? $Entity->sede : '') == 'SJL 10 - SAN JUAN DE LURIGANCHO' ? 'selected' : '' }}>
                                    SJL 10 - SAN JUAN DE LURIGANCHO
                                </option>
                                <option value="SJL CDRA 22 - SAN JUAN DE LURIGANCHO"
                                    {{ old('sede', isset($Entity) ? $Entity->sede : '') == 'SJL CDRA 22 - SAN JUAN DE LURIGANCHO' ? 'selected' : '' }}>
                                    SJL CDRA 22 - SAN JUAN DE LURIGANCHO
                                </option>
                                <option value="SJL 50 - SAN JUAN DE LURIGANCHO"
                                    {{ old('sede', isset($Entity) ? $Entity->sede : '') =='SJL 50 - SAN JUAN DE LURIGANCHO' ? 'selected' : '' }}>
                                    SJL 50 - SAN JUAN DE LURIGANCHO
                                </option>
                                <option value="SALAVERRY - LOS OLIVOS"
                                    {{ old('sede', isset($Entity) ? $Entity->sede : '') == 'SALAVERRY - LOS OLIVOS' ? 'selected' : '' }}>
                                    SALAVERRY - LOS OLIVOS
                                </option>
                                <option value="SAN LÁZARO - INDEPENDENCIA"
                                    {{ old('sede', isset($Entity) ? $Entity->sede : '') == 'SAN LÁZARO - INDEPENDENCIA' ? 'selected' : '' }}>
                                    SAN LÁZARO - INDEPENDENCIA
                                </option>
                                <option value="VILLA EL SALVADOR"
                                    {{ old('sede', isset($Entity) ? $Entity->sede : '') =='VILLA EL SALVADOR' ? 'selected' : '' }}>
                                    VILLA EL SALVADOR
                                </option>
                                <option value="VISTA ALEGRE" {{ old('sede', isset($Entity) ? $Entity->sede : '') == 'VISTA ALEGRE' ? 'selected' : '' }}>
                                    VISTA ALEGRE
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <button tyoe="submit" class="btn btn-primary" style="margin-top:28px;border-color:#2ecc71!important;">Actualizar Programa</button>
                                </div>
                            </div>
                        </div>


                    </div> --}}
                    {{--  --}}

                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="{{ asset('auth/js/programa/_Editar.js') }}"></script>
