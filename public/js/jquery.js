$(function(){
    var cp = $('#search_cp');
   cp.on('change',function (e) {
       e.preventDefault();
    console.log(cp.val());
       $.ajax({
           method: 'GET',

           url: 'accueil/cp/'+cp.val(),
           success: function(response) {

           },
           error: function(xhr, status, error) {
               // Handle the error
           }
       });

   });
    console.log(cp.val());
    $.ajax({
        method: 'GET',
        url:  'accueil/cp/'+cp.val(),
        success: function(response) {
        },
        error: function(xhr, status, error) {
            // Handle the error
        }
    });
})
