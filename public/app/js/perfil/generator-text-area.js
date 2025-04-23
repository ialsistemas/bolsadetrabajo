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
        "save table contextmenu directionality emoticons template paste textcolor"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons"
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
            "save table contextmenu directionality emoticons template paste textcolor"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons"
    });    
}