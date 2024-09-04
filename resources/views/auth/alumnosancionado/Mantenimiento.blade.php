<div id="modalMantenimientoSancion" class="modal modal-fill fade" data-backdrop="false" tabindex="-1">
    <div class="modal-dialog modal-lg" style="width: 30% !important;">
        <form enctype="multipart/form-data" action="{{ route('auth.alumnosancionado.store') }}" id="registroSancion" method="POST"
            data-ajax="true" data-close-modal="true" data-ajax-loading="#loading"
            data-ajax-success="OnSuccessRegistroSancion" data-ajax-failure="OnFailureRegistroSancion">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ingresar Sanción</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="alumno_id" name="alumno_id" value="{{ $Entity != null ? $Entity->id : 0 }}">
                    <div class="form-group">
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label for="motivo" class="m-0 label-primary">Motivo <b
                                        style="color:red;font-size:10px">(Obligatorio*)</b></label>
                                <textarea class="form-control form-control-sm" id="motivo" name="motivo" rows="4" required
                                    placeholder="Ingrese Motivo de Sanción" style="resize: none; width: 100%; height: 100px;"></textarea>
                            </div>

                            
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit"
                        class="btn btn-bold btn-pure btn-primary">Registrar
                        Sanción</button>
                </div>
            </div>
        </form>
    </div>
</div>



<script type="text/javascript" src="{{ asset('auth/js/alumnosancionado/index.js') }}"></script>
