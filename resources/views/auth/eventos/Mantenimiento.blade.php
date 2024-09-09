<div id="modalMantenimientoEventos" class="modal modal-fill fade" data-backdrop="false" tabindex="-1">
    <div class="modal-dialog modal-lg" style="width: 30% !important;">
        <form enctype="multipart/form-data" action="{{ route('auth.eventos.update') }}" id="EditEventos" method="POST"
            data-ajax="true" data-close-modal="true" data-ajax-loading="#loading"
            data-ajax-success="OnSuccessRegistroEventos" data-ajax-failure="OnFailureRegistroEventos">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $Entity != null ? 'Modificar' : ' Registrar' }} Evento</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="id" name="id" value="{{ $Entity != null ? $Entity->id : 0 }}">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="fecha_registro" class="m-0 label-primary">Fecha</label>
                                <input type="date" class="form-control form-control-sm" id="fecha_registro"
                                    name="fecha_registro" value="{{ $Entity ? $Entity->fecha_registro : '' }}" required>
                            </div>

                            <div class="col-md-12">
                                <label for="nombre" class="m-0 label-primary">Nombre de Evento</label>
                                <input type="text" class="form-input" name="nombre"
                                    value="{{ $Entity ? $Entity->nombre : '' }}" id="nombre" autocomplete="off"
                                    required>
                                <span data-valmsg-for="nombre" class="text-danger"></span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-bold btn-pure btn-primary"><i class="fa fa-calendar mr-5"></i>
                        {{ $Entity != null ? 'Modificar' : ' Registrar' }} Evento</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="{{ asset('auth/js/eventos/_Mantenimiento.js') }}"></script>
