$(document).ready(function () {
    const $contenedor = $('.contenido-aviso');
    function cargarAviso(id) {
        $.ajax({
            url: urlDetalle,
            type: 'POST',
            data: {
                _token: tokenPost,
                id: id
            },
            success: function (data) {
                const imgLogo = imgLogoBaseUrl + data.imgLogoAvisoEmpresaFeria;
                const estado = data.estado;
                let botonPostulacion = '';
                if (estado == 0) {
                    botonPostulacion = `<button type="button" class="btn btn-primary enviar-postulacion" data-id="${data.idAvisoEmpresaFeria}">Postularme</button>`;
                } else {
                    botonPostulacion = `<button type="button" class="btn btn-danger enviar-postulacion" data-id="${data.idAvisoEmpresaFeria}">Desistir</button>`;
                }
                $contenedor.html(`
                    <div class="row">
                        <div class="col-lg-8 col-12">
                            <p class="title-aviso-feria"><b>${data.nameAvisoEmpresaFeria}</b></p>
                            <div class="description">
                                <p class="razon-social">  ${data.razonSocialEmpresa}</p>
                                <p> ${ data.direccionEmpresa }</p>
                                <p class="detalle-descripcion-aviso"><i class="icon-check-sign"></i> Empresa Verificada</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12 d-flex justify-content-end align-items-start p-0">
                            <img id="imgLogo" src="${imgLogo}" style="width:100px; height:100px;" />
                        </div>
                        <div class="col-12">
                            ${botonPostulacion}
                        </div>
                    </div>
                `);
            },
            error: function (xhr) {
                $contenedor.html('<p class="text-danger">Error al cargar el aviso.</p>');
            }
        });
    }
    const $primero = $('.card-aviso').first();
    if ($primero.length > 0) {
        const idPrimero = $primero.data('id');
        cargarAviso(idPrimero);
    }
    $('.card-aviso').on('click', function () {
        const id = $(this).data('id');
        cargarAviso(id);
    });
});
$(document).on('click', '.enviar-postulacion', function() {
    const $btn = $(this);
    const idAviso = $btn.data('id');
    $.ajax({
        url: urlPostulacion,
        type: 'POST',
        data: {
            _token: tokenPost,
            id: idAviso
        },
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: response.message,
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                location.reload();
            });
        },        
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un problema al procesar tu solicitud.',
                timer: 2500,
                showConfirmButton: false
            });
        }
    });
});

