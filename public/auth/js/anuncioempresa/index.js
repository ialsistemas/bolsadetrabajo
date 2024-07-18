var hoy = new Date();
var año = hoy.getFullYear();
var mes = ("0" + (hoy.getMonth() + 1)).slice(-2);
var dia = ("0" + hoy.getDate()).slice(-2);
var fecha_actual = año + "-" + mes + "-" + dia;
$(function () {
    const $table = $("#tableAnuncioEmpresa");

    var $dataTableAvisoEmpresa = $table.DataTable({
        columnDefs: [
            {
                defaultContent: "-",
                targets: "_all",
            },
        ],
        stripeClasses: ["odd-row", "even-row"],
        lengthChange: true,
        lengthMenu: [
            [5, 10, 20, 50, -1],
            [5, 10, 20, 50, "Todo"],
        ],
        info: false,
        ajax: {
            url: "/auth/anuncioempresa/list_all",
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
                title: "Registo",
                data: "created_at",
                render: function (data) {
                    if (data != null) return moment(data).format("DD-MM-YYYY");
                    return "-";
                },
            },
            { title: "Titulo", data: "titulo" },
            {
                title: "Enlace de Redirección",
                data: "enlace",
                class: "text-left",
            },
            { title: "Mostrar desde", data: "mostrar", class: "text-left" },
            { title: "Vigencia", data: "vigencia", class: "text-left" },
            {
                title: "Banner",
                data: null,
                render: function (data) {
                    return (
                        '<img width="60%" src="../../../' +
                        data.banner +
                        '" alt="">'
                    );
                },
            },
            {
                data: null,
                render: function (data) {
                    return (
                        '<a href="javascript:(0)" class="btn-delete btn btn-danger" idDato="' +
                        data.id +
                        '"><i class="fa fa-trash"></i></a>'
                    );
                },
            },
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

    $table.on("click", ".btn-delete", function () {
        /* const id = $dataTableAviso.row($(this).parents("tr")).data().id; */
        const id = $(this).attr("idDato");
        const formData = new FormData();
        formData.append("_token", $("input[name=_token]").val());
        formData.append("id", id);
        confirmAjax(
            `/auth/anuncioempresa/delete`,
            formData,
            "POST",
            null,
            null,
            function () {
                $dataTableAvisoEmpresa.ajax.reload(null, false);
            }
        );
    });
});
