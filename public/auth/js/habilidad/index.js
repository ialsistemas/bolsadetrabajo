var $dataTableHabilidad, $dataTable;
$(function(){

    const $table = $("#tableHabilidad"), $tipo = parseInt($("#tipo_mant").val());

    $dataTableHabilidad = $table.DataTable({
        "stripeClasses": ['odd-row', 'even-row'],
        "lengthChange": true,
        "lengthMenu": [[50,100,200,500,-1],[50,100,200,500,"Todo"]],
        "info": false,
        "buttons": [],
        "ajax": {
            url: "/auth/habilidad/list_all",
            data: function (x) {
                x.tipo = $tipo;
            }
        },
        "columns": [
            { title: "ID", data: "id", className: "text-center" },
            { title: "Habilidad ", data: "nombre"},
            {
                data: null,
                defaultContent:
                    "<button type='button' class='btn btn-secondary btn-xs btn-update' data-toggle='tooltip' title='Actualizar'><i class='fa fa-pencil'></i></button>",
                "orderable": false,
                "searchable": false,
                "width": "26px"
            },
            {
                data: null,
                defaultContent:
                    "<button type='button' class='btn btn-danger btn-xs btn-delete' data-toggle='tooltip' title='Eliminar'><i class='fa fa-trash'></i></button>",
                "orderable": false,
                "searchable": false,
                "width": "26px"
            }
        ]
    });

    $table.on("click", ".btn-update", function () {
        const id = $dataTableHabilidad.row($(this).parents("tr")).data().id;
        invocarModalView(id);
    });

    $table.on("click", ".btn-delete", function () {
        const id = $dataTableHabilidad.row($(this).parents("tr")).data().id;
        const formData = new FormData();
        formData.append('_token', $("input[name=_token]").val());
        formData.append('id', id);
        confirmAjax(`/auth/habilidad/delete`, formData, "POST", null, null, function () {
            $dataTableHabilidad.ajax.reload(null, false);
        });
    });

    $("#modalRegistrarHabilidad").on("click", function () {
        invocarModalView();
    });

    function invocarModalView(id) {
        invocarModal(`/auth/habilidad/partialView/${id ? id : 0}`, function ($modal) {
            if ($modal.attr("data-reload") === "true") $dataTableHabilidad.ajax.reload(null, false);
        });
    }
});
