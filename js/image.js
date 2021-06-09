function previewFile() {
    var preview = document.querySelector('#couverture');
    var preview_logo = document.querySelector('#no_image');
    if(!preview_logo.classList.contains('d-none')){
        preview_logo.classList.add('d-none');
    }
    var file    = document.querySelector('input[type=file]').files[0];
    var reader  = new FileReader();

    reader.onloadend = function () {
        preview.src = reader.result;
    }

    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.src = "";
    }
}