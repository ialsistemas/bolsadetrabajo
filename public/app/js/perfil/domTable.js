$(document).ready(function() {
    if ( $.fn.DataTable.isDataTable('#certificados') ) {
        $('#certificados').DataTable().destroy();
    }
    $('#certificados').DataTable({
        responsive: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        }
    });

    if ( $.fn.DataTable.isDataTable('#pendientes') ) {
        $('#pendientes').DataTable().destroy();
    }
    $('#pendientes').DataTable({
        responsive: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        }
    });
});