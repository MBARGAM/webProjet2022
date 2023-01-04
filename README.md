# webProjet2022
<<<<<<< Updated upstream
=======
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
- via l invite taper la commande : npm   afin d'activer sass et les fichiers y afferents
--------------------------------------------------------------------------------------------------------
>>>>>>> Stashed changes
