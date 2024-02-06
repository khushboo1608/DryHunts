var $uploadCrop,
tempFilename,
rawImg,
imageId;
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
        width: 160,
        height: 100,
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
$('.item-img').on('change', function () {
    imageId = $(this).data('id');
    tempFilename = $(this).val();
    $('#cancelCropBtn').data('id', imageId);
    readFile(this);
});
$('#cropImageBtn').on('click', function (ev) {
    $uploadCrop.croppie('result', {
        type: 'base64',
        format: 'jpeg',
        size: {width: 160, height: 100}
    }).then(function (resp) {
        console.log(resp);
        $('#item-img-output').attr('src', resp);
        $('#image1').val(resp);
        $('.profile-avator').attr ( 'src' , resp);
        $('#cropImagePop').modal('hide');
        $('#uploadbtnImage').prop('disabled', false);
    });
});
$.ready(function () {
    setTimeout(function () {
        $('#hide').hide();
    }, 5000)
})