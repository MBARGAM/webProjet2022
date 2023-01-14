
$(function(){
    var cp = $('#search_cp');

   cp.on('change',function (e) {
       e.preventDefault();
    console.log(cp.val());
       $.ajax({
           method: 'POST',
           dataType: 'json',
           url:  'accueil/cp/'+cp.val(),
           success: function(response) {
               console.log(jsonParse(response));

           },
           error: function(xhr, status, error) {
               // Handle the error
           }
       });

   });
    console.log(cp.val());
    $.ajax({
        method: 'POST',
        dataType: 'json',
        url:  'accueil/cp/'+cp.val(),
        success: function(response) {
            console.log(jsonParse(response));
        },
        error: function(xhr, status, error) {
            // Handle the error
        }
    });
})
/*var $container = $('.js-vote-arrows');
$container.find('a').on('click', function(e) {
    e.preventDefault();
    var $link = $(e.currentTarget);
    $.ajax({
        url: '/article/10/vote/'+$link.data('direction'),
        method: 'POST'
    }).then(function(data) {
        $container.find('.js-vote-total').text(data.votes);
    });
});

*/