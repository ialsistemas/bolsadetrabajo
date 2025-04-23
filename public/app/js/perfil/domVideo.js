$(document).ready(function() {
    $('#mytable').DataTable({
        responsive: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        }
    });
    $('#file').on('change', function () {
        const file = this.files[0];
        const maxMB = 35;
        const pesoArchivo = $('#pesoArchivo');
        let pesoTexto = '';
        if (file) {
            const sizeInBytes = file.size;
            const sizeInMB = (sizeInBytes / (1024 * 1024)).toFixed(2);
            if (sizeInMB > maxMB) {
                pesoTexto = `Tamaño del archivo: ${sizeInMB} MB — ¡Excede el límite permitido de ${maxMB} MB!`;
                pesoArchivo.removeClass('text-secondary').addClass('text-danger');
                $('button[type="submit"]').prop('disabled', true);
            } else {
                pesoTexto = `Tamaño del archivo: ${sizeInMB} MB`;
                pesoArchivo.removeClass('text-danger').addClass('text-secondary');
                $('button[type="submit"]').prop('disabled', false);
            }
            pesoArchivo.text(pesoTexto);
        }
        if (this.files && this.files.length > 0) {
            $('#mensajeExito').fadeIn();
        } else {
            $('#mensajeExito').fadeOut();
        }
    });
    $('form').on('submit', function() {
        $('#overlay').css('display', 'flex').hide().fadeIn();
    });
});