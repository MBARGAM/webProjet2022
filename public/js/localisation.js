
document.addEventListener('DOMContentLoaded', function()
{
    function getAddress() {

        var communeCp= document.getElementById('cpCommuneUser');

        var cp = document.getElementById('cpUser');

        var localite = document.getElementById('localiteUser');

        var  rue = document.getElementById('rueUser');

        return rue.innerText.trim() + " " + cp.innerText.trim() + " " + localite.innerText.trim()
    }

    var address = getAddress();

    // Construire l'URL de l'API Nominatim
    var url = "https://nominatim.openstreetmap.org/search?q="+ address +"&format=json";

    console.log(url);

    fetch(url)
        .then(response => response.json())
        .then(data => {
            const result = data[0];
            console.log(`Latitude: ${result.lat}`);
            console.log(`Longitude: ${result.lon}`);

            // Créer la carte et l'attacher à la div avec l'id 'mapid'
            var mymap = L.map('mapid').setView([result.lat, result.lon], 13);

              // Ajouter une couche de carte (dans cet exemple, OpenStreetMap)
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom: 18,
                tileSize: 512,
                zoomOffset: -1
            }).addTo(mymap);

            // Ajouter un marqueur à l'emplacement [51.5, -0.09]
            L.marker([result.lat, result.lon]).addTo(mymap);

        })
        .catch(error => console.error(error));

});









