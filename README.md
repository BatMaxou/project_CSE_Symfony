# project_CSE_Symfony

## Contexte
L’application doit permettre aux visiteurs du site d’obtenir des informations sur les offres sociales et culturelles proposées, par le CSE du lycée St-Vincent, à ses salariés.

## Installation
Pour installer le projet :
1. Cloner le projet
```
git clone https://github.com/BatMaxou/project_CSE_Symfony.git
```
2. Installer les dépendances
```
composer install
```
3. Lancer le projet
```
symfony serve
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

3. Le dossier imagesTest peut être ensuite supprimé