var hoy = new Date();
var año = hoy.getFullYear();
var mes = ("0" + (hoy.getMonth() + 1)).slice(-2);
var dia = ("0" + hoy.getDate()).slice(-2);
var fecha_actual = año + "-" + mes + "-" + dia;
$(function () {
    const $table = $("#tablePrograma");

    var $dataTablePrograma = $table.DataTable({
        columnDefs: [
            {
                defaultContent: "-",
                targets: "_all",
            },
        ],
        stripeClasses: ["odd-row", "even-row"],
        lengthChange: true,
        lengthMenu: [
            [10, 10, 20, 50, -1],
            [10, 10, 20, 50, "Todo"],
        ],
        info: false,
        ajax: {
            url: urlData,
            data: function (s) {},
        },
        columns: [
            {
                title: "N°",
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                },
            },
            {
                title: "Fecha Programa",
                data: "registro",
                render: function (data) {
                    if (data != null) return moment(data).format("DD-MM-YYYY");
                    return "-";
                },
            },
            { title: "Programa", data: "tipo_programa" },
            { title: "Responsable", data: "responsable", class: "text-left" },
            {
                data: null,
                render: function (data) {
                    return (
                        '<div class="btn-group">' +
                            '<a href="javascript:void(0)" class="btn-update btn btn-primary" idDato="' +
                            data.id +
                            '"><i class="fa fa-edit"></i> Editar</a>' +
                    
                            '<a href="javascript:void(0)" class="btn-delete btn btn-danger" idDato="' +
                            data.id +
                            '"><i class="fa fa-trash"></i> Eliminar</a>' +
                        '</div>'
                    );
                },
            },
            {
                title: "Participantes",
                data: null,
                render: function (data) {
                    return (
                        '<div class="btn-group">' +
                        '<a href="javascript:void(0)" class="btn-verpar btn btn-info" idDato="' +
                        data.id +
                        '"><i class="fa fa-users"></i> Añadir Participantes</a>' +
                        '</div>'
                    );
                },
            }
            
        ],
        rowCallback: function (row, data, index) {
            if (data.vigencia < fecha_actual) {
                $("td", row).css({
                    "background-color": "#f87171",
                    color: "#fff",
                });
            }
        },
    });

    $table.on("click", ".btn-update", function () {
        const id = $dataTablePrograma.row($(this).parents("tr")).data().id;
        invocarModalView(id);
    });

    $table.on("click", ".btn-verpar", function () {
        const id = $dataTablePrograma.row($(this).parents("tr")).data().id;
        invocarModalViewParticipantes(id);
    });

    function invocarModalView(id) {
        invocarModal(
            `/auth/programa/partialViewEmpleabilidad/${id ? id : 0}`, function ($modal) {
                if ($modal.attr("data-reload") === "true") $dataTablePrograma.ajax.reload(null, false);
            }
        );
    }

    function invocarModalViewParticipantes(id) {
        invocarModal(
            `/auth/programa/partialViewParticipantesEmpleabilidad/${id ? id : 0}`, function ($modal) {
                if ($modal.attr("data-reload") === "true") $dataTablePrograma.ajax.reload(null, false);
            }
        );
    }

    $table.on("click", ".btn-delete", function () {
        const id = $(this).attr("idDato");
        const formData = new FormData();
        formData.append("_token", $("input[name=_token]").val());
        formData.append("id", id);
        confirmAjax(
            `/auth/programa/deleteEmpleabilidad`,
            formData,
            "POST",
            null,
            null,
            function () {
                $dataTablePrograma.ajax.reload(null, false);
            }
        );
    });
});
function clickExcelAlumno(){
    $('.dt-buttons .buttons-excel').click()
}