<?php

namespace App\Domain\Admin\Repositories;

use App\Domain\Admin\Models\Admin;

/**
 * Interface AdminRepositoryInterface
 * 
 * Cette interface définit les contrats pour les opérations liées aux administrateurs.
 * Elle permet de garantir que toute implémentation respecte ces méthodes, facilitant
 * ainsi la gestion et le remplacement des implémentations (par exemple, pour les tests).
 */
interface AdminRepositoryInterface
{
    /**
     * Recherche un administrateur par son adresse email.
     *
     * @param string $email L'adresse email de l'administrateur à rechercher.
     * @return Admin|null Retourne une instance d'Admin si trouvée, sinon null.
     */
    public function findByEmail(string $email): ?Admin;
}
