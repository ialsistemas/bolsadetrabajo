<form action="{{ route('auth.store-editar-feria') }}" method="POST" id="formEditarFeria">
    @csrf
    <input type="hidden" name="idFeria" value="{{ $feriaData->id }}">
    <div class="modal-header">
        <h5 class="modal-title">Editar Feria</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="name">Nombre de la Feria:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $feriaData->name }}" required>
        </div>

        @php $today = date('Y-m-d'); @endphp

        <div class="form-group">
            <label for="startDate">Fecha Inicio de la Feria:</label>
            <input type="datetime-local" class="form-control" id="startDate" name="startDate" min="{{ $today }}" value="{{ \Carbon\Carbon::parse($feriaData->fecha_inicio)->format('Y-m-d\TH:i') }}" required>
        </div>

        <div class="form-group">
            <label for="endDate">Fecha Final de la Feria:</label>
            <input type="datetime-local" class="form-control" id="endDate" name="endDate" min="{{ $today }}" value="{{ \Carbon\Carbon::parse($feriaData->fecha_final)->format('Y-m-d\TH:i') }}" required>
        </div>

        @if(session('error'))
            <div id="alert-error" class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
            </div>
        @endif
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-info">Guardar Cambios</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
    </div>
</form>