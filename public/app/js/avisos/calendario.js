$(document).ready(function () {
    $('#phone').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    const horasBase = [
        '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
        '12:00', '12:30', '13:00', '13:30', '14:00', '14:30',
        '15:00', '15:30', '16:00'
    ];
    let dias = 30, primerDia = 0;
    let tbody = $('#cuerpo-calendario');
    let dia = 1;
    const hoy = new Date();
    const mesActual = 5;
    const anioActual = 2025;
    for (let i = 0; i < 6; i++) {
        let fila = $('<tr></tr>');
        for (let j = 0; j < 7; j++) {
            if ((i === 0 && j < primerDia) || dia > dias) {
                fila.append('<td></td>');
            } else {
                let fechaComparar = new Date(anioActual, mesActual, dia);
                let isPast = fechaComparar < new Date(hoy.getFullYear(), hoy.getMonth(), hoy.getDate());
                let clase = isPast ? 'disabled' : '';
                let celda = $('<td data-dia="' + dia + '" class="' + clase + '">' + dia + '</td>');
                fila.append(celda);
                dia++;
            }
        }
        tbody.append(fila);
    }
    $('#cuerpo-calendario').on('click', 'td[data-dia]:not(.disabled)', function () {
        $('td').removeClass('selected');
        $(this).addClass('selected');
        let dia = $(this).data('dia');
        let fecha = '2025-06-' + (dia < 10 ? '0' + dia : dia);
        $.ajax({
            url: urlDateCita,
            method: 'POST',
            data: {
                fecha: fecha,
                _token: token
            },
            success: function(response) {
                let horasOcupadas = response.horas_ocupadas;
                let horasDisponibles = horasBase.filter(function(hora) {
                    return !horasOcupadas.includes(hora);
                });
                let contenedor = $('#horas-disponibles');
                contenedor.empty();
                if (horasDisponibles.length > 0) {
                    $.each(horasDisponibles, function(i, hora) {
                        contenedor.append('<button class="btn btn-sm btn-info hora-btn">' + hora + '</button>');
                    });
                } else {
                    contenedor.append('<p>No hay horas disponibles</p>');
                }
            },
            error: function() {
                alert('Error consultando horas ocupadas');
            }
        });
    });
    $('#horas-disponibles').on('click', '.hora-btn', function () {
        let dia = $('td.selected').text();
        let hora = $(this).text();
        alert('Seleccionaste el ' + dia + ' de junio a las ' + hora);
    });
    $('#sendCita').on('click', function () {
        let dia = $('td.selected').data('dia');
        if (!dia) {
            Swal.fire('Selecciona un día', '', 'warning');
            return;
        }
        let hora = $('.hora-btn.active').text();
        if (!hora) {
            Swal.fire('Selecciona una hora', '', 'warning');
            return;
        }
        let fecha = '2025-06-' + (dia < 10 ? '0' + dia : dia);
        let motivo = $('#motivo').val();
        let credenciales = $('#credencialesAlumno').val();
        let phone = $('#phone').val();
        let idAsesora = $('#idAsesora').val();
        $.ajax({
            url: urlRegistraCita,
            method: 'POST',
            data: {
                fecha: fecha,
                hora: hora,
                motivo: motivo,
                cod_alumno: credenciales,
                phone: phone,
                idAsesora: idAsesora,
                _token: token
            },
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Cita registrada!',
                    text: response.message || 'Tu cita fue registrada exitosamente.',
                    //timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            },
            error: function (xhr) {
                let error = xhr.responseJSON?.message || 'Error al registrar la cita.';
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error
                });
            }
        });
    });
    $('#horas-disponibles').on('click', '.hora-btn', function () {
        $('.hora-btn').removeClass('active');
        $(this).addClass('active');
    });
});