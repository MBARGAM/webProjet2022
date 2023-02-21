
document.addEventListener('DOMContentLoaded', function()
{
    function getAddress() {

        var communeCp= document.getElementById('cpCommuneUser');

        var  rue = document.getElementById('rueUser');

        var tab = [rue.textContent, communeCp.textContent];

        return rue.innerText + ' ' + communeCp.innerText;
    }


    var address = getAddress();

    console.log(address);

    var url = 'https://nominatim.openstreetmap.org/search?q='+address+'&format=json';

    console.log(url);
});






fetch(url)
    .then(response => response.json())
    .then(data => {
        var latitude = data[0].lat;
        var longitude = data[0].lon;
        console.log("Latitude: " + latitude);
        console.log("Longitude: " + longitude);
    })
    .catch(error => console.error(error));


