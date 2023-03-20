ETAPES D'INSTALLATION DU PROJET WEB 2022 

1- Introduction

 Ce document fournit des instructions étape par étape sur la façon de cloner le projet web 2022 à partir de GitHub.

2- Prérequis

 Avant de commencer, assurez-vous que vous avez les éléments suivants:

- Git installé sur votre ordinateur
- serveur Apache et mysql installé sur votre ordinateur

3- Clonage du projet : 

 pour cloner le projet proceder comme suit :

Ouvrez une ligne de commande sur votre ordinateur et accédez au répertoire où vous souhaitez cloner le projet.
Tapez la commande suivante pour cloner le  projet avec Git:

* git clone https://github.com/MBARGAM/webProjet2022.git
* 
Une fois la commande exécutée, vous devriez voir le projet cloné dans votre répertoire.

* Accédez au répertoire du projet cloné à partir de la ligne de commande.
* 
Tapez les 4 commandes suivante pour installer les dépendances du projet avec Composer:

1) composer install

2) composer require symfony/webpack-encore-bundle

3) npm install sass-loader sass webpack --save-dev

4) npm run watch


* Modifiez les paramètres de configuration dans le fichier .env en fonction de votre configuration de base de données, si nécessaire.

pour les bases de données :

* creer une base de donnee grace a la commande  php bin/console doctrine:database:create

* Faire migrer les migtrations  avec la commande  php bin/console doctrine:migrations:migrate


* Importer le fichier fichier.sql se trouvant dans   /public/sql/  dans la base de donnee

Tapez la commande suivante pour démarrer le serveur de développement de Symfony:

* symfony server:start








* Accédez à l'adresse indiquée dans votre navigateur Web pour accéder à votre application Symfony.
Conclusion



