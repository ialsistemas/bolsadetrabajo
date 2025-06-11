$(document).on('click', '#btn-open-feria-modal', function () {
    $('#modalAgregarFeria').modal('show');
    $('#modal-feria-content').html('<div class="text-center p-5">Cargando formulario...</div>');
    $.ajax({
        url: urlAgregar,
        type: "GET",
        success: function (response) {
            $('#modal-feria-content').html(response);
        },
        error: function () {
            $('#modal-feria-content').html('<div class="p-4 text-danger">Error al cargar el formulario.</div>');
        }
    });
});