# project_CSE_Symfony

## Contexte
L’application doit permettre aux visiteurs du site d’obtenir des informations sur les offres sociales et culturelles proposées, par le CSE du lycée St-Vincent, à ses salariés.

## Installation
Pour installer le projet :
1. Cloner le projet
```
git clone https://github.com/BatMaxou/project_CSE_Symfony.git
```
2. Se déplacer dans le dossier du projet
```
cd project_CSE_Symfony/Project
```
3. Installer les dépendances
```
composer install
```
4. Modifier le fichier .env
```
DATABASE_URL="mysql://YOUR_LOGIN:YOUR_PASSWORD@YOUR_SERVER/YOUR_TABLE"

APP_EMAIL="YOUR_EMAIL"

MAILER_DSN="YOUR_MAILER_DSN"

TURNSTILE_KEY="YOUR_KEY"
TURNSTILE_SECRET="YOUR_SECRET"
```

## Création de la base de données
Pour créer ou refresh la base de données:
```
php bin/console app:database:refresh --force
```

## Données de test
1. Déplacer les images du fichier imagesTest:
    - imagesTest/member -> images/member
    - imagesTest/partnership -> images/partnership
    - imagesTest/ticketing -> images/ticketing
2. Pour créer ou refresh la base de données avec les datafixtures:
```
php bin/console app:load:datafixtures --force
```
3. Le dossier imagesTest peut ensuite être supprimé

## Lancer le projet
1. S'assurer que:
    - une version de PHP 8.1 ou plus est installée
    - Le projet est installé
    - La base de données est créée
2. Démarrer le projet
```
symfony serve
```