<style>
    button {
      margin-left: 15px;
      background-color: #47a386;
      border: 0;
      border-radius: 3px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
      color: #fff;
      font-size: 14px;
      padding: 6px 20px;
    }
    .modal-container {
      display: flex;
      background-color: rgba(0, 0, 0, 0.3);
      align-items: center;
      justify-content: center;
      position: fixed;
      pointer-events: none;
      opacity: 0;  
      top: 0;
      left: 0;
      height: 100%;
      width: 100%; 
      transition: opacity 0.3s ease;
      z-index: 9999;
    }
    
    .show {
      pointer-events: auto;
      opacity: 1;
    }
    
    .modal1 {
      background-color: #fff;
      width: 600px;
      max-width: 100%;
      padding: 30px 50px;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
      text-align: center;
    }
    
    .modal1 h1 {
      margin: 0;
    }
    
    .modal1 p {
      opacity: 0.7;
      font-size: 14px;
    }
    
    </style>

    <div id="modalMantenimientoAviso" class="modal modal-fill fade" data-backdrop="false" tabindex="-1">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modificar Aviso</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form enctype="multipart/form-data" action="{{ route('auth.aviso.update') }}" id="" method="POST" data-ajax="true" data-close-modal="true" data-ajax-loading="#loading" data-ajax-success="OnSuccessRegistroAviso" data-ajax-failure="OnFailureRegistroAviso">
                    <div class="modal-content">
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" id="id" name="id" value="{{ $aviso->id }}">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input type="text" name="titulo" id="titulo" class="form-input" value="{{ $aviso != null ? $aviso->titulo : "" }}" placeholder="Titulo de oportunidad" required>
                                    @error('titulo')
                                        <span>Este campo debe estar completo</span>
                                    @enderror
                                    
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <select name="distrito_id" id="distrito_id" class="form-input" required="">
                                        <option value="">Lugar de Trabajo (Distrito)</option>
                                        @foreach($distrito as $q)
                                            <option value="{{ $q->id }}" {{ $aviso != null && $aviso->distrito_id == $q->id ? "selected" : "" }}>{{ $q->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <span data-valmsg-for="distrito_id"></span>
                                </div>
                                <div class="col-md-6">
                                    <input type="number" name="vacantes" id="vacantes" class="form-input" placeholder="Cantidad de Vacantes" value="{{ $aviso->vacantes }}" required="">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <select name="solicita_carrera" id="" class="form-input" required="">
                                        <option value="" hidden="">Carrera que Solicita</option>
                                        @foreach($areas as $q)
                                            <option value="{{ $q->id }}" {{ $aviso != null && $aviso->solicita_carrera == $q->id ? "selected" : "" }}>{{ $q->nombre }}</option>
                                        @endforeach
                                </select>
                                </div>
                                <div class="col-md-6">
                                    <select name="solicita_grado_a" id="solicita_grado_a" class="form-input" required="">
                                        <option value="" hidden="">Grado Académico que solicita</option>
                                        @foreach($grado as $q)
                                            <option value="{{ $q->id }}" {{ $aviso != null && $aviso->solicita_grado_a == $q->id ? "selected" : "" }}>{{ $q->grado_estado }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
        
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <input type="text" name="periodo_vigencia" id="periodo_vigencia" class="form-input" value="{{ $aviso != null ? $aviso->periodo_vigencia : ""  }}" placeholder="Periodo de vigencia (Hasta cuando se aceptan postulaciones)" onfocus="(this.type='date')" onblur="(this.type='text')" required="">
                                </div>
                                
                                <div class="col-md-6">
                                    <select name="ciclo_cursa" id="ciclo_cursa" class="form-input" required="required" style="">
                                        <option hidden class="option_data" value="{{ $aviso != null ? $aviso->ciclo_cursa : "" }}">{{ $aviso != null ? $aviso->ciclo_cursa : "" }}</option>
                                        <option value="I">I</option>
                                        <option value="II">II</option>
                                        <option value="III">III</option>
                                        <option value="IV">IV</option>
                                        <option value="V">V</option>
                                        <option value="VI">VI</option>
                                    </select>
                                </div>
                            </div>
        
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <textarea name="descripcion" id="descripcion" class="form-input" cols="30" rows="10" placeholder="Descripción" required>{{$aviso->descripcion}}</textarea>
                                    <span data-valmsg-for="descripcion"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6"></div>
                                <div class="col-md-6">
                                    <input type="text" name="salario" id="salario" value="{{ $aviso != null ? $aviso->salario : "" }}" class="form-input" placeholder="Salario" required="">
                                    <span data-valmsg-for="salario"></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-bold btn-pure btn-primary">Modificar Oportunidad</button>
                        </div>
                    </div>
                </form>
            </div>
    
        </div>
    </div>
    
    
<script type="text/javascript" src="{{ asset('app/plugins/ckeditor/ckeditor.js') }}"></script>
<script>
    CKEDITOR.replace( 'descripcion' );
</script>
<script>
    $(function(){
        $(".modal-footer button").on('click', function (e){
            for (var instanceName in CKEDITOR.instances) {
                CKEDITOR.instances[instanceName].updateElement();
            }
        });
    })
</script>
<script type="text/javascript" src="{{ asset('auth/js/aviso/_Editar.js') }}"></script>
    
    