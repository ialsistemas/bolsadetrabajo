var OnSuccessRegistroEventos, OnFailureRegistroEventos;
$(function(){

    const $modal = $("#modalMantenimientoEventos"), $form = $("form#EditEventos");

    OnSuccessRegistroEventos = (data) => onSuccessForm(data, $form, $modal);
    OnFailureRegistroEventos = () => onFailureForm();
});

