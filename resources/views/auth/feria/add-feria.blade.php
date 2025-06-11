<form action="{{ route('auth.store-agregar-feria') }}" id="formAgregarFeria" method="POST">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Agregar Feria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <!-- Aquí el formulario completo -->
        <div class="form-group">
            <label for="name">Nombre de la Feria:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        @php $today = date('Y-m-d\TH:i'); @endphp

        <div class="form-group">
            <label for="startDate">Fecha Inicio:</label>
            <input type="datetime-local" class="form-control" name="startDate" min="{{ $today }}" required>
        </div>
        <div class="form-group">
            <label for="endDate">Fecha Final:</label>
            <input type="datetime-local" class="form-control" name="endDate" min="{{ $today }}" required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-info">Agregar</button>
    </div>
</form>
