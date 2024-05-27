<div id="modalModificarEstado" class="modal modal-fill fade" data-backdrop="false" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Estado</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" action="{{ route('auth.aviso.updateEstado') }}" id="" method="POST" data-ajax="true" data-close-modal="true" data-ajax-loading="#loading" data-ajax-success="OnSuccessRegistroAviso" data-ajax-failure="OnFailureRegistroAviso">
                    @csrf
                    <input type="hidden" id="idalumno" name="idalumno" value="{{ $idalumno }}">
                    <input type="hidden" id="idaviso" name="idaviso" value="{{ $idaviso }}">
                    <div class="form-group row">
                        <div class="col-md-12 mt-2">
                            <select class="form-input" name="idestado" id="idestado">
                                @foreach($estado as $q)
                                <option value="{{ $q->id }}" {{ $alumno_avisos != null && $alumno_avisos[0]->estado_id == $q->id ? "selected" : "" }}>{{ $q->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="">
                        <button type="submit" class="btn-primary col-md-12" style="margin-left:0px !important;">Modificar</button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>
    
<script>
    var OnSuccessRegistroAviso, OnFailureRegistroAviso;
    $(function(){
        const $modal = $("#modalModificarEstado"), $form = $("form#registroAviso");
        OnSuccessRegistroAviso = (data) => onSuccessForm(data, $form, $modal);
        OnFailureRegistroAviso = () => onFailureForm();
    });
</script>
    