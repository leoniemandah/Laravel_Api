<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Classe LoginRequest
 * 
 * Cette classe gère la validation des données pour la requête de connexion des administrateurs.
 * Elle étend FormRequest de Laravel pour bénéficier des fonctionnalités de validation intégrées.
 */
class LoginRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête.
     *
     * @return bool Retourne toujours true car cette requête est accessible à tous les utilisateurs.
     */
    public function authorize(): bool
    {
        return true; // Autorise tous les utilisateurs à accéder à cette requête.
    }

    /**
     * Définit les règles de validation pour la requête de connexion.
     *
     * @return array Un tableau associatif contenant les règles de validation pour chaque champ.
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            // L'email est obligatoire et doit être un format d'email valide.
            'password' => 'required|string|min:6',
            // Le mot de passe est obligatoire, doit être une chaîne de caractères et avoir au moins 6 caractères.
        ];
    }
}
