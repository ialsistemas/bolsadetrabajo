$(document).ready(function () {
    $('#alert-success').fadeIn().delay(1500).fadeOut(200, function () {
        $('#btnSearch').trigger('click');
    });
});