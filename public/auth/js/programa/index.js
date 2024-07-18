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
            url: "/auth/programa/list_all",
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
            { title: "Empresa", data: "empresa", class: "text-left" },
            { title: "Puesto 1", data: "puestouno", class: "text-left" },
            { title: "Puesto 2", data: "puestodos", class: "text-left" },
            { title: "Puesto 3", data: "puestotres", class: "text-left" },
            { title: "Puesto 4", data: "puestocuatro", class: "text-left" },
            { title: "Responsable", data: "responsable", class: "text-left" },
            { title: "Cantidad Postulantes", data: "postulantes", class: "text-left" },
            { title: "Cantidad Evaluando", data: "evaluando", class: "text-left" },
            { title: "Cantidad Contratado", data: "contratados", class: "text-left" },
            { title: "Cantidad Descartado", data: "descartado", class: "text-left" },

            /* { title: "DNI", data: "dni", class: "text-left" },
            { title: "Nombres", data: "nombres", class: "text-left" },
            { title: "Apellidos", data: "apellidos", class: "text-left" },
            { title: "Teléfono", data: "tel", class: "text-left" },
            { title: "Email", data: "email", class: "text-left" },
            { title: "Sede", data: "sede", class: "text-left" },
            { title: "Tipo", data: "tipo", class: "text-left" },
            { title: "Estado", data: "estado", class: "text-left" }, */


            /* { title: "Puesto 4", data: "puestocuatro", class: "text-left" }, */

            /* {
                title: "Banner",
                data: null,
                render: function (data) {
                    return (
                        '<img width="60%" src="../../../' +
                        data.banner +
                        '" alt="">'
                    );
                },
            }, */
            /* {
                data: null,
                render: function (data) {
                    return (
                        '<a href="javascript:(0)" class="btn-delete btn btn-danger" idDato="' +
                        data.id +
                        '"><i class="fa fa-trash"></i></a>'
                        
                    );
                },
            }, */
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
                        "</div>"
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
    $table.on("click", ".btn-update", function () {
        const id = $dataTablePrograma.row($(this).parents("tr")).data().id;
        invocarModalView(id);
    });


    function invocarModalView(id) {
        invocarModal(
            `/auth/programa/partialView/${id ? id : 0}`, function ($modal) {
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
            `/auth/programa/delete`,
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



/* Buscar DNI por siga en caso se requiera */
/* $("#buscardni").click(function () {
    const dni = $("#dni");

    // Verificar si el campo dni está vacío
    if ($(dni).val().trim() === '') {
        swal("", "Ingrese su DNI para buscar la información.", "warning");
        return; // Salir de la función si el dni está vacío
    }

    // Verificar si el dni tiene exactamente 8 dígitos
    if ($(dni).val().length !== 8) {
        swal("", "El DNI debe tener exactamente 8 dígitos.", "error");
        return; // Salir de la función si el dni no tiene 8 dígitos
    }

    // Si el dni tiene exactamente 8 dígitos, continuar con la búsqueda
    $.ajax({
        url: "https://istalcursos.edu.pe/apirest/alumnos",
        type: "POST",
        data: { documento: $(dni).val() },
        dataType: "json",
        beforeSend: function () {
            $("#nombres").attr("placeholder", "Buscando ...");
            $("#apellidos").attr("placeholder", "Buscando ...");
            $("#tel").attr("placeholder", "Buscando ...");
            $("#email").attr("placeholder", "Buscando ...");
        },
        success: function (res) {
            $("#nombres").attr("placeholder", "Nombres");
            $("#apellidos").attr("placeholder", "Apellidos");
            $("#tel").attr("placeholder", "Teléfono");
            $("#email").attr("placeholder", "Correo Electronico");
            if (res.success === true) {
                const data = res.data[0];
                $("#nombres").val(data.NombreAlumno);
                $("#apellidos").val(data.Apellidos);
                $("#tel").val(data.celular.replace(/ /g, ""));
                $("#email").val(data.email);
                $("#validationDni")
                    .html("DNI correcto.")
                    .removeClass("text-muted")
                    .removeClass("text-danger")
                    .addClass("text-success");
                $(dni)
                    .removeClass("border-danger border-dark")
                    .addClass("border-success");
                $("#btn-registrar").prop("disabled", false);
            } else {
                swal(
                    "",
                    "Usted no es alumno de esta institución.",
                    "warning"
                );
                $("#nombres").val("");
                $("#apellidos").val("");
                $("#tel").val("");
                $("#email").val("");
                $(dni)
                    .removeClass("border-success border-dark")
                    .addClass("border-danger");
                $("#validationDni")
                    .html("El DNI no existe en nuestros registros.")
                    .removeClass("text-muted")
                    .removeClass("text-success")
                    .addClass("text-danger");
            }
        },
        error: function () {
            swal("", "Error al buscar información. Inténtelo nuevamente más tarde.", "error");
        }
    });
});
 */



