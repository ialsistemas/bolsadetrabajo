$(document).on('click', '.btn-edit', function (e) {
    e.preventDefault();
    const url = $(this).attr('href');
    $('#contenidoModalEditarFeria').html('<div class="text-center p-5">Cargando formulario...</div>');
    $('#modalEditarFeria').modal('show');
    $.get(url, function (html) {
        $('#contenidoModalEditarFeria').html(html);
    }).fail(function () {
        $('#contenidoModalEditarFeria').html('<div class="text-danger text-center p-5">Error al cargar el formulario.</div>');
    });
});
