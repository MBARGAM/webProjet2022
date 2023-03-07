$(function(){
    var inputLogo = $('#image_logo');
    var inputPhoto = $('#image_photo');
    var inputDocument= $('#promotion_document');
    var inputCategorie= $('#categorie_photo');

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
    inputCategorie.on("change", function () {
        var filename = inputCategorie.val().replace('C:\\fakepath\\', '').trim();
        inputCategorie.parent().find('.custom-file-label').html(filename);
    });
});