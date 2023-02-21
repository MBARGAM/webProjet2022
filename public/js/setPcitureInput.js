$(function(){
    var inputLogo = $('#image_logo');
    var inputPhoto = $('#image_photo');
    var inputDocument= $('#promotion_document');

    inputLogo.on("change", function () {
        var filename = inputLogo.val().replace('C:\\fakepath\\', '').trim();
        inputLogo.parent().find('.custom-file-label').html(filename);
    });

    inputPhoto.on("change", function () {
        var filename = inputPhoto.val().replace('C:\\fakepath\\', '').trim();
        inputPhoto.parent().find('.custom-file-label').html(filename);
    });
    inputDocument.on("change", function () {
        var filename = inputDocument.val().replace('C:\\fakepath\\', '').trim();
        inputDocument.parent().find('.custom-file-label').html(filename);
    });
});