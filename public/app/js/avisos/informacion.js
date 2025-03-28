$(function(){

    const $postular = $("#postular"), $userInfo = $(".user-info");

    $postular.on("click", function(){
        let alumnoId = $(this).attr("data-user");
        $.ajax({
            url: routeProgreso,
            type: "POST",
            data: {
                alumnoId: alumnoId,
                _token: tokenWeb
            },
            success: function (response) {
                if (response.progreso >= 80) {
                    const formData = new FormData();
                    formData.append("_token", $("input[name=_token]").val());
                    formData.append("aviso_id", $postular.attr("data-info"));
    
                    actionAjax("/alumno/aviso/postular", formData, "POST", function (data) {
                        if (data.Success) {
                            $postular.text("Ya estás postulando")
                                .addClass("postulaste")
                                .prop("disabled", true);
                            $("div.progress-line:first").addClass("active");
                        } else {
                            if (data.Redirect) {
                                console.log("Redirigiendo a:", data.Redirect);
                                window.location.href = data.Redirect; // Se usa el Redirect del servidor
                            } else if (typeof routeHome !== "undefined") {
                                console.log("Redirigiendo a routeHome:", routeHome);
                                window.location.href = routeHome; // Asegura que routeHome esté definido
                            } else {
                                Swal.fire("Error", "No se encontró una redirección válida.", "error");
                            }
                        }
                    });
                } else {
                    Swal.fire({
                        icon: "warning",
                        title: "No cumples con el requisito",
                        text: "Debes tener al menos un 80% de progreso en tu perfil profesional.",
                        confirmButtonText: "Entendido"
                    });
                }
            },
            error: function (xhr) {
                Swal.fire("Error", "Hubo un problema con la solicitud.", "error");
            }
        });
        function actionAjax(url, formData, method, callback) {
            $.ajax({
                url: url,
                type: method,
                data: formData,
                contentType: false,
                processData: false,
                success: callback,
                error: function () {
                    Swal.fire("Error", "No se pudo procesar la solicitud.", "error");
                }
            });
        }
    });
});
