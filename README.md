# webProjet2022
<<<<<<< HEAD
<<<<<<< Updated upstream
=======
=======
>>>>>>> 2a7b4b2e545143fdd1c4a2b8efdc52f74fe9ff60
# projetweb2022
Annuaire de bien être
# insription et creation d'un compte
# Langues
pour la langue , une classe langue a été crée afin de pouvoir traduire des mots  en fonction du choix
* 3 methodes sont crées :
- une pour traduire du francais a l anglais
- une autre de l anglais au francais
- un derniere concernant le choix effectué l'utilisateur
# 31-12_2022
indsertion des villes communes et codes postaux
recuperation des fichier format json
- traitement via la creation de la classe Adresse dans symfony
- creation de 3 methodes statique et insertion dans la bd via le controlleur Adresse
- fin de l insertion mise du code en veille 

#installation du projet 
-----------------------------------------------------------------------------
#aspect technique installation 
- telecharger le dossier de github le placer dans la racine server php (wamp , mamp)
- ouvrir l'invite de commande et acceder au dossier 
- une fois dans le dossier taper la commande  : composer install  
- aller dans le dossier .evn et configurer le base de donnee :DATABASE_URL="mysql://id:mdp@127.0.0.1:3306/nomdelabd?serverVersion=8&charset=utf8mb4"
- creer une base de donnee grace a la commande  : symfony console doctrine:database:create
- effectuer les migrations  :  symfony console doctrine:migration:migrate

* ACTIVER SASS
<<<<<<< HEAD
- via l invite taper la commande : npm   afin d'activer sass et les fichiers y afferents
--------------------------------------------------------------------------------------------------------
>>>>>>> Stashed changes
=======
- via l invite taper la commande : npm run watch   afin d'activer sass et les fichiers y afferents
--------------------------------------------------------------------------------------------------------
>>>>>>> 2a7b4b2e545143fdd1c4a2b8efdc52f74fe9ff60
> #selection des villes et codes postaux
> - recuperation des fichier format json
> - traitement via la creation de la classe Adresse dans symfony
> - creation de 3 methodes statique et insertion dans la bd via le controlleur Adresse
> - fin de l insertion mise du code en veille
> -utilisation de l ajax jquery pour la recherche des villes
> - recuperation des villes via le controlleur
> - affichage des villes dans le select
> - recuperation du code postal via le controlleur
> - affichage du code postal dans le select
> - recuperation de la ville et du code postal via le controlleur

> #inscription et creation d'un compte
> - creation de la classe User
> - creation du formulaire d'inscription
> - creation du bouton d'inscription
> - choix du role de l'utilisateur
> - redirection vers la page d'inscription
> - 
> - > #inscription et creation d'un compte> envoyer des mails> se connecter au serveur smtp> configurer le serveur smtp> dans l invite de commander taper la commande composer require symfony/mailer permmettant d'envoyer des mails> telecharger maim trap pour recuperer les mails envoyer (permet de capter les mails envoyer)<
> - creation de la classe mailer 
> - instanciaion de la classe mailer dans le controlleur

> #verification  de la nomenclature des mots de passe 
> > #verification  de la nomenclature des emails et verification de l'unicité de l'email
> procedure d envoi de l email
> - aller dans le fichier messenger.yaml
> #font awesome
> npm install @fortawesome/fontawesome-free @fortawesome/free-brands-svg-icons @fortawesome/free-regular-svg-icons @fortawesome/free-solid-svg-icons -D
@import '~@fortawesome/fontawesome-free/scss/fontawesome';
@import '~@fortawesome/fontawesome-free/scss/regular';
@import '~@fortawesome/fontawesome-free/scss/solid';
@import '~@fortawesome/fontawesome-free/scss/brands';
> -configurer les imageS dans le fichier config/routes/services.yaml
creer le dossier ou stocker les images
> make le chemin de l image dans le fichier config/routes/services.yaml
> > #logout configuration
> configurer le fichier security.yaml
> activate the  logout config parameter under your firewall:
> 
> 
> PAGINATION
> copier le pagination boostrap 
> creer un fichier js dans le dossier public et faire des evenements sur les li
> event surle bouton suivant et precedent qui permet de changer de page ajouter le disable sur le bouton suivant ou precedent
> et de supprimer les li qui ne sont pas dans la page actuelle
> event sur le numero de la page donc on veut afficherles resultats
> 
> 
> 
> css
>  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
     integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
     crossorigin=""/>

leaflet <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
     integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
     crossorigin=""></script>
 <div id="map"></div>
#map { height: 180px; }


var map = L.map('map').setView([51.505, -0.09], 13);
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
maxZoom: 19,
attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

var marker = L.marker([51.5, -0.09]).addTo(map);

js 
marker.bindPopup("<b>Hello world!</b><br>I am a popup.").openPopup();


var address = '1600 Amphitheatre Parkway, Mountain View, CA';
var url = 'https://nominatim.openstreetmap.org/search?q=' + address + '&format=json';

fetch(url)
.then(response => response.json())
.then(data => {
var latitude = data[0].lat;
var longitude = data[0].lon;
console.log("Latitude: " + latitude);
console.log("Longitude: " + longitude);
})
.catch(error => console.error(error));

js
$address = '1600 Amphitheatre Parkway, Mountain View, CA';
$url = 'https://nominatim.openstreetmap.org/search?q=' . urlencode($address) . '&format=json';

$response = json_decode(file_get_contents($url), true);


php
if (!empty($response)) {
$latitude = $response[0]['lat'];
$longitude = $response[0]['lon'];
echo "Latitude: " . $latitude . "<br>";
echo "Longitude: " . $longitude . "<br>";
} else {
echo "Geocode was not successful.";
}
