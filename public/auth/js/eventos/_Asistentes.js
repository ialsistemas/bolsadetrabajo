function clickExcelEventos(){
    $('.dt-buttons .buttons-excel').click()
}

// JavaScript para el formulario
$(function () {
    const $table = $("#tableAsistentes");

    var $dataTableParticipante = $table.DataTable({
        stripeClasses: ["odd-row", "even-row"],
        lengthChange: true,
        lengthMenu: [
            [4, 10, 20, 50, -1],
            [4, 10, 20, 50, "Todo"],
        ],
        info: false,
        ajax: {
            url: "/auth/eventos/mostrarParticipantesAsistentes",
            data: function (params) {
                let id_evento = $(".id_evento").val(); // Obtener el valor del programa seleccionado
                console.log("Valor de id_evento:", id_evento); // Mostrar el valor en consola para depurar

                return {
                    id_evento: id_evento,
                };
            },
        },
        columns: [
            {
                title: "N°",
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                },
            },
            /* { title: "ID Participante", data: "id_participante" }, */
            /* { title: "Fecha", data: "registro" }, */
            { title: "DNI", data: "dni", class: "text-left" },
            {
                title: "Nombres y Apellidos",
                data: null,
                render: function (data, type, row) {
                    return data.nombres + " " + data.apellidos;
                },
                class: "text-left",
            },

            {
                title: "Programa de Estudio",
                data: "especialidad",
                class: "text-left",
            },
            { title: "Sede", data: "sede", class: "text-left" },
            { title: "Email", data: "email", class: "text-left" },
            { title: "Telefono", data: "tel", class: "text-left" },
            { title: "Estado", data: "estado", class: "text-left" },
            { title: "Tipo", data: "tipo", class: "text-left" },
            { title: "Ciclo", data: "ciclo", class: "text-left" },
            {
                data: null,
                render: function (data) {
                    return (
                        '<div class="btn-group" style="margin-left: 5px;">' +
                        '<a href="javascript:void(0)" class="btn-edit btn btn-warning" idDato="' +
                        data.id +
                        '"><i class="fa fa-edit"></i></a>' +
                        "</div>"
                    );
                },
            },
            {
                data: null,
                render: function (data) {
                    return (
                        '<div class="btn-group" style ="margin-left: 5px;">' +
                        '<a href="javascript:void(0)" class="btn-delete btn btn-danger" idDato="' +
                        data.id /* Aquí cambiar el id cuando se desea editar */ +
                        '"><i class="fa fa-trash"></i></a>' +
                        "</div>"
                    );
                },
            },
        ],
        
    });
    $table.on("click", ".btn-delete", function () {
        const id = $(this).attr("idDato");
        const formData = new FormData();
        formData.append("_token", $("input[name=_token]").val());
        formData.append("id", id);
        confirmAjax(
            `/auth/eventos/deleteAsistentes`,
            formData,
            "POST",
            null,
            null,
            function () {
                $dataTableParticipante.ajax.reload(null, false);
            }
        );
    });

    /* Para abrir modal y editar */
    $table.on("click", ".btn-edit", function () {
        const id = $dataTableParticipante.row($(this).parents("tr")).data().id;
        invocarModalView(id);
    });

    function invocarModalView(id) {
        invocarModal(
            `/auth/eventos/partialViewEditAsistente/${id ? id : 0}`,
            function ($modal) {
                if ($modal.attr("data-reload") === "true")
                    $dataTableParticipante.ajax.reload(null, false);
            }
        );
    }

    
});

