$(document).ready(function () {
    $('#dni').on('input', function () {
        let cleaned = $(this).val().replace(/[^\d]/g, '');
        $(this).val(cleaned);
    });
    $('#direccion').on('input', function () {
        let cleaned = $(this).val().replace(/[\u{1F600}-\u{1F64F}]|[\u{1F300}-\u{1F5FF}]|[\u{1F680}-\u{1F6FF}]|[\u{2600}-\u{26FF}]|[\u{2700}-\u{27BF}]/gu, '');
        $(this).val(cleaned);
    });
    $('#telefono').on('input', function () {
        let cleaned = $(this).val().replace(/[^\d]/g, '');
        $(this).val(cleaned);
    });
    $('#email').on('input', function () {
        let cleaned = $(this).val().replace(/[\u{1F600}-\u{1F64F}]|[\u{1F300}-\u{1F5FF}]|[\u{1F680}-\u{1F6FF}]|[\u{2600}-\u{26FF}]|[\u{2700}-\u{27BF}]/gu, '');
        $(this).val(cleaned);
    });
    $('#empresa').on('input', function () {
        let cleaned = $(this).val().replace(/[\u{1F600}-\u{1F64F}]|[\u{1F300}-\u{1F5FF}]|[\u{1F680}-\u{1F6FF}]|[\u{2600}-\u{26FF}]|[\u{2700}-\u{27BF}]/gu, '');
        $(this).val(cleaned);
    });
    $('#puesto').on('input', function () {
        let cleaned = $(this).val().replace(/[\u{1F600}-\u{1F64F}]|[\u{1F300}-\u{1F5FF}]|[\u{1F680}-\u{1F6FF}]|[\u{2600}-\u{26FF}]|[\u{2700}-\u{27BF}]/gu, '');
        $(this).val(cleaned);
    });
    $('#institucion').on('input', function () {
        let cleaned = $(this).val().replace(/[\u{1F600}-\u{1F64F}]|[\u{1F300}-\u{1F5FF}]|[\u{1F680}-\u{1F6FF}]|[\u{2600}-\u{26FF}]|[\u{2700}-\u{27BF}]/gu, '');
        $(this).val(cleaned);
    });
    $('#name_curso').on('input', function () {
        let cleaned = $(this).val().replace(/[\u{1F600}-\u{1F64F}]|[\u{1F300}-\u{1F5FF}]|[\u{1F680}-\u{1F6FF}]|[\u{2600}-\u{26FF}]|[\u{2700}-\u{27BF}]/gu, '');
        $(this).val(cleaned);
    });
});
