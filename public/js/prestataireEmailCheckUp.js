$(function(){
    //script permettant de verifier la  nommenclature correcte d un email du prestataire

    var email = $('#prestataire_preinnscription_email');
    var submit = $('#prestataire_preinnscription_submit');
    var msg =$('.msgEmailCheck');
    email.on('keyup', function (e) {
        e.preventDefault();

        console.log(email.val());
        if(email.val() === ''){
            email.css('border', '1px solid #ced4da');
        }else{
            $.ajax({
                url: 'email/'+email.val(),
                type: 'POST',
                success: function (data) {

                    if(data == 'true'){
                        email.css('border',  '2px solid green');
                        submit.prop('disabled', false);
                        msg.html('valide');
                        msg.css('color', 'green');
                    }else{
                        email.css('border',  '2px solid red');
                        submit.prop('disabled', true);
                        msg.html('Invalide');
                        msg.css('color', 'red');
                    }
                }
            });
        }
    })
});