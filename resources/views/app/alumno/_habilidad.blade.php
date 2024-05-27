<link rel="stylesheet" href="{{ asset('auth/plugins/select2/css/select2.min.css') }}">

<div id="modalMantenimientoHabilidad" class="modal modal-fill fade" data-backdrop="false" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form enctype="multipart/form-data" action="{{ route('alumno.perfil.habilidad_store') }}" id="registroHabilidad" method="POST"
              data-ajax="true" data-close-modal="true" data-ajax-loading="#loading" data-ajax-success="OnSuccessRegistroHabilidad" data-ajax-failure="OnFailureRegistroHabilidad">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{  count($alumnoHabilidad) > 0 != null ? "Modificar" : " Registrar" }} Cursos, Talleres</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="tipo" id="tipo" value="{{$tipo}}">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="habilidades">Habilidades</label>
                                <select name="habilidades[]" class="form-input" id="habilidades" data-initial="{{ (count($alumnoHabilidad) > 0 ) ?  implode(",", $alumnoHabilidad)  : "" }}" multiple="multiple" required>
                                    @foreach($habilidades as $q)
                                        <option value="{{ $q->id }}">{{ $q->nombre }}</option>
                                    @endforeach
                                </select>
                                <span data-valmsg-for="habilidades"></span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-bold btn-pure btn-primary">{{ count($alumnoHabilidad) > 0 ? "Modificar" : " Registrar" }} Cursos, Talleres</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="{{ asset('auth/plugins/select2/js/select2.js') }}"></script>
<script type="text/javascript" src="{{ asset('app/js/alumno/_habilidad.min.js') }}"></script>

