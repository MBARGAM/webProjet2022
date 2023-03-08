/* ce script permet de recuperer de choisir et d'afficher le type de recherche souhaitée*/


$(function(){
    var btnRechercheRapide = $('#rechercheRapide');

    console.log(btnRechercheRapide);
    btnRechercheRapide.css('background-color','#0D2816');
    btnRechercheRapide.css('color','white');
    btnRechercheRapide.css('box-shadow','none');

    //ici on cache la recherche avancée par défaut


   btnRechercheRapide.click(function(){
       btnRechercheRapide.css('background-color','darkgreen ');
       btnRechercheAvancee.css('background-color','#0D2816');

   });

});
