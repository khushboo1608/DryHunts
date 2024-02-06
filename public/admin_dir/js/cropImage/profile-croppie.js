var $uploadCrop,
rawImg;
$('.item-img').on('change', function ()
{
    readFile(this);
});
function readFile(input)
{
    var fileimagevariable=input.files[0];
    if(fileimagevariable.type.match('image.*'))
    {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.upload-demo').addClass('ready');
                $('#cropImagePop').modal('show');
                rawImg = e.target.result;

            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    else
    {
        swal("Only jpeg,jpg,png files are allowed");
    }
}
$uploadCrop = $('#upload-demo').croppie({
    viewport: {
        width: 250,
        height: 250,
        type:"circle"
    },
    boundary: {
        width: 400,
        height: 300
    },
    enforceBoundary: false,
    enableExif: true
});
$('#cropImagePop').on('shown.bs.modal', function () {
    $uploadCrop.croppie('bind', {
        url: rawImg
    }).then(function () {
       // console.log('jQuery bind complete');
    });
});

$('#cropImageBtn').on('click', function (ev) {
    $uploadCrop.croppie('result', {
        type: 'canvas',
        format: 'jpeg',
        size: 'viewport',
    }).then(function (resp) {
        console.log(resp);
        $('#item-img-output').attr('src', resp);
        $('#image1').val(resp);
        $('#cropImagePop').modal('hide');
        $('#uploadbtnImage').prop('disabled', false);
    });
});
$.ready(function () {
    setTimeout(function () {
        $('#hide').hide();
    }, 5000)
})
$('#cropImagePop').on('hidden.bs.modal', function () {
    $('#image').val(''); 
})

