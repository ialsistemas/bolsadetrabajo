<div id="modalMantenimientoParticipantes" class="modal modal-fill fade" data-backdrop="false" tabindex="-1">
    <div class="modal-dialog modal-md">
        <form enctype="multipart/form-data" action="{{ route('auth.programa.storeParticipantes') }}"
            id="registroParticipantes" method="POST" data-ajax="true" data-close-modal="true" data-ajax-loading="#loading"
            data-ajax-success="OnSuccessRegistroParticipantes" data-ajax-failure="OnFailureRegistroParticipantes">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Participantes Asistencia</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <input type="hidden" name="id_evento" class="id_evento" value="{{ $Entity->id }}" required>
                <div class="modal-body">
                    <div>
                        
                        <div class="col-lg-12 col-md-12">
                            <div class="table-wrapper">
                                <table id="tableAsistentes"
                                    class="display table table-bordered table-hover table-condensed">
                                    <thead>
                                        {{-- Contenido de JS --}}
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
<script type="text/javascript" src="{{ asset('auth/js/eventos/_Asistentes.js') }}"></script>
