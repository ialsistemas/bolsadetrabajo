var OnSuccessRegistroSancion, OnFailureRegistroSancion;
var $dataTableAlumnoSancionado;
const $table = $("#tableAlumnoSancionado");
const $actividad_eco_filter_id = $("#actividad_eco_filter_id");
const $ruc_dni = $("#ruc_dni");

$(function() {
    const $modal = $("#modalMantenimientoSancion"), $form = $("form#registroSancion");

    OnSuccessRegistroSancion = (data) => onSuccessForm(data, $form, $modal);
    OnFailureRegistroSancion = () => onFailureForm();

    // Inicializa el DataTable y asigna la variable global
    $dataTableAlumnoSancionado = $table.DataTable({
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
            url: "/auth/alumnosancionado/list_all",
            data: function (d) {
                // Filtro por actividad económica
                if ($actividad_eco_filter_id.val() !== "") {
                    d.actividad_eco_filter_id = $actividad_eco_filter_id.val();
                }

                // Filtro por RUC/DNI
                if ($ruc_dni.val() !== "") {
                    d.ruc_dni = $ruc_dni.val();
                }

                if ($("#btn_mostrar").attr("mostrar") != "") {
                    d.mostrar = $("#btn_mostrar").attr("mostrar");
                }
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
            {
                title: "Fecha de Creación",
                data: "created_at",
                render: function (data) {
                    return data ? moment(data).format("DD-MM-YYYY") : "-";
                },
            },
            { title: "DNI", data: "dni" },
            { title: "Nombre", data: "nombres" },
            { title: "Apellidos", data: "apellidos" },
            { title: "Motivo de Sanción", data: "motivo" },
            { title: "Estado", data: "estado" },
            {
                title: "Días Restantes",
                data: null,
                render: function (data, type, row) {
                    const estado = row.estado; // Obtén el estado
                    const createdDate = moment(row.created_at); // Obtén la fecha de creación
        
                    if (estado === "Deshabilitado") {
                        return "Sanción Completa";
                    }
        
                    if (createdDate.isValid()) {
                        const currentDate = moment();
                        const futureDate = createdDate.add(31, 'days');
                        const daysRemaining = futureDate.diff(currentDate, 'days');
                        return daysRemaining > 0 ? daysRemaining + ' días' : 'Sanción Completa';
                    }
        
                    return "-";
                },
            },
            {
                data: null,
                render: function (data) {
                    // Mostrar el botón solo si el estado es "Activo"
                    if (data.estado === "Activo") {
                        return (
                            '<div class="btn-group">' +
                            '<button type="button" class="btn btn-danger" idDato="' + 
                            data.id +
                            '"><i class="fa fa-ban"></i> Quitar Sanción</button>' +
                            '</div>'
                        );
                    } else {
                        return ''; // No mostrar nada si el estado es "Deshabilitado"
                    }
                },
            }
        ],
        createdRow: function (row, data) {
            // Cambiar el color de la celda según el estado
            if (data.estado === "Activo") {
                $("td", row).css({
                    "background-color": "rgb(52 211 153)",
                    color: "#fff",
                });
            }
        }
    });

    // Maneja el clic en el botón "Quitar Sanción"
    $table.on("click", ".btn-danger", function () {
        const id = $dataTableAlumnoSancionado.row($(this).parents("tr")).data().id;
        const formData = new FormData();
        formData.append("_token", $("input[name=_token]").val());
        formData.append("id", id);
        formData.append("estado", "Deshabilitado"); // Cambiar el nombre del campo a 'estado'
    
        confirmAjax(
            "/auth/alumnosancionado/update",
            formData,
            "POST",
            null,
            null,
            function () {
                $dataTableAlumnoSancionado.ajax.reload(null, false);
            }
        );
    });
});

function consultarSancion() {
    $("#btn_mostrar").attr("mostrar", "");
    if ($dataTableAlumnoSancionado) {
        $dataTableAlumnoSancionado.ajax.reload();
        $ruc_dni.val(""); //para que se limpie antes
        $actividad_eco_filter_id.val(""); //para que se limpie antes
    } else {
        console.error("DataTable no está inicializado.");
    }
}

function mostrarTodo() {
    $("#btn_mostrar").attr("mostrar", "mostrar");
    $dataTableAlumnoSancionado.ajax.reload();
}