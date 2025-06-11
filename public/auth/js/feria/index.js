$(document).ready(function () {
    $('#tableFeria').DataTable({
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
                        data.forEach(feria => {
                            const editUrl = baseUrlEdit.replace(':id', feria.id);
                            const deleteUrl = baseUrlDelete.replace(':id', feria.id);
                            const listEmpresaRegistradoUrl = baseUrlListEmpresaRegistrado.replace(':id', feria.id);
                            rows += `
                                <tr>
                                    <td>${feria.name}</td>
                                    <td>${feria.fecha_inicio}</td>
                                    <td>${feria.fecha_final}</td>
                                    <td>${feria.route}</td>
                                    <td>
                                    <a href="${editUrl}" class="btn btn-sm btn-warning text-white btn-edit" data-id="${feria.id}"><i class="icon-pencil"></i></a>
                                        <button class="btn btn-sm btn-danger btn-delete" data-url="${deleteUrl}">
                                            <i class="icon-trash"></i>
                                        </button>
                                        <a href="${listEmpresaRegistradoUrl}" class="btn btn-sm btn-info text-white"><i class="icon-building"></i> Lista de Empresa</a>
                                    </td>
                                </tr>
                            `;
                        });
                    } else {
                        rows = `<tr><td colspan="4" class="text-center">No se encontraron ferias</td></tr>`;
                    }
                    $('#tableFeria tbody').html(rows);
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
        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();
            const url = $(this).data('url');
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción eliminará la feria.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
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
                                title: 'Eliminado',
                                text: response.success || 'Feria eliminada correctamente.',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            $('#btnSearch').trigger('click');
                        },
                        error: function (xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON?.error || 'No se pudo eliminar la feria.',
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