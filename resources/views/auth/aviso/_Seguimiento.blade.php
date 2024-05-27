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
    
    
    <div id="modalMantenimientoPostulante" class="modal modal-fill fade" data-backdrop="false" tabindex="-1">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cuadro de Seguimientos a la Intermediación Realizada</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            
                <div class="modal-body">
                    <input type="hidden" id="id" name="id" value="{{ $id }}">
                    <button id="open">
                        Registrar
                    </button>
                    <div id="modal_container" class="modal-container">
                        <div class="modal1">
                          <h4 class="mb-5">Registrar Seguimiento</h4>
                        <form action="{{ route('auth.aviso.store_seguimiento') }}" method="post">
                            @csrf
                            <div class="form-group row">
                                <input type="hidden" id="id_estudiante_aviso" name="id_aviso_s" value="{{ $id }}">
                                <div class="col-md-12 mt-2">
                                    <input type="text" autocomplete="off" class="form-input" name="fecha_envio" placeholder="Fecha del Envio de Postulante" required>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <input type="text" autocomplete="off" class="form-control" name="fecha_seguimiento" placeholder="Fecha de Seguimiento" required>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <textarea name="comentario" class="form-input" placeholder="Comentario" cols="30" rows="2"></textarea>
                                </div>
                            </div>     
                            <div class="form-group row">
                                <a href="javascript:void(0)" id="close" class="btn btn-secondary">Cerrar</a>
                                <button type="submit" class="btn btn-success mx-5">Registrar</button>
                            </div>                   
                        </form>
                          
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col-md-12">
                            <table id="tableSeguimientosInter" class="table table-bordered table-striped display nowrap margin-top-10 dataTable no-footer"></table>
                        </div>
                    </div>
                </div>
            </div>
    
        </div>
    </div>
    
    
    <script type="text/javascript" src="{{ asset('auth/js/aviso/_postulantes.js') }}"></script>
    
    