
/* script permettant de verifier la  nommenclature correcte d un email et sa verification en ds*/
$(function(){
      var email = $('#preinscription_email');
      var submit = $('#preinscription_submit');
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
                      msg.html('Email Valide');
                      msg.css('color', 'green', 'background-color', 'light-green');

                  }else{
                      email.css('border',  '2px solid red');
                      submit.prop('disabled', true);
                      msg.html('Email Invalide');
                        msg.css('color', 'red', 'background-color', 'light-red');
                        msg.show();
                  }
              }
          });

      }

    })

});

