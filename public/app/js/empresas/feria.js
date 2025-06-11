$(document).ready(function () {
    if($('#successAlert').length > 0){
        setTimeout(function () {
            $('#successAlert').fadeOut('slow');
        }, 1000);
    }
    if($('#tableAviso').length > 0){
        $('#tableAviso').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            },
            pageLength: 10,
            responsive: true,
            autoWidth: false
        });
    }
    if($('.welcome-container').length > 0){
        setTimeout(function () {
            $('.welcome-container').fadeOut('slow');
        }, 2500);
    }
    if($("#description").length){
        tinymce.init({
            selector: '#description',
            width: "100%",
            height: 400,
            statusbar: false,
            content_css: false,
            skin: "oxide",
            language: "es",
            language_url: "https://cdn.jsdelivr.net/npm/tinymce-i18n/langs/es.js", // CDN
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality template paste textcolor"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor",
            setup: function (editor) {
                const emojiRegex = /[\u{1F600}-\u{1F64F}]|[\u{1F300}-\u{1F5FF}]|[\u{1F680}-\u{1F6FF}]|[\u{2600}-\u{26FF}]|[\u{2700}-\u{27BF}]/gu;
                function removeEmojis(content) {
                    return content.replace(emojiRegex, '');
                }
                editor.on('BeforeInput', function (e) {
                    if (e.inputType === 'insertText') {
                        e.preventDefault();
                        const text = removeEmojis(e.data);
                        editor.insertContent(text);
                    }
                });
                editor.on('PastePreProcess', function (e) {
                    e.content = removeEmojis(e.content);
                });
            }
        });    
    }
    if($("#requisitos").length){
        tinymce.init({
            selector: '#requisitos',
            width: "100%",
            height: 400,
            statusbar: false,
            content_css: false,
            skin: "oxide",
            language: "es",
            language_url: "https://cdn.jsdelivr.net/npm/tinymce-i18n/langs/es.js", // CDN
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality template paste textcolor"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor",
            setup: function (editor) {
                const emojiRegex = /[\u{1F600}-\u{1F64F}]|[\u{1F300}-\u{1F5FF}]|[\u{1F680}-\u{1F6FF}]|[\u{2600}-\u{26FF}]|[\u{2700}-\u{27BF}]/gu;
                function removeEmojis(content) {
                    return content.replace(emojiRegex, '');
                }
                editor.on('BeforeInput', function (e) {
                    if (e.inputType === 'insertText') {
                        e.preventDefault();
                        const text = removeEmojis(e.data);
                        editor.insertContent(text);
                    }
                });
                editor.on('PastePreProcess', function (e) {
                    e.content = removeEmojis(e.content);
                });
            }
        });    
    }
});