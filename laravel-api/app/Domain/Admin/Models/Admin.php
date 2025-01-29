<?php

namespace App\Domain\Admin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Modèle représentant un administrateur dans le domaine.
 * 
 * Cette classe hérite de `Authenticatable` pour permettre l'authentification
 * et utilise les fonctionnalités de Laravel telles que les notifications,
 * les tokens API (Sanctum) et les factories.
 */
class Admin extends Authenticatable
{
    use Notifiable, HasApiTokens, HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',       // Nom de l'administrateur
        'email',      // Adresse email de l'administrateur
        'password',   // Mot de passe de l'administrateur (hashé)
    ];

    /**
     * Les attributs qui doivent être masqués lors de la sérialisation.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',         // Masque le mot de passe pour des raisons de sécurité
        'remember_token',   // Masque le token "remember me"
    ];

    /**
     * Les attributs qui doivent être convertis en types natifs.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime', // Convertit la date de vérification de l'email en objet DateTime
    ];
}
