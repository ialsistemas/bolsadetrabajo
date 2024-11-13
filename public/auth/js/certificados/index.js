var hoy = new Date();
var año = hoy.getFullYear();
var mes = ("0" + (hoy.getMonth() + 1)).slice(-2);
var dia = ("0" + hoy.getDate()).slice(-2);
var fecha_actual = año + "-" + mes + "-" + dia;
$(function () {
    const $table = $("#tableCertificados");

    var $dataTableTalleres = $table.DataTable({
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
            url: "/auth/certificados/list_all",
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
                title: "Fecha del taller",
                data: "fecha",
                render: function (data) {
                    if (data != null) return moment(data).format("DD-MM-YYYY");
                    return "-";
                },
            },
            { title: "Taller", data: "nombre" },
            { title: "Horas", data: "horas" },
            { title: "Creditos", data: "creditos" },
            {
                title: "Participantes",
                data: null,
                render: function (data) {
                    return (
                        '<div class="btn-group">' +
                        '<a href="javascript:void(0)" class="btn-verpar btn btn-info" idDato="' + // Cambiar color a btn-info
                        data.id +
                        '"><i class="fa fa-users"></i> Añadir Participantes</a>' + // Cambiar el ícono aquí
                        "</div>"
                    );
                },
            },
            {
                data: null,
                render: function (data) {
                    return (
                        '<div class="btn-group">' +
                        '<a href="javascript:void(0)" class="btn-update btn btn-primary" idDato="' +
                        data.id +
                        '"><i class="fa fa-edit"></i></a>' +
                        '<a href="javascript:void(0)" class="btn-delete btn btn-danger" idDato="' +
                        data.id +
                        '"><i class="fa fa-trash"></i></a>' +
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

    $table.on("click", ".btn-verpar", function () {
        const id = $dataTableTalleres.row($(this).parents("tr")).data().id;
        invocarModalViewParticipantes(id);
    });

    function invocarModalViewParticipantes(id) {
        invocarModal(
            `/auth/certificados/partialView/${id ? id : 0}`,
            function ($modal) {
                if ($modal.attr("data-reload") === "true")
                    $dataTablePrograma.ajax.reload(null, false);
            }
        );
    }

   /*  function invocarModalViewParticipantes(id) {
        invocarModal(
            `/auth/programa/partialViewParticipantes/${id ? id : 0}`,
            function ($modal) {
                if ($modal.attr("data-reload") === "true")
                    $dataTablePrograma.ajax.reload(null, false);
            }
        );
    } */

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
function clickExcelAlumno() {
    $(".dt-buttons .buttons-excel").click();
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
