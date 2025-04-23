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
            url: "/auth/programa/mostrarParticipantesEmpleabilidad",
            data: function (params) {
                let id_programa = $(".id_programa").val();
                return {
                    id_programa: id_programa,
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
            { title: "Fecha", data: "registro" },
            { title: "DNI", data: "dni", class: "text-left" },     
            {
                title: "Nombres y Apellidos",
                data: null,
                render: function (data, type, row) {
                    return data.nombres + " " + data.apellidos;
                },
                class: "text-left"
            },
            { title: "Programa de Estudio", data: "especialidad", class: "text-left" },
            { title: "Sede", data: "sede", class: "text-left" },
            { title: "Telefono", data: "tel", class: "text-left" },
            { title: "Tipo", data: "tipo", class: "text-left" },
            {
                data: null,
                render: function (data) {
                    if (userProfileId === PERFIL_DESARROLLADOR) {
                        return (
                            '<div class="btn-group" style="margin-left: 5px;">' +
                                '<a href="javascript:void(0)" class="btn-edit btn btn-warning" idDato="' +
                                data.id_participante + 
                                '"><i class="fa fa-edit"></i></a>' +
                            '</div>'
                        );
                    } else {
                        return '';
                    }
                },
            },
            
            {   
                data: null,
                render: function (data) {
                    return (
                        '<div class="btn-group" style ="margin-left: 5px;">' +
                            '<a href="javascript:void(0)" class="btn-delete btn btn-danger" idDato="' +
                            data.id_participante +
                            '"><i class="fa fa-trash"></i></a>' +
                        '</div>'
                    );
                },
            },

            {   
                data: null,
                render: function (data) {
                    return (
                        '<div class="btn-group" style="margin-left: 5px;">' +
                            '<a href="javascript:void(0)" class="btn-certificate btn btn-success" idDato="' +
                            data.id_participante +
                            '">Emitir Certificado</a>' +
                        '</div>'
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
        console.log("Valor de la talba:", id);
        
        confirmAjax(
            `/auth/programa/deleteparEmpleabilidad`,
            formData,
            "POST",
            null,
            null,
            function () {
                $dataTableParticipante.ajax.reload(null, false);
            }
        );
    });

    $table.on("click", ".btn-warning", function () {
        const id = $dataTableParticipante.row($(this).parents("tr")).data().id_participante;
        invocarModalViewParticipantes(id);
    });

    function invocarModalViewParticipantes(id) {
        invocarModal(
            `/auth/programa/partialViewparEmpleabilidad/${id ? id : 0}`, function ($modal) {
                if ($modal.attr("data-reload") === "true") $dataTableParticipante.ajax.reload(null, false);
            }
        );
    }

    $table.on("click", ".btn-certificate", function () {
        const id = $(this).attr("idDato");
        const url = `/auth/programa/generarCertificadoEmpleabilidad/${id}`;
        window.open(url, "_blank");
    });
});
$("#buscardni").click(function () {
    const dni = $("#dni");
    if ($(dni).val().trim() === "") {
        swal("", "Ingrese el documento para buscar la información.", "warning");
        return;
    }
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

