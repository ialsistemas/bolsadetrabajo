$(document).ready(function() {
    $('#filtro-form').submit(function() {
        $('#loading').show(); // Muestra el indicador de carga
        $('#filtro-submit').attr('disabled',
            true); // Deshabilita el botón de submit para evitar múltiples envíos

        // Puedes agregar más lógica aquí si es necesario antes de enviar el formulario

        return true; // Envía el formulario
    });
});