$(document).ready(function () {
    $('#tableAsesora').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        },
        pageLength: 10,
        responsive: true,
        autoWidth: false
    });
    if($('#btnSearch').length > 0){
        $('#btnSearch').click(function () {
            const startDate = $('#startDate').val();
            const endDate = $('#endDate').val();
    
            if (!startDate || !endDate) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Fechas requeridas',
                    text: 'Por favor selecciona ambas fechas.',
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }
            if (endDate < startDate) {
                Swal.fire({
                    icon: 'error',
                    title: 'Fechas inválidas',
                    text: 'La fecha final no puede ser menor que la fecha de inicio.',
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    startDate: startDate,
                    endDate: endDate
                },
                success: function (data) {
                    let rows = '';
                    if (data.length > 0) {
                        data.forEach(cita => {
                            const asistenciaUrl = baseUrlFinalizado.replace(':id', cita.id);
                            let botonAsistencia = '';
                            if (cita.state == 1) {
                                botonAsistencia = `
                                    <button class="btn btn-sm btn-warning text-white btn-asistencia" data-url="${asistenciaUrl}">
                                        <i class="fa fa-check-square text-white"></i> Validar Asistencia
                                    </button>
                                `;
                            } else {
                                botonAsistencia = `
                                    <button class="btn btn-sm btn-default" disabled>
                                        <i class="fa fa-check-square"></i> Ya validado
                                    </button>
                                `;
                            }
                            rows += `
                                <tr>
                                    <td>${cita.nombre_asesora}</td>
                                    <td>${cita.nombre_alumno} ${cita.apellido_alumno}</td>
                                    <td>${cita.phone}</td>
                                    <td>${cita.motivo}</td>
                                    <td>${cita.dia} ${cita.hora}</td>
                                    <td>${cita.estado_cita}</td>
                                    <td>${botonAsistencia}</td>
                                </tr>
                            `;
                        });
                    } else {
                        rows = `<tr><td colspan="4" class="text-center">No se encontraron Citas</td></tr>`;
                    }
                    $('#tableAsesora tbody').html(rows);
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error al obtener las ferias.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        });
        $(document).on('click', '.btn-asistencia', function (e) {
            e.preventDefault();
            const url = $(this).data('url');
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción actualziará la cita.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, actualizar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Actualizado',
                                text: response.success || 'cita actualziado correctamente.',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            $('#btnSearch').trigger('click');
                        },
                        error: function (xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON?.error || 'No se pudo actualizar la cita.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    });
                }
            });
        });
    }
});