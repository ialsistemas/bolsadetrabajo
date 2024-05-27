<div id="modalMantenimientoPostulante" class="modal modal-fill fade" data-backdrop="false" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Listado de Postulante</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id" name="id" value="{{ $id }}">
                <div class="row">
                    <div class="col-md-12">
                        <table id="tablePostulante" class="table table-bordered table-striped display nowrap margin-top-10 dataTable no-footer"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="{{ asset('app/js/avisos/_postulantes.min.js') }}"></script>
