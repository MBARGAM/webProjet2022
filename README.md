ETAPES D'INSTALLATION DU PROJET WEB 2022 

* Introduction

 Ce document fournit des instructions étape par étape sur la façon de cloner le projet web 2022 à partir de GitHub.

* Prérequis

 Avant de commencer, assurez-vous que vous avez les éléments suivants:

  - Git installé sur votre ordinateur

  - serveur Apache et mysql installé sur votre ordinateur

* Clonage du projet : 

 pour cloner le projet , procedez comme suit :

1) Ouvrez la ligne de commande sur votre ordinateur et copier/coller la commande suivante afin de telecharger le projet : 

  - git clone https://github.com/MBARGAM/webProjet2022.git

Une fois la commande exécutée, vous devriez voir le projet cloné dans votre répertoire.

2) Ouvrir votre IDE  et charger le projet cloné ou acceder au projet cloné avec votre terminal

3) Tapez les 4 commandes suivante pour installer les dépendances du projet avec Composer:

   - composer install

   - composer require symfony/webpack-encore-bundle
  
   - npm install sass-loader sass webpack --save-dev

   - npm run watch
    
  
4) Tapez la commande suivante pour démarrer le serveur de développement de Symfony:

   - symfony server:start
   - 
5) Modifiez les paramètres de configuration dans le fichier .env en fonction de la base de données que vous souhaitez utiliser

   sur le ligne :  DATABASE_URL="mysql://root:root@127.0.0.1:8889/projetweb2022?serverVersion=8&charset=utf8mb4"  , modifier les parametres suivant :

   - soit vous mettez la ligne en commentaire si vous utilisez une autre base de donnee que mysql 

   - soit vous modifiez les parametres suivant afin de definir le nom de votre base de données  :

           DATABASE_URL="mysql://votreIdentifiant:votreMotDePasse@adresseEnLocal/nomDeVotreBase?serverVersion=8&charset=utf8mb4"

6) Créer une base de donnee grace a la commande : 

   - php bin/console doctrine:database:create

7) Faire migrer les migtrations  avec la commande :

    - php bin/console doctrine:migrations:migrate

8) Importer le fichier fichier.sql se trouvant dans   /public/sql/  dans la base de données que vous avez créée afin de remplir la base de données avec des
   
   correspondant aux communes , provinces et codes postaux belges.









* Accédez à l'adresse indiquée dans votre navigateur Web pour accéder à votre application Symfony.
Conclusion



