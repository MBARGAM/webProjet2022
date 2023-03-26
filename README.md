## ETAPES D'INSTALLATION DU PROJET WEB 2022 - 2023

* Introduction

 Ce document fournit des instructions étape par étape sur la façon de cloner le projet web 2022 à partir de GitHub.

## Tuto pour l'installation de symfony et nodejs

# Sur Mac os et windows

- la version de symfony utilisée est la 5.4  et la version de nodejs est la 14.17.6

# sur Linux

   symfony doit être installé (attention avec la version 12 npm plante, il faut la 16)

# https://aymeric-cucherousset.fr/installer-symfony-6-sur-debian-11/
# Installer nodejs sous linux Debian 11
# https://www.rosehosting.com/blog/how-to-install-node-js-and-npm-on-debian-11/


## Prérequis pour que cela fonctionne en fonction de votre OS
#  ----------------------------------
# 	Soft		Version
#	-----------------------
# 	nodejs  	v16.19.1
#	symfony		5.5.1 (sur LINUX)
#	Apache		2.4.54 (Debian)
#	PHP 		8.2.3 sur Debian 11

#   Apache		2.4.48 (MAC OS X)
#	PHP 		8.0.8 s(MAC OS X) 
#	MariaDB		10.5.18
#  MySQL   5.7.34

 Avant de commencer, assurez-vous que vous avez les éléments suivants:

  - Git installé sur votre ordinateur

  - Composer installé sur votre ordinateur

  - Node.js installé sur votre ordinateur

  - serveur Apache et mysql installé sur votre ordinateur

* Clonage du projet : 

 pour cloner le projet , procedez comme suit :

1) Ouvrez la ligne de commande sur votre ordinateur et copier/coller la commande suivante afin de telecharger le projet : 

  - git clone https://github.com/MBARGAM/webProjet2022.git

Une fois la commande exécutée, vous devriez voir le projet cloné dans votre répertoire.

2) Ouvrir votre IDE  et charger le projet cloné ou acceder au projet cloné avec votre ligne de commande

   1) Tapez les 4 commandes suivantes pour installer les dépendances du projet avec Composer:

      - composer install

            --pour installer webpack encore
      - composer require symfony/webpack-encore-bundle   

           --pour activer sass dans webpack encore
      - npm install sass-loader sass webpack --save-dev    

      - npm run watch
    
  
4) Tapez la commande suivante pour démarrer le serveur de développement de Symfony:

   - symfony server:start
   
5) Modifiez les paramètres de configuration dans le fichier .env en fonction de la base de données que vous souhaitez utiliser

   sur le ligne :  DATABASE_URL="mysql://root:root@127.0.0.1:8889/projetweb2022?serverVersion=8&charset=utf8mb4"  , modifier les parametres suivant :

   NB: faire attention au port de votre base de données

   - soit vous mettez la ligne en commentaire si vous utilisez une autre base de donnee autre que mysql 

   - soit vous modifiez les parametres suivant afin de definir le nom de votre base de données  :

           DATABASE_URL="mysql://votreIdentifiant:votreMotDePasse@adresseEnLocal/nomDeVotreBase?serverVersion=8&charset=utf8mb4"

7) Créer une base de donnee grace a la commande : 

   - php bin/console doctrine:database:create

8) Faire migrer les migtrations  avec la commande :

-    php bin/console doctrine:migrations:migrate

  1) Importer le fichier fichier.sql se trouvant dans   /public/sql/  dans la base de données que vous avez créée afin de remplir la base de données avec des
   
     - correspondant aux communes , provinces et codes postaux belges.
     - une catégorie de produits par défaut.
     - un administrateur par défaut avec les identifiants suivants: 
     
     ## identifiant: admin@admin.be  
     ##  mot de passe: admin


   
9)  Accédez à l'adresse indiquée dans votre navigateur Web pour accéder à votre application Symfony.

EX:  http://127.0.0.1:8000/  ou un autre port si vous avez modifié le port par défaut




## SUR LINUX suivre la proceduire suivante  est applicable: 

## Connexion au serveur distant
#  ----------------------------
-  ssh aiko@192.168.1.37 (connexion serveur à distance pour test LAN)		

## Commandes à exécuter sur 192.168.1.37
#  -------------------------------------
 - mkdir ~/Projet && cd Projet (création du dossier projet)		

 - git clone https://github.com/MBARGAM/webProjet2022.git (dump des sources)	

 - composer update 
 
 - composer install 

 - composer require symfony/webpack-encore-bundle	

 - npm install sass-loader sass webpack --save-dev 		

 - npm run watch									

## Commande bash pour installer tout en une seule fois
#  ---------------------------------------------------
- mkdir ~/Projet && cd Projet && git clone https://github.com/MBARGAM/webProjet2022.git && cd webProjet2022 && composer update && composer install && composer require symfony/webpack-encore-bundle && npm install sass-loader sass webpack --save-dev && npm run watch

## Lancemant du serveur symfony en mode daemon
#  -------------------------------------------
 -  symfony server:start -d (pour le starter en daemon)

## Edition du .env
#  ---------------
# vim .env
# MariaDB port: 3306
# user:aiko pass:a										
# DATABASE_URL="mysql://aiko:a@127.0.0.1:3306/projetweb2022?serverVersion=8&charset=utf8mb4"	

## Création de la data base
#  ------------------------ 
 - php bin/console doctrine:database:create							
 - php bin/console doctrine:migrations:migrate							

## Envoi du fichier.sql par scp
#  ---------------------------- 
 - cd public/sql
 - scp fichier.sql@192.168.1.2:~

## Finalité sur 192.168.1.2
#  ------------------------
# importation de fichier.sql dans la DB avec PhpMyAdmin						
- http://192.168.1.37:8000									


