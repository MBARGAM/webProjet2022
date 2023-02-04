/* ce script permet de recuperer les donnees d un code postal et
 une requete ajax est effectue et l id de du code postal est automatoque envoye via une route
 , une requete sql est effectuée en BD afin de recuperer la province et les communes correspondantes */

$(function(){
    var cp = $('#search_cp');
    var selectElt = $('#search_nomCommune');
    var localiteElt = $('#search_nomLocalite');
  //console.log(selectElt);
   cp.on('change',function (e) {
       e.preventDefault();
   // console.log(cp.val());
       console.log('accueil/'+cp.val());
       $.ajax({
           method: 'POST',
           dataType: 'json',
           url:  'accueil/'+cp.val(),
           success: function(response) {
               //console.log(response);
                 var  commune = JSON.parse(response['commune']);
                 var  localite = JSON.parse(response['localite']);
                 selectElt.empty();
                 localiteElt.empty();
                 for (var i = 0; i < commune.length; i++) {
                       var option = commune[i];
                        selectElt.append('<option value="'+option.id+'">'+option.commune+'</option>');
                 }
                for (var i = 0; i < localite.length; i++) {
                      var option = localite[i];
                      localiteElt.append('<option value="'+option.id+'">'+option.localite+'</option>');
                }
           },
           error: function(xhr, status, error) {
               // Handle the error
           }
       });

   });

    $.ajax({
        method: 'POST',
        dataType: 'json',
        url:  'accueil/'+cp.val(),
        success: function(response) {
            var  commune = JSON.parse(response['commune']);
            var  localite = JSON.parse(response['localite']);
            selectElt.empty();
            localiteElt.empty();
            for (var i = 0; i < commune.length; i++) {
                var option = commune[i];
                selectElt.append('<option value="'+option.id+'">'+option.commune+'</option>');
            }
            for (var i = 0; i < localite.length; i++) {
                var option = localite[i];
                localiteElt.append('<option value="'+option.id+'">'+option.localite+'</option>');
            }

        },
        error: function(xhr, status, error) {
            // Handle the error
        }
    });
})
