var hoy = new Date();
var año = hoy.getFullYear();
var mes = ("0" + (hoy.getMonth() + 1)).slice(-2);
var dia = ("0" + hoy.getDate()).slice(-2);
var fecha_actual = año + "-" + mes + "-" + dia;
$(function () {
    const $table = $("#tableEventos");

    var $dataTableEventos = $table.DataTable({
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
            url: "/auth/eventos/list_all",
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
                data: "fecha_registro",
                render: function (data) {
                    if (data != null) return moment(data).format("DD-MM-YYYY");
                    return "-";
                },
            },
            { title: "Empresa", data: "nombre", class: "text-left" },
            {
                data: null,
                render: function (data) {
                    return (
                        '<div class="btn-group">' +
                        '<a href="javascript:void(0)" class="btn-update btn btn-primary" idDato="' +
                        data.id +
                        '" style="margin-right: 5px;"><i class="fa fa-edit"></i> </a>' +
                        '<a href="javascript:void(0)" class="btn-delete btn btn-danger" idDato="' +
                        data.id +
                        '"><i class="fa fa-trash"></i> </a>' +
                        '<a href="javascript:void(0)" class="btn-view-participants btn btn-info" idDato="' +
                        data.id +
                        '" style="margin-left: 5px;"><i class="fa fa-users"></i></a>' +
                        '</div>'
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
    /* Para abrir modal y editar */
    $table.on("click", ".btn-update", function () {
        const id = $dataTableEventos.row($(this).parents("tr")).data().id;
        invocarModalView(id);
    });

    function invocarModalView(id) {
        invocarModal(`/auth/eventos/partialView/${id ? id : 0}`, function ($modal) {
            if ($modal.attr("data-reload") === "true") $dataTableEventos.ajax.reload(null, false);
        });
    }



    /* Para abrir modal y ver participantes */
    $table.on("click", ".btn-view-participants", function () {
        const id = $dataTableEventos.row($(this).parents("tr")).data().id;
        invocarModalViewParticipantesE(id);
    });

    function invocarModalViewParticipantesE(id) {
        invocarModal(`/auth/eventos/partialViewAsistentes/${id ? id : 0}`, function ($modal) {
            if ($modal.attr("data-reload") === "true") $dataTableEventos.ajax.reload(null, false);
        });
    }
    

    $table.on("click", ".btn-delete", function () {
        const id = $(this).attr("idDato");
        const formData = new FormData();
        formData.append("_token", $("input[name=_token]").val());
        formData.append("id", id);
        confirmAjax(
            `/auth/eventos/delete`,
            formData,
            "POST",
            null,
            null,
            function () {
                $dataTableEventos.ajax.reload(null, false);
            }
        );
    });
});

$(function () {
    const $tableP = $("#tableParticipantesAsistentes");

    var $dataTableEventos = $tableP.DataTable({
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
            url: "/auth/eventos/listA",
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
                title: "Fecha Evento",
                data: "fecha_registro",
                render: function (data) {
                    if (data != null) return moment(data).format("DD-MM-YYYY");
                    return "-";
                },
            },
            { title: "Nombre Evento", data: "nombre", class: "text-left" }, 
            { title: "DNI", data: "dni", class: "text-left" }, 
            {
                title: "Nombres y Apellidos",
                data: null,
                render: function (data, type, row) {
                    return data.nombres + " " + data.apellidos;
                },
                class: "text-left"
            },   
            { title: "Email", data: "email", class: "text-left" },       
            { title: "Programa de Estudio", data: "especialidad", class: "text-left" },       
            { title: "Sede", data: "sede", class: "text-left" },       
            { title: "Telefono", data: "tel", class: "text-left" },                
        ],
    });
})
/* Buscar DNI por siga en caso se requiera */
$(document).ready(function () {
    // Función de búsqueda que se llama tanto al hacer clic como al presionar Enter
    function buscarInformacion() {
        const dni = $("#dni");

        // Verificar si el campo dni está vacío
        if ($(dni).val().trim() === '') {
            swal("", "Ingrese su DNI para buscar la información.", "warning");
            return; // Salir de la función si el dni está vacío
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
                $("#especialidad").attr("placeholder", "Buscando ...");
                $("#sede").attr("placeholder", "Buscando ...");
                $("#titulado").attr("placeholder", "Buscando ...");
                $("#egresado").attr("placeholder", "Buscando ...");
            },
            success: function (res) {
                $("#nombres").attr("placeholder", "Nombres");
                $("#apellidos").attr("placeholder", "Apellidos");
                $("#tel").attr("placeholder", "Teléfono");
                $("#email").attr("placeholder", "Correo Electronico");
                $("#especialidad").attr("placeholder", "Especialidad");
                $("#sede").attr("placeholder", "Sede");
                $("#egresado").attr("placeholder", "Ingrese..");
                $("#titulado").attr("placeholder", "Ingrese..");
                if (res.success === true) {
                    const data = res.data[0];
                    $("#nombres").val(data.NombreAlumno);
                    $("#apellidos").val(data.Apellidos);
                    $("#tel").val(data.celular.replace(/ /g, ""));
                    $("#email").val(data.email);
                    $("#especialidad").val(data.especialidad);
                    $("#sede").val(data.Sede);
                    $("#egresado").val(data.Egresado);
                    $("#titulado").val(data.Titulado);
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
                    $("#especialidad").val("");
                    $("#sede").val("");
                    $("#egresado").val("");
                    $("#titulado").val("");
                    
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
    }

    // Llamar a la función de búsqueda al hacer clic en el botón
    $("#buscardni").click(function () {
        buscarInformacion();
    });

    // Llamar a la función de búsqueda cuando se presiona Enter en el campo DNI
    $("#dni").keypress(function (e) {
        if (e.which === 13) { // Código de la tecla Enter
            e.preventDefault(); // Evitar el comportamiento por defecto del Enter (como enviar un formulario)
            buscarInformacion();
        }
    });
});

