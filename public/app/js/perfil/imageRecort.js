$(document).ready(function () {
    var cropper;
    var image = document.getElementById('cropper-image');
    var inputFile = $('#upload-trigger');
    inputFile.on('change', function (e) {
        var files = e.target.files;
        if (files && files.length > 0) {
            var reader = new FileReader();
            reader.onload = function (e) {
                image.src = e.target.result;
                $('#cropperModal').modal('show');
            };
            reader.readAsDataURL(files[0]);
        }
    });
    $('#cropperModal').on('shown.bs.modal', function () {
        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 1,
            autoCropArea: 1,
        });
    }).on('hidden.bs.modal', function () {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        image.src = '';
        inputFile.val('');
    });
    $('#cropImageBtn').click(function () {
        var canvas = cropper.getCroppedCanvas({
            width: 300,
            height: 300,
        });
        $('#preview-img').attr('src', canvas.toDataURL());
        $('#imagen-recortada-base64').val(canvas.toDataURL('image/jpeg'));
        $('#cropperModal').modal('hide');
    });
});
