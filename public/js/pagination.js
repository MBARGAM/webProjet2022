document.addEventListener('DOMContentLoaded', function() {

    var NoPage =  document.getElementById('NoPage');
    var suivant = document.getElementById('suivant');
    var precedent = document.getElementById('precedent');



    suivant.addEventListener('click', function() {
            if( NoPage.content ==" "){
                NoPage.remove();
            }
            precedent.classList.add("disabled");
    });

    NoPage.addEventListener('click', function() {
        NoPage.classList.remove("text-white");
        NoPage.classList.remove("bg- #0D2816");
        NoPage.classList.remove("Active");
        NoPage.classList.add("text-white");
        NoPage.classList.add("bg- #0D2816");
        NoPage.classList.add("Active");
    });

});