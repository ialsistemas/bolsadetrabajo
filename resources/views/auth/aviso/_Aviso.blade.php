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
                    <h5 class="modal-title">Aviso</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card-body p-5">
                                <h5>{{ $aviso[0]->titulo }}</h5>
                                <p>@php echo $aviso[0]->descripcion @endphp</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-body">
                                <h5 style="font-size: 1rem; !important;font-weight: 600">{{ $aviso[0]->nombre_empresa }}</h5>
                                <p>Públicado: {{ $aviso[0]->publicado }}</p>
                                <p>{{ $aviso[0]->distrito }}</p>
                                
                                <p>{{ $aviso[0]->area }}</p>
                                <p>{{ $aviso[0]->salario }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
        </div>
    </div>
    
    
    
{{--     <script type="text/javascript" src="{{ asset('auth/js/aviso/_postulantes.js') }}"></script> --}}
    
    