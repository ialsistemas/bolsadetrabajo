tinymce.init({
    selector: '#habilidades_conoci',
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
if($("#perfil_profesional").length){
    tinymce.init({
        selector: '#perfil_profesional',
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