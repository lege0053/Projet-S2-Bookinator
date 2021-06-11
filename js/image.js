function previewFile(edit) {
    var preview = document.querySelector('#couverture');
    if(edit != 1){
        var preview_logo = document.querySelector('#no_image');

        if(!preview_logo.classList.contains('d-none')){
            preview_logo.classList.add('d-none');
        }
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

function previewPhotoProfil(edit) {
    var preview = document.querySelector('#photoProfil');

    if(edit != 1){
        var preview_logo = document.querySelector('#no_image');

        if(!preview_logo.classList.contains('d-none')){
            preview_logo.classList.add('d-none');
            preview.classList.remove('d-none')
        }
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