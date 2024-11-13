// JavaScript para el formulario
var OnSuccessRegistroParticipantes, OnFailureRegistroParticipantes;
$(function () {
    OnSuccessRegistroParticipantes = (data) =>
        onSuccessForm(
            data,
            $("form#registroParticipantes"),
            $("#modalMantenimientoParticipantes")
        );
    OnFailureRegistroParticipantes = () => onFailureForm();
});

$(function () {
    const $table = $("#tableParticipantes");

    var $dataTableParticipante = $table.DataTable({
        stripeClasses: ["odd-row", "even-row"],
        lengthChange: true,
        lengthMenu: [
            [4, 10, 20, 50, -1],
            [4, 10, 20, 50, "Todo"],
        ],
        info: false,
        ajax: {
            url: "/auth/certificados/mostrarParticipantes",
            data: function (params) {
                let id_certificados = $(".id_certificados").val();
                console.log("Valor de id_certificados:", id_certificados);
    
                return {
                    id_certificados: id_certificados,
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
            { title: "Taller", data: "nombre", class: "text-center" },
            { title: "Fecha", data: "fecha", class: "text-center" },
            { title: "DNI", data: "dni", class: "text-center" },
            {
                title: "Nombres y Apellidos",
                data: null,
                render: function (data, type, row) {
                    return data.nombres + " " + data.apellidos;
                },
                class: "text-center",
            },
    
            {
                title: "Programa de Estudio",
                data: "especialidad",
                class: "text-center",
            },
            { title: "Telefono", data: "tel", class: "text-center" },
    
            {
                data: null,
                render: function (data) {
                    // Obtenemos el número de teléfono del participante
                    let telefono = data.tel ? data.tel : ''; // Si no hay teléfono, dejar vacío
    
                    return (
                        '<div class="btn-group" style="margin-left: 5px;">' +
                        // Botón para WhatsApp
                        '<a href="https://wa.me/' + telefono + '" target="_blank" class="btn btn-success" style="margin-right: 5px;">' +
                        '<i class="fa fa-whatsapp"></i> WhatsApp' +
                        '</a>' +
                        // Botón para Generar Certificado
                        '<a href="javascript:void(0)" class="btn-certificado btn btn-primary" style="margin-right: 5px;" idDato="' +
                        data.id + '">' +
                        "Certificado" +
                        '</a>' +
                        // Botón de Eliminar
                        '<a href="javascript:void(0)" class="btn-delete btn btn-danger" idDato="' +
                        data.id + '">' +
                        '<i class="fa fa-trash"></i> Eliminar' +
                        '</a>' +
                        "</div>"
                    );
                },
            },
        ],
    });
    
    

    $table.on("click", ".btn-certificado", function () {
        var id = $(this).attr("idDato");
        /* var empleado = $dataTableParticipante.row($(this).parents("tr")).data(); */
        invocarModalView(id);
    });

    function invocarModalView(id) {
        invocarModal(
            `/auth/certificados/partialViewCertificado/${id ? id : 0}`,
            function ($modal) {
                if ($modal.attr("data-reload") === "true") {
                    $dataTableParticipante.ajax.reload(null, false);
                }
            }
        );
    }

    $table.on("click", ".btn-delete", function () {
        const id = $(this).attr("idDato");
        const formData = new FormData();
        formData.append("_token", $("input[name=_token]").val());
        formData.append("id", id);
        console.log("Valor de la talba:", id);

        confirmAjax(
            `/auth/certificados/deleteAlumno`,
            formData,
            "POST",
            null,
            null,
            function () {
                $dataTableParticipante.ajax.reload(null, false);
            }
        );
    });
});

/* Buscar DNI */
$("#buscardni").click(function () {
    const dni = $("#dni");

    // Verificar si el campo dni está vacío
    if ($(dni).val().trim() === "") {
        swal("", "Ingrese el documento para buscar la información.", "warning");
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
                $("#especialidad").val(data.especialidad);
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
                swal("", "Usted no es alumno de esta institución.", "warning");
                $("#nombres").val("");
                $("#apellidos").val("");
                $("#tel").val("");
                $("#email").val("");
                $("#especialidad").val("");
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
            swal(
                "",
                "Error al buscar información. Inténtelo nuevamente más tarde.",
                "error"
            );
        },
    });
});
