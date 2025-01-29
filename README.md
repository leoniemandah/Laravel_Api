# API Laravel

Ce projet est une API Laravel utilisant une architecture Domain-Driven Design (DDD).

## Configuration

1. Clonez le repository
2. Copiez `.env.example` en `.env` et configurez votre base de données
3. Exécutez `composer install`
4. Exécutez `php artisan key:generate`
5. Exécutez `php artisan migrate --seed`
6. Exécutez `php artisan storage:link`

## Endpoints

- POST /api/register : Inscription d'un administrateur
- POST /api/login : Connexion d'un administrateur
- GET /api/profiles : Liste des profils actifs (public)
- POST /api/profiles : Création d'un profil (authentifié)
- PUT /api/profiles/{id} : Mise à jour d'un profil (authentifié)
- DELETE /api/profiles/{id} : Suppression d'un profil (authentifié)

## Pour démarrer le serveur 

Une fois les dépendances installées et l'environnement configuré, vous pouvez lancer le projet :

`php artisan serve`

Démarrage du serveur Laravel localement à l'adresse http://localhost:8000.


## Tests

Exécutez `php artisan test` pour lancer les tests unitaires.


