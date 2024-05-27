var OnSuccessRegistroHorario, OnFailureRegistroHorario;
$(function(){

    const $modal = $("#modalMantenimientoHorario"), $form = $("form#registroHorario");

    OnSuccessRegistroHorario = (data) => onSuccessForm(data, $form, $modal);
    OnFailureRegistroHorario = () => onFailureForm();
});
