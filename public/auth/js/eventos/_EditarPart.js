var OnSuccessRegistroPrograma, OnFailureRegistroPrograma;
$(function(){

    const $modal = $("#modalMantenimientoPrograma"), $form = $("form#registroPrograma");
    
    OnSuccessRegistroPrograma = (data) => onSuccessForm(data, $form, $modal);
    OnFailureRegistroPrograma = () => onFailureForm();
});

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
                $("#estado").attr("placeholder", "Buscando ...");
                $("#tipo").attr("placeholder", "Buscando ...");
                $("#ciclo").attr("placeholder", "Buscando ...");
            },
            success: function (res) {
                $("#nombres").attr("placeholder", "Nombres");
                $("#apellidos").attr("placeholder", "Apellidos");
                $("#tel").attr("placeholder", "Teléfono");
                $("#email").attr("placeholder", "Correo Electronico");
                $("#especialidad").attr("placeholder", "Especialidad");
                $("#sede").attr("placeholder", "Sede");
                $("#tipo").attr("placeholder", "Ingrese..");
                $("#estado").attr("placeholder", "Ingrese..");
                $("#ciclo").attr("placeholder", "Ingrese..");
                if (res.success === true) {
                    const data = res.data[0];
                    $("#nombres").val(data.NombreAlumno);
                    $("#apellidos").val(data.Apellidos);
                    $("#tel").val(data.celular.replace(/ /g, ""));
                    $("#email").val(data.email);
                    $("#especialidad").val(data.especialidad);
                    $("#sede").val(data.Sede);
                    $("#tipo").val(data.Egresado);
                    $("#estado").val(data.Titulado);
                    $("#ciclo").val(data.ciclo);
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
                    $("#tipo").val("");
                    $("#estado").val("");
                    $("#ciclo").val("");
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