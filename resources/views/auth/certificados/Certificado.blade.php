<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>



<div id="barcodeModal" class="modal fade" style="background: #00000099 !important;" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #007bff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center" style="position: relative;">
                <img src="{{ asset('auth/image/certificadomaqueta.jpg') }}" alt=""
                    style="width: 100%; height: auto; position: absolute; top: 0; left: 0;">
            
                <!-- Contenido de texto en el modal -->
                <div style="position: relative; z-index: 2; margin-top: 20px;">
                    <h3 style="margin-top: 230px; font-size: 30px; font-weight: bold; font-style: italic; color: #292929; font-family: 'Times New Roman', Times, serif;">
                        {{ $Entity->nombres }} {{ $Entity->apellidos }}
                    </h3>
                    <!-- Mostrar el nombre del taller -->
                    {{-- @if($nombreTaller)
                    <p style="font-size: 12px; color: #292929; font-weight: bold; display: inline-block; vertical-align: middle; margin-right: 10px;">
                        En el taller de:
                    </p>
                    <h4 style="display: inline-block; font-size: 12px; color: #292929; font-weight: bold; vertical-align: middle;">
                        {{ $nombreTaller }}
                    </h4> --}}
                {{-- @endif                
                    @php
                    \Carbon\Carbon::setLocale('es'); 
                    $fecha = \Carbon\Carbon::parse($fechaTaller)->format('d \d\e F \d\e Y');
                @endphp --}}
                
                <!-- Mostrar la fecha del taller -->
                {{-- <p style="font-size: 10px; color: #292929; margin-top: 130px;">
                    Lima, {{ $fecha }} 
                </p> --}}
                
                </div>
            </div>
            
            <!-- Botón de descarga fuera del modal -->
            <div class="text-center" style="margin-top: 280px; margin-bottom: 10px;">
                <button id="downloadImage" class="btn btn-primary"
                    style="background-color: #ff5733; /* Color vibrante */
                           border: none; 
                           border-radius: 13px; 
                           color: white; 
                           font-size: 10px;
                           padding: 10px 30px;
                           transition: background-color 0.3s, transform 0.2s;"
                    onmouseover="this.style.backgroundColor='#c70039'; this.style.transform='scale(1.05)';"
                    onmouseout="this.style.backgroundColor='#ff5733'; this.style.transform='scale(1)';">
                    <i class="fa fa-download" style="margin-right: 8px;"></i> Descargar Certificado
                </button>
            </div>
        </div>
    </div>
</div>





<script>
    $('#downloadImage').on('click', function() {
        // Seleccionamos el contenedor que incluye tanto la imagen de fondo como el contenido del certificado
        html2canvas(document.querySelector('#barcodeModal .modal-body'), {
            scale: 2, // Mejora la calidad de la imagen
            useCORS: true, // Para manejar imágenes con CORS si es necesario
            backgroundColor: null, // No se agrega un fondo (si hay transparencia)
            scrollX: 0, // Aseguramos que no haya desplazamiento horizontal
            scrollY: 0, // Aseguramos que no haya desplazamiento vertical
            width: document.querySelector('#barcodeModal .modal-body')
            .scrollWidth, // Establecemos el tamaño del área a capturar
            height: document.querySelector('#barcodeModal .modal-body')
                .scrollHeight // Establecemos el tamaño del área a capturar
        }).then(canvas => {
            const link = document.createElement('a');

            // Usamos el nombre completo del empleado para el nombre del archivo de la imagen
            const fullName = "{{ $Entity->nombres }}_{{ $Entity->apellidos }}";

            // Convertimos el canvas a una imagen de tipo PNG y configuramos el nombre del archivo
            link.href = canvas.toDataURL('image/png');
            link.download = `certificado_${fullName}.png`;
            link.click();
        });
    });
</script>


<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
