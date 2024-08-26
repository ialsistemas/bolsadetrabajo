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
            url: "/auth/programa/mostrarParticipantes",
            data: function (params) {
                let id_programa = $(".id_programa").val(); // Obtener el valor del programa seleccionado
                console.log("Valor de id_programa:", id_programa); // Mostrar el valor en consola para depurar

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
            /* { title: "ID Participante", data: "id_participante" }, */
            { title: "Fecha", data: "registro" },
            {
                title: "Nombres y Apellidos",
                data: null,
                render: function (data, type, row) {
                    return data.nombres + " " + data.apellidos;
                },
                class: "text-left"
            },
            { title: "Sede", data: "sede", class: "text-left" },
            { title: "DNI", data: "dni", class: "text-left" },        
            { title: "Telefono", data: "tel", class: "text-left" },
            { title: "Tipo", data: "tipo", class: "text-left" },
            { title: "Estado", data: "estado", class: "text-left" },
            {   
                data: null,
                render: function (data) {
                    return (
                        '<a href="javascript:void(0)" class="btn-delete btn btn-danger" idDato="' +
                        data.id_participante + /* Aqui cambiar el id cuando se desea eliminar*/
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
        console.log("Valor de la talba:", id);
        
        confirmAjax(
            `/auth/programa/deletepar`,
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
            /* $("#carrera").attr("placeholder", "Buscando ..."); */
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
                /* $("#carrera").val(data.especialidad); */
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
