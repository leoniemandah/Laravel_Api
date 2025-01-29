<?php

namespace App\Domain\Admin\Services;

use App\Domain\Admin\Repositories\AdminRepositoryInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;

/**
 * Service d'authentification des administrateurs.
 * 
 * Cette classe gère le processus d'authentification des administrateurs
 * en utilisant le repository d'administrateurs pour la récupération des données.
 */
class AdminService
{
    /**
     * L'interface du repository d'administrateurs.
     *
     * @var AdminRepositoryInterface
     */
    protected AdminRepositoryInterface $repository;

    /**
     * Constructeur du service.
     *
     * @param AdminRepositoryInterface $repository Le repository d'administrateurs à utiliser.
     */
    public function __construct(AdminRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Authentifie un administrateur avec son email et son mot de passe.
     *
     * @param string $email L'email de l'administrateur.
     * @param string $password Le mot de passe de l'administrateur.
     * @return string Le token d'authentification généré.
     * @throws AuthenticationException Si les identifiants sont incorrects.
     */
    public function authenticate(string $email, string $password): string
    {
        // Recherche de l'administrateur par son email
        $admin = $this->repository->findByEmail($email);

        // Vérification de l'existence de l'admin et de la correspondance du mot de passe
        if (!$admin || !Hash::check($password, $admin->password)) {
            throw new AuthenticationException('Les identifiants sont incorrects.');
        }

        // Création et retour d'un nouveau token d'authentification
        return $admin->createToken('admin-token')->plainTextToken;
    }
}
