<?php

namespace App\Http\Controllers\Profile;

use App\Domain\Profile\Services\ProfileService;
use App\Http\Requests\Profile\ProfileRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

/**
 * Contrôleur pour gérer les opérations CRUD sur les profils.
 */
class ProfileController extends Controller
{
    /**
     * Instance du service de profil.
     *
     * @var ProfileService
     */
    private ProfileService $profileService;

    /**
     * Constructeur du contrôleur.
     *
     * @param ProfileService $profileService Service injecté pour gérer la logique métier des profils.
     */
    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    /**
     * Récupère tous les profils.
     *
     * @return JsonResponse Liste de tous les profils.
     */
    public function index(): JsonResponse
    {
        $profiles = $this->profileService->getAllProfiles();
        return response()->json($profiles, 200);
    }

    /**
     * Crée un nouveau profil.
     *
     * @param ProfileRequest $request Requête validée contenant les données du profil.
     * @return JsonResponse Le profil nouvellement créé.
     */
    public function store(ProfileRequest $request): JsonResponse
    {
        $profile = $this->profileService->createProfile($request->validated());
        return response()->json($profile, 201);
    }

    /**
     * Met à jour un profil existant.
     *
     * @param ProfileRequest $request Requête validée contenant les données mises à jour du profil.
     * @param int $id Identifiant du profil à mettre à jour.
     * @return JsonResponse Le profil mis à jour.
     */
    public function update(ProfileRequest $request, int $id): JsonResponse
    {
        $updatedProfile = $this->profileService->updateProfile($id, $request->validated());
        return response()->json($updatedProfile, 200);
    }

    /**
     * Supprime un profil.
     *
     * @param int $id Identifiant du profil à supprimer.
     * @return JsonResponse Réponse vide avec un code de statut 204 (No Content).
     */
    public function destroy(int $id): JsonResponse
    {
        $this->profileService->deleteProfile($id);
        return response()->json(null, 204);
    }
}
