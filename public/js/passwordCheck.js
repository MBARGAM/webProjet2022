
$(function() {

    /* fonction permettant de verifier si les mots de passe sont tel que demandé
    mdp entre 7-15 caracteres , au moin une lettre et un caractere special*/

    $.fn.is_PasswordValid=function(pwd){

        let  test=  /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{7,15}$/;
        if(pwd.match(test))
        {
            return true;
        }else{
            return false;
        }
    }

    var internautePwdCheck = $('#login_prestatataire_mdp');
    var prestatairePwdCheck = $('#login_internaute_mdp');
    var internauteSubmitButton = $('#login_prestatataire_submit');
    var prestataireSubmitButton = $('#login_internaute_submit');
   // console.log(internautePwdCheck);

    internautePwdCheck.on('keyup', function (e) {

        if ( internautePwdCheck.val() !== ""){
            var checkResult  = $.fn.is_PasswordValid(internautePwdCheck.val());
            console.log(checkResult);
            if(checkResult){
                internautePwdCheck.css('border', '2px solid green');
                internauteSubmitButton.prop('disabled', false);
            }else{
                internautePwdCheck.css('border',  '2px solid red');
                internauteSubmitButton.prop('disabled', true);
            }
        }else{
            internautePwdCheck.css('border', '2px solid #ced4da');
            internauteSubmitButton.prop('disabled', true);
        }

    });

    prestatairePwdCheck.on('keyup', function (e) {

            if ( prestatairePwdCheck.val() !== ""){
                var checkResult  = $.fn.is_PasswordValid(prestatairePwdCheck.val());
                console.log(checkResult);
                if(checkResult){
                    prestatairePwdCheck.css('border', '2px solid green');
                    prestataireSubmitButton.prop('disabled', false);
                }else{
                    prestatairePwdCheck.css('border',  '2px solid red');
                    prestataireSubmitButton.prop('disabled', true);
                }
            }else{
                prestatairePwdCheck.css('border', '2px solid #ced4da');
                prestataireSubmitButton.prop('disabled', true);
            }

    });

});

