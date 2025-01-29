<?php

namespace App\Domain\Admin\DTOs;

/**
 * Data Transfer Object (DTO) pour les informations de connexion d'un administrateur.
 * 
 * Cette classe encapsule les données nécessaires pour l'authentification d'un administrateur.
 */
class LoginDTO
{
    /**
     * Constructeur de la classe LoginDTO.
     *
     * @param string $email    L'adresse email de l'administrateur.
     * @param string $password Le mot de passe de l'administrateur.
     */
    public function __construct(
        public string $email,
        public string $password,
    ) {}
}
